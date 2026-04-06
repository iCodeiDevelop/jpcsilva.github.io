const jwt     = require('jsonwebtoken');
const User    = require('../models/User');
const { AppError } = require('../utils/errors');
const logger  = require('../config/logger');

/**
 * Verify JWT access token from Authorization header or cookie
 */
exports.protect = async (req, res, next) => {
  try {
    let token;
    if (req.headers.authorization?.startsWith('Bearer ')) {
      token = req.headers.authorization.split(' ')[1];
    } else if (req.cookies?.accessToken) {
      token = req.cookies.accessToken;
    }
    if (!token) return next(new AppError('Authentication required. Please log in.', 401));

    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    const user    = await User.findById(decoded.id).select('+password');

    if (!user)           return next(new AppError('User belonging to this token no longer exists.', 401));
    if (!user.isActive)  return next(new AppError('Your account has been deactivated.', 401));
    if (user.changedPasswordAfter(decoded.iat)) {
      return next(new AppError('Password was recently changed. Please log in again.', 401));
    }
    if (user.isLocked)   return next(new AppError('Account is temporarily locked.', 423));

    req.user = user;
    next();
  } catch (error) {
    if (error.name === 'TokenExpiredError') {
      return next(new AppError('Your token has expired. Please log in again.', 401));
    }
    if (error.name === 'JsonWebTokenError') {
      return next(new AppError('Invalid token. Please log in again.', 401));
    }
    next(error);
  }
};

/**
 * Restrict access to specific roles
 * Usage: restrictTo('admin', 'editor')
 */
exports.restrictTo = (...roles) => (req, res, next) => {
  if (!roles.includes(req.user.role)) {
    return next(new AppError('You do not have permission to perform this action.', 403));
  }
  next();
};

/**
 * Optional auth — does not fail if no token, just sets req.user if valid
 */
exports.optionalAuth = async (req, res, next) => {
  try {
    let token;
    if (req.headers.authorization?.startsWith('Bearer ')) token = req.headers.authorization.split(' ')[1];
    if (!token) return next();
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    req.user = await User.findById(decoded.id);
  } catch (_) { /* ignore */ }
  next();
};
