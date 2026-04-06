const { sendContactEmail } = require('../config/email');
const { success } = require('../utils/apiResponse');
const catchAsync  = require('../utils/catchAsync');
const Analytics   = require('../models/Analytics');
const logger      = require('../config/logger');

exports.submitContact = catchAsync(async (req, res) => {
  const { name, email, subject, message } = req.body;

  // Send email (non-blocking if needed; here we await for confirmation)
  try {
    await sendContactEmail({ name, email, subject, message });
    Analytics.create({ type: 'contact_submit', ip: req.ip }).catch(() => {});
    logger.info(`Contact form submitted by ${name} <${email}>`);
    success(res, null, 'Message sent successfully! I\'ll get back to you soon.');
  } catch (error) {
    logger.error(`Contact form email failed: ${error.message}`);
    // Still return success to user (email failure is internal)
    success(res, null, 'Message received! I\'ll get back to you soon.');
  }
});
