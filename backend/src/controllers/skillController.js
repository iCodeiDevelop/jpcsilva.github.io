const Skill   = require('../models/Skill');
const { NotFoundError }    = require('../utils/errors');
const { success, created, noContent } = require('../utils/apiResponse');
const catchAsync = require('../utils/catchAsync');

exports.getSkills = catchAsync(async (req, res) => {
  const filter = { isVisible: true };
  if (req.user?.role === 'admin') delete filter.isVisible;
  if (req.query.category) filter.category = req.query.category;
  if (req.query.featured)  filter.featured = req.query.featured === 'true';

  const skills = await Skill.find(filter).sort({ category: 1, order: 1 });
  const grouped = skills.reduce((acc, skill) => {
    if (!acc[skill.category]) acc[skill.category] = [];
    acc[skill.category].push(skill);
    return acc;
  }, {});
  success(res, { skills, grouped });
});

exports.getSkill    = catchAsync(async (req, res, next) => {
  const skill = await Skill.findById(req.params.id);
  if (!skill) return next(new NotFoundError('Skill'));
  success(res, { skill });
});

exports.createSkill = catchAsync(async (req, res) => {
  const skill = await Skill.create(req.body);
  created(res, { skill }, 'Skill created');
});

exports.updateSkill = catchAsync(async (req, res, next) => {
  const skill = await Skill.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
  if (!skill) return next(new NotFoundError('Skill'));
  success(res, { skill }, 'Skill updated');
});

exports.deleteSkill = catchAsync(async (req, res, next) => {
  if (!await Skill.findByIdAndDelete(req.params.id)) return next(new NotFoundError('Skill'));
  noContent(res);
});

exports.bulkOrder = catchAsync(async (req, res) => {
  const { items } = req.body; // [{ id, order }]
  await Promise.all(items.map(({ id, order }) => Skill.findByIdAndUpdate(id, { order })));
  success(res, null, 'Order updated');
});
