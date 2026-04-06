const Analytics   = require('../models/Analytics');
const ActivityLog = require('../models/ActivityLog');
const Project     = require('../models/Project');
const Blog        = require('../models/Blog');
const { success } = require('../utils/apiResponse');
const catchAsync  = require('../utils/catchAsync');

exports.getDashboardStats = catchAsync(async (req, res) => {
  const thirtyDaysAgo = new Date(Date.now() - 30 * 24 * 60 * 60 * 1000);

  const [
    totalViews, recentViews, projectViews, blogViews,
    contactSubmits, totalProjects, totalBlogs,
    topProjects, topBlogs, recentActivity,
    viewsByDay,
  ] = await Promise.all([
    Analytics.countDocuments({ type: 'page_view' }),
    Analytics.countDocuments({ type: 'page_view', createdAt: { $gte: thirtyDaysAgo } }),
    Analytics.countDocuments({ type: 'project_view' }),
    Analytics.countDocuments({ type: 'blog_view' }),
    Analytics.countDocuments({ type: 'contact_submit' }),
    Project.countDocuments({ status: 'published' }),
    Blog.countDocuments({ status: 'published' }),
    Project.find().sort({ 'stats.views': -1 }).limit(5).select('title stats.views category'),
    Blog.find({ status:'published' }).sort({ 'stats.views': -1 }).limit(5).select('title stats.views category'),
    ActivityLog.find().sort({ createdAt: -1 }).limit(20).populate('user', 'name email'),
    Analytics.aggregate([
      { $match: { type: 'page_view', createdAt: { $gte: thirtyDaysAgo } } },
      { $group: { _id: { $dateToString: { format: '%Y-%m-%d', date: '$createdAt' } }, count: { $sum: 1 } } },
      { $sort: { '_id': 1 } },
    ]),
  ]);

  success(res, {
    overview: { totalViews, recentViews, projectViews, blogViews, contactSubmits, totalProjects, totalBlogs },
    topProjects, topBlogs,
    recentActivity,
    viewsByDay,
  });
});

exports.getUserStats = catchAsync(async (req, res) => {
  const logs = await ActivityLog.find({ user: req.user._id })
    .sort({ createdAt: -1 }).limit(50);
  success(res, { activityLogs: logs });
});
