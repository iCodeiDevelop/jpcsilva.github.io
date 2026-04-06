const ActivityLog = require('../models/ActivityLog');
const logger      = require('../config/logger');

/**
 * Middleware factory — log admin activity after successful response.
 * Usage: router.post('/', activityLog('CREATE', 'project'), controller)
 */
const activityLog = (action, resource) => async (req, res, next) => {
  const originalJson = res.json.bind(res);

  res.json = function (body) {
    if (req.user && res.statusCode < 400) {
      ActivityLog.create({
        user:       req.user._id,
        action,
        resource,
        resourceId: body?.data?._id || req.params?.id,
        details:    { method: req.method, path: req.path, body: sanitizeBody(req.body) },
        ip:         req.ip,
        userAgent:  req.get('user-agent'),
        status:     'success',
      }).catch(err => logger.error(`ActivityLog error: ${err.message}`));
    }
    return originalJson(body);
  };

  next();
};

const sanitizeBody = (body) => {
  const sanitized = { ...body };
  ['password', 'passwordConfirm', 'token', 'secret'].forEach(k => delete sanitized[k]);
  return sanitized;
};

module.exports = activityLog;
