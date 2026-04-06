const Experience = require('../models/Experience');
const { NotFoundError }    = require('../utils/errors');
const { success, created, noContent } = require('../utils/apiResponse');
const catchAsync = require('../utils/catchAsync');

exports.getExperiences = catchAsync(async (req, res) => {
  const filter = req.user?.role === 'admin' ? {} : { isVisible: true };
  const experiences = await Experience.find(filter).sort({ startDate: -1 });
  success(res, { experiences });
});

exports.getExperience = catchAsync(async (req, res, next) => {
  const exp = await Experience.findById(req.params.id);
  if (!exp) return next(new NotFoundError('Experience'));
  success(res, { experience: exp });
});

exports.createExperience = catchAsync(async (req, res) => {
  const experience = await Experience.create(req.body);
  created(res, { experience }, 'Experience created');
});

exports.updateExperience = catchAsync(async (req, res, next) => {
  const experience = await Experience.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
  if (!experience) return next(new NotFoundError('Experience'));
  success(res, { experience }, 'Experience updated');
});

exports.deleteExperience = catchAsync(async (req, res, next) => {
  if (!await Experience.findByIdAndDelete(req.params.id)) return next(new NotFoundError('Experience'));
  noContent(res);
});
