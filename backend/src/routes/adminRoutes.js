const router  = require('express').Router();
const { protect, restrictTo } = require('../middleware/auth');
const activityLog = require('../middleware/activityLogger');
const projectCtrl = require('../controllers/projectController');
const skillCtrl   = require('../controllers/skillController');
const expCtrl     = require('../controllers/experienceController');
const certCtrl    = require('../controllers/certificationController');
const blogCtrl    = require('../controllers/blogController');
const profileCtrl = require('../controllers/profileController');
const analyticsCtrl = require('../controllers/analyticsController');
const { uploadMultiple, uploadSingle } = require('../middleware/upload');
const { uploadLimiter } = require('../middleware/rateLimiter');

// All admin routes require auth + admin/editor role
router.use(protect, restrictTo('admin', 'editor'));

// Profile
router.put('/profile', restrictTo('admin'), activityLog('UPDATE','profile'), profileCtrl.upsertProfile);

// Projects
router.post('/projects',              activityLog('CREATE','project'), projectCtrl.createProject);
router.patch('/projects/:id',         activityLog('UPDATE','project'), projectCtrl.updateProject);
router.delete('/projects/:id',        restrictTo('admin'), activityLog('DELETE','project'), projectCtrl.deleteProject);
router.patch('/projects/:id/status',  activityLog('UPDATE','project'), projectCtrl.updateStatus);
router.post('/projects/:id/images',   uploadLimiter, uploadMultiple, activityLog('UPLOAD','project'), projectCtrl.addImages);

// Skills
router.post('/skills',         activityLog('CREATE','skill'), skillCtrl.createSkill);
router.patch('/skills/:id',    activityLog('UPDATE','skill'), skillCtrl.updateSkill);
router.delete('/skills/:id',   restrictTo('admin'), activityLog('DELETE','skill'), skillCtrl.deleteSkill);
router.patch('/skills/order',  skillCtrl.bulkOrder);

// Experience
router.post('/experiences',         activityLog('CREATE','experience'), expCtrl.createExperience);
router.patch('/experiences/:id',    activityLog('UPDATE','experience'), expCtrl.updateExperience);
router.delete('/experiences/:id',   restrictTo('admin'), activityLog('DELETE','experience'), expCtrl.deleteExperience);

// Certifications
router.post('/certifications',       activityLog('CREATE','certification'), certCtrl.createCertification);
router.patch('/certifications/:id',  activityLog('UPDATE','certification'), certCtrl.updateCertification);
router.delete('/certifications/:id', restrictTo('admin'), activityLog('DELETE','certification'), certCtrl.deleteCertification);

// Blog
router.post('/blogs',        activityLog('CREATE','blog'), blogCtrl.createBlog);
router.patch('/blogs/:id',   activityLog('UPDATE','blog'), blogCtrl.updateBlog);
router.delete('/blogs/:id',  restrictTo('admin'), activityLog('DELETE','blog'), blogCtrl.deleteBlog);

// Analytics
router.get('/analytics', restrictTo('admin'), analyticsCtrl.getDashboardStats);

module.exports = router;
