const Blog     = require('../models/Blog');
const { NotFoundError }    = require('../utils/errors');
const { success, created, paginated, noContent } = require('../utils/apiResponse');
const { getPaginationParams, buildPaginationMeta } = require('../utils/pagination');
const catchAsync = require('../utils/catchAsync');
const Analytics  = require('../models/Analytics');

exports.getBlogs = catchAsync(async (req, res) => {
  const { page, limit, skip, sort } = getPaginationParams(req.query);
  const isAdmin = req.user?.role !== 'viewer';
  const filter  = isAdmin ? {} : { status: 'published' };

  if (req.query.category) filter.category = req.query.category;
  if (req.query.tag)      filter.tags = req.query.tag;
  if (req.query.featured) filter.featured = req.query.featured === 'true';
  if (req.query.search) {
    filter.$text = { $search: req.query.search };
  }

  const [blogs, total] = await Promise.all([
    Blog.find(filter).sort(sort).skip(skip).limit(limit)
        .populate('createdBy', 'name').select('-content'),
    Blog.countDocuments(filter),
  ]);

  paginated(res, { blogs }, buildPaginationMeta(total, page, limit));
});

exports.getBlog = catchAsync(async (req, res, next) => {
  const blog = await Blog.findOne({
    $or: [{ slug: req.params.id }, ...(req.params.id.match(/^[0-9a-fA-F]{24}$/) ? [{ _id: req.params.id }] : [])],
  }).populate('createdBy', 'name');
  if (!blog) return next(new NotFoundError('Blog post'));

  Blog.findByIdAndUpdate(blog._id, { $inc: { 'stats.views': 1 } }).exec();
  Analytics.create({ type: 'blog_view', target: blog.slug, targetId: blog._id, ip: req.ip }).catch(() => {});

  success(res, { blog });
});

exports.createBlog = catchAsync(async (req, res) => {
  const blog = await Blog.create({ ...req.body, createdBy: req.user._id });
  created(res, { blog }, 'Blog post created');
});

exports.updateBlog = catchAsync(async (req, res, next) => {
  const blog = await Blog.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
  if (!blog) return next(new NotFoundError('Blog post'));
  success(res, { blog }, 'Blog post updated');
});

exports.deleteBlog = catchAsync(async (req, res, next) => {
  if (!await Blog.findByIdAndDelete(req.params.id)) return next(new NotFoundError('Blog post'));
  noContent(res);
});

exports.getTags = catchAsync(async (req, res) => {
  const tags = await Blog.aggregate([
    { $match: { status: 'published' } },
    { $unwind: '$tags' },
    { $group: { _id: '$tags', count: { $sum: 1 } } },
    { $sort: { count: -1 } },
    { $limit: 30 },
  ]);
  success(res, { tags });
});
