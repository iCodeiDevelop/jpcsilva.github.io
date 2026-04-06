const jwt      = require('jsonwebtoken');
const crypto   = require('crypto');
const User     = require('../models/User');
const { AppError } = require('../utils/errors');
const { success } = require('../utils/apiResponse');
const catchAsync   = require('../utils/catchAsync');
const logger       = require('../config/logger');
const ActivityLog  = require('../models/ActivityLog');

const COOKIE_OPTIONS = {
  httpOnly: true,
  secure:   process.env.NODE_ENV === 'production',
  sameSite: 'strict',
  maxAge:   7 * 24 * 60 * 60 * 1000, // 7 days
};

/**
 * Issue access + refresh tokens and set cookies
 */
const createAndSendTokens = async (user, res, statusCode = 200, message = 'Authentication successful') => {
  const accessToken  = user.generateAccessToken();
  const refreshToken = user.generateRefreshToken();

  // Store refresh token (hashed) in DB
  const hashedRefresh = crypto.createHash('sha256').update(refreshToken).digest('hex');
  user.refreshTokens.push({
    token:     hashedRefresh,
    userAgent: res.req?.get('user-agent'),
  });
  // Keep max 5 refresh tokens per user (remove oldest)
  if (user.refreshTokens.length > 5) user.refreshTokens.shift();
  await user.save({ validateBeforeSave: false });

  res.cookie('refreshToken', refreshToken, COOKIE_OPTIONS);
  res.cookie('accessToken',  accessToken,  { ...COOKIE_OPTIONS, maxAge: 15 * 60 * 1000 });

  success(res, {
    user:         user.toJSON(),
    accessToken,
    expiresIn:    process.env.JWT_EXPIRES_IN || '15m',
  }, message, statusCode);
};

// ── POST /api/auth/register ───────────────────────────────
exports.register = catchAsync(async (req, res, next) => {
  const { name, email, password } = req.body;

  const existing = await User.findOne({ email });
  if (existing) return next(new AppError('An account with this email already exists.', 409));

  const user = await User.create({ name, email, password, role: 'editor' });

  await ActivityLog.create({ user: user._id, action: 'REGISTER', resource: 'user', ip: req.ip });

  createAndSendTokens(user, res, 201, 'Account created successfully');
});

// ── POST /api/auth/login ──────────────────────────────────
exports.login = catchAsync(async (req, res, next) => {
  const { email, password } = req.body;

  const user = await User.findOne({ email }).select('+password');
  if (!user) return next(new AppError('Invalid email or password.', 401));
  if (user.isLocked) {
    return next(new AppError('Account temporarily locked. Please try again later.', 423));
  }

  const isMatch = await user.comparePassword(password);
  if (!isMatch) {
    await user.incrementLoginAttempts();
    return next(new AppError('Invalid email or password.', 401));
  }

  if (!user.isActive) return next(new AppError('Account deactivated. Contact admin.', 401));

  // Reset lock on success
  if (user.loginAttempts > 0) {
    await user.updateOne({ $set: { loginAttempts: 0 }, $unset: { lockUntil: 1 } });
  }
  user.lastLogin = new Date();
  await ActivityLog.create({ user: user._id, action: 'LOGIN', resource: 'user', ip: req.ip, userAgent: req.get('user-agent') });

  logger.info(`User logged in: ${user.email} from ${req.ip}`);
  createAndSendTokens(user, res, 200, 'Logged in successfully');
});

// ── POST /api/auth/logout ─────────────────────────────────
exports.logout = catchAsync(async (req, res, next) => {
  const { refreshToken } = req.cookies;
  if (refreshToken) {
    const hashed = crypto.createHash('sha256').update(refreshToken).digest('hex');
    await User.updateOne({ _id: req.user._id }, { $pull: { refreshTokens: { token: hashed } } });
  }
  res.clearCookie('accessToken');
  res.clearCookie('refreshToken');
  success(res, null, 'Logged out successfully');
});

// ── POST /api/auth/refresh ────────────────────────────────
exports.refresh = catchAsync(async (req, res, next) => {
  const { refreshToken } = req.cookies;
  if (!refreshToken) return next(new AppError('No refresh token provided.', 401));

  let decoded;
  try {
    decoded = jwt.verify(refreshToken, process.env.JWT_REFRESH_SECRET);
  } catch {
    return next(new AppError('Invalid or expired refresh token.', 401));
  }

  const hashed = crypto.createHash('sha256').update(refreshToken).digest('hex');
  const user   = await User.findOne({
    _id: decoded.id,
    'refreshTokens.token': hashed,
    isActive: true,
  });
  if (!user) return next(new AppError('Refresh token not found or revoked.', 401));

  createAndSendTokens(user, res, 200, 'Token refreshed');
});

// ── GET /api/auth/me ──────────────────────────────────────
exports.getMe = catchAsync(async (req, res) => {
  const user = await User.findById(req.user.id);
  success(res, { user });
});

// ── PATCH /api/auth/me ────────────────────────────────────
exports.updateMe = catchAsync(async (req, res, next) => {
  const { name, avatar } = req.body;
  const user = await User.findByIdAndUpdate(
    req.user.id,
    { name, avatar },
    { new: true, runValidators: true }
  );
  success(res, { user }, 'Profile updated');
});

// ── POST /api/auth/change-password ────────────────────────
exports.changePassword = catchAsync(async (req, res, next) => {
  const { currentPassword, newPassword } = req.body;
  const user = await User.findById(req.user.id).select('+password');

  if (!(await user.comparePassword(currentPassword)))
    return next(new AppError('Current password is incorrect.', 401));

  user.password = newPassword;
  await user.save();
  await ActivityLog.create({ user: user._id, action: 'CHANGE_PASSWORD', resource: 'user', ip: req.ip });

  createAndSendTokens(user, res, 200, 'Password changed successfully');
});
