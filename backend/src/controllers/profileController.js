const Profile  = require('../models/Profile');
const { AppError }   = require('../utils/errors');
const { success, created } = require('../utils/apiResponse');
const catchAsync = require('../utils/catchAsync');

// ── GET /api/profile ──────────────────────────────────────
exports.getProfile = catchAsync(async (req, res) => {
  let profile = await Profile.findOne();
  if (!profile) {
    // Return empty profile template if none exists
    return success(res, { profile: null }, 'No profile found');
  }
  success(res, { profile });
});

// ── PUT /api/admin/profile ────────────────────────────────
exports.upsertProfile = catchAsync(async (req, res) => {
  let profile = await Profile.findOne();
  if (profile) {
    profile = await Profile.findByIdAndUpdate(profile._id, req.body, { new: true, runValidators: true });
    return success(res, { profile }, 'Profile updated');
  }
  profile = await Profile.create(req.body);
  created(res, { profile }, 'Profile created');
});
