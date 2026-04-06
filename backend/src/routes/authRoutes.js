const router  = require('express').Router();
const ctrl    = require('../controllers/authController');
const { protect } = require('../middleware/auth');
const { authLimiter } = require('../middleware/rateLimiter');
const { body } = require('express-validator');
const { validateRequest } = require('../validators/common');

const loginRules = [
  body('email').isEmail().normalizeEmail().withMessage('Valid email required'),
  body('password').notEmpty().withMessage('Password required'),
];

const registerRules = [
  body('name').trim().isLength({ min: 2, max: 100 }).withMessage('Name 2–100 chars'),
  body('email').isEmail().normalizeEmail(),
  body('password').isLength({ min: 8 }).matches(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/)
    .withMessage('Password must contain uppercase, lowercase, number, and special character'),
];

router.post('/login',           authLimiter, loginRules,    validateRequest, ctrl.login);
router.post('/register',        authLimiter, registerRules, validateRequest, ctrl.register);
router.post('/logout',          protect, ctrl.logout);
router.post('/refresh',         ctrl.refresh);
router.get('/me',               protect, ctrl.getMe);
router.patch('/me',             protect, ctrl.updateMe);
router.post('/change-password', protect, ctrl.changePassword);

module.exports = router;
