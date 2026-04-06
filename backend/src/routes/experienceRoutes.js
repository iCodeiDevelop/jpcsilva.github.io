const router = require('express').Router();
const ctrl   = require('../controllers/experienceController');
const { optionalAuth } = require('../middleware/auth');

router.get('/',    optionalAuth, ctrl.getExperiences);
router.get('/:id', ctrl.getExperience);

module.exports = router;
