const Project  = require('../models/Project');
const { AppError, NotFoundError } = require('../utils/errors');
const { success, created, paginated, noContent } = require('../utils/apiResponse');
const { getPaginationParams, buildPaginationMeta } = require('../utils/pagination');
const catchAsync = require('../utils/catchAsync');
const Analytics  = require('../models/Analytics');

// ── GET /api/projects ─────────────────────────────────────
exports.getProjects = catchAsync(async (req, res) => {
  const { page, limit, skip, sort } = getPaginationParams(req.query);

  const filter = {};
  // Public: only published; admin: all
  if (!req.user || req.user.role === 'viewer') filter.status = 'published';
  if (req.query.category) filter.category = req.query.category;
  if (req.query.featured)  filter.featured = req.query.featured === 'true';
  if (req.query.tech)      filter['techStack.name'] = { $regex: req.query.tech, $options: 'i' };
  if (req.query.search) {
    filter.$or = [
      { title:       { $regex: req.query.search, $options: 'i' } },
      { description: { $regex: req.query.search, $options: 'i' } },
      { 'techStack.name': { $regex: req.query.search, $options: 'i' } },
    ];
  }

  const [projects, total] = await Promise.all([
    Project.find(filter).sort(sort).skip(skip).limit(limit).populate('createdBy', 'name email'),
    Project.countDocuments(filter),
  ]);

  paginated(res, { projects }, buildPaginationMeta(total, page, limit));
});

// ── GET /api/projects/:slug ───────────────────────────────
exports.getProject = catchAsync(async (req, res, next) => {
  const query    = { $or: [{ slug: req.params.id }, { _id: req.params.id.match(/^[0-9a-fA-F]{24}$/) ? req.params.id : undefined }].filter(Boolean) };
  const project  = await Project.findOne(query).populate('createdBy', 'name email');
  if (!project) return next(new NotFoundError('Project'));

  // Increment view count & log analytics (non-blocking)
  Project.findByIdAndUpdate(project._id, { $inc: { 'stats.views': 1 } }).exec();
  Analytics.create({ type: 'project_view', target: project.slug, targetId: project._id, ip: req.ip, userAgent: req.get('user-agent') }).catch(() => {});

  success(res, { project });
});

// ── POST /api/admin/projects ──────────────────────────────
exports.createProject = catchAsync(async (req, res) => {
  const project = await Project.create({ ...req.body, createdBy: req.user._id });
  created(res, { project }, 'Project created successfully');
});

// ── PATCH /api/admin/projects/:id ────────────────────────
exports.updateProject = catchAsync(async (req, res, next) => {
  const project = await Project.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
  if (!project) return next(new NotFoundError('Project'));
  success(res, { project }, 'Project updated');
});

// ── DELETE /api/admin/projects/:id ───────────────────────
exports.deleteProject = catchAsync(async (req, res, next) => {
  const project = await Project.findByIdAndDelete(req.params.id);
  if (!project) return next(new NotFoundError('Project'));
  noContent(res);
});

// ── PATCH /api/admin/projects/:id/status ─────────────────
exports.updateStatus = catchAsync(async (req, res, next) => {
  const { status } = req.body;
  const project = await Project.findByIdAndUpdate(req.params.id, { status }, { new: true });
  if (!project) return next(new NotFoundError('Project'));
  success(res, { project }, `Project ${status}`);
});

// ── POST /api/admin/projects/:id/images ──────────────────
exports.addImages = catchAsync(async (req, res, next) => {
  const project = await Project.findById(req.params.id);
  if (!project) return next(new NotFoundError('Project'));

  const files = req.files || (req.file ? [req.file] : []);
  const images = files.map((f, i) => ({
    url:       `/uploads/images/${f.filename}`,
    alt:       req.body.alt || project.title,
    isPrimary: i === 0 && project.images.length === 0,
  }));
  project.images.push(...images);
  await project.save();
  success(res, { project }, 'Images uploaded');
});
