const Certification = require('../models/Certification');
const { NotFoundError }    = require('../utils/errors');
const { success, created, noContent } = require('../utils/apiResponse');
const catchAsync = require('../utils/catchAsync');

exports.getCertifications = catchAsync(async (req, res) => {
  const filter = req.user?.role === 'admin' ? {} : { isVisible: true };
  const certs  = await Certification.find(filter).sort({ issueDate: -1 });
  success(res, { certifications: certs });
});

exports.getCertification = catchAsync(async (req, res, next) => {
  const cert = await Certification.findById(req.params.id);
  if (!cert) return next(new NotFoundError('Certification'));
  success(res, { certification: cert });
});

exports.createCertification = catchAsync(async (req, res) => {
  const certification = await Certification.create(req.body);
  created(res, { certification }, 'Certification added');
});

exports.updateCertification = catchAsync(async (req, res, next) => {
  const cert = await Certification.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
  if (!cert) return next(new NotFoundError('Certification'));
  success(res, { certification: cert }, 'Certification updated');
});

exports.deleteCertification = catchAsync(async (req, res, next) => {
  if (!await Certification.findByIdAndDelete(req.params.id)) return next(new NotFoundError('Certification'));
  noContent(res);
});
