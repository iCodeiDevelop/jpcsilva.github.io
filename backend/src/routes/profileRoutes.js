const router = require('express').Router();
const ctrl   = require('../controllers/profileController');

router.get('/', ctrl.getProfile);

module.exports = router;
