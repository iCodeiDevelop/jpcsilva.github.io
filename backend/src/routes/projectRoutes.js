const router  = require('express').Router();
const ctrl    = require('../controllers/projectController');
const { protect, restrictTo, optionalAuth } = require('../middleware/auth');
const { uploadMultiple } = require('../middleware/upload');
const { uploadLimiter } = require('../middleware/rateLimiter');

// Public routes
router.get('/',    optionalAuth, ctrl.getProjects);
router.get('/:id', optionalAuth, ctrl.getProject);

module.exports = router;
