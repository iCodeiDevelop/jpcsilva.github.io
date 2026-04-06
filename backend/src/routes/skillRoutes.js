const router = require('express').Router();
const ctrl   = require('../controllers/skillController');
const { optionalAuth } = require('../middleware/auth');

router.get('/',  optionalAuth, ctrl.getSkills);
router.get('/:id', ctrl.getSkill);

module.exports = router;
