const router = require('express').Router();
const ctrl   = require('../controllers/blogController');
const { optionalAuth } = require('../middleware/auth');

router.get('/',       optionalAuth, ctrl.getBlogs);
router.get('/tags',   ctrl.getTags);
router.get('/:id',    optionalAuth, ctrl.getBlog);

module.exports = router;
