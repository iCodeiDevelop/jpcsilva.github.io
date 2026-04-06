const express = require('express');
const router  = express.Router();

router.use('/auth',           require('./authRoutes'));
router.use('/profile',        require('./profileRoutes'));
router.use('/projects',       require('./projectRoutes'));
router.use('/skills',         require('./skillRoutes'));
router.use('/experiences',    require('./experienceRoutes'));
router.use('/certifications', require('./certificationRoutes'));
router.use('/blogs',          require('./blogRoutes'));
router.use('/contact',        require('./contactRoutes'));
router.use('/admin',          require('./adminRoutes'));

// Health check
router.get('/health', (req, res) => res.json({
  status: 'ok',
  timestamp: new Date().toISOString(),
  uptime: process.uptime(),
  environment: process.env.NODE_ENV,
}));

module.exports = router;
