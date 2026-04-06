const router = require('express').Router();
const ctrl   = require('../controllers/certificationController');
const { optionalAuth } = require('../middleware/auth');

router.get('/',    optionalAuth, ctrl.getCertifications);
router.get('/:id', ctrl.getCertification);

module.exports = router;
