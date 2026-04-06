const xss = require('xss');

/**
 * Recursively sanitize an object's string values against XSS
 */
exports.sanitizeObject = (obj) => {
  if (typeof obj === 'string') return xss(obj);
  if (Array.isArray(obj))     return obj.map(exports.sanitizeObject);
  if (obj && typeof obj === 'object') {
    const clean = {};
    for (const [k, v] of Object.entries(obj)) clean[k] = exports.sanitizeObject(v);
    return clean;
  }
  return obj;
};

exports.sanitizeMiddleware = (req, res, next) => {
  if (req.body)   req.body   = exports.sanitizeObject(req.body);
  if (req.query)  req.query  = exports.sanitizeObject(req.query);
  if (req.params) req.params = exports.sanitizeObject(req.params);
  next();
};
