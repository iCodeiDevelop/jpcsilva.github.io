const router = require('express').Router();
const ctrl   = require('../controllers/contactController');
const { contactLimiter } = require('../middleware/rateLimiter');
const { body }  = require('express-validator');
const { validateRequest } = require('../validators/common');

const contactRules = [
  body('name').trim().isLength({ min: 2, max: 100 }).withMessage('Name 2–100 chars'),
  body('email').isEmail().normalizeEmail(),
  body('subject').trim().isLength({ min: 5, max: 200 }).withMessage('Subject 5–200 chars'),
  body('message').trim().isLength({ min: 20, max: 5000 }).withMessage('Message 20–5000 chars'),
];

router.post('/', contactLimiter, contactRules, validateRequest, ctrl.submitContact);

module.exports = router;
