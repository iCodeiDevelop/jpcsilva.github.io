const rateLimit = require('express-rate-limit');

const createLimiter = (windowMs, max, message) =>
  rateLimit({
    windowMs,
    max,
    message: { status: 'fail', message },
    standardHeaders: true,
    legacyHeaders: false,
    handler: (req, res, next, options) => {
      res.status(429).json(options.message);
    },
  });

// General API rate limit
exports.apiLimiter = createLimiter(
  parseInt(process.env.RATE_LIMIT_WINDOW_MS) || 15 * 60 * 1000,
  parseInt(process.env.RATE_LIMIT_MAX) || 100,
  'Too many requests from this IP. Please try again later.'
);

// Strict auth rate limit (prevents brute force)
exports.authLimiter = createLimiter(
  15 * 60 * 1000,
  parseInt(process.env.AUTH_RATE_LIMIT_MAX) || 10,
  'Too many authentication attempts. Please try again in 15 minutes.'
);

// Contact form limit
exports.contactLimiter = createLimiter(60 * 60 * 1000, 5, 'Too many contact form submissions. Please try again in 1 hour.');

// File upload limit
exports.uploadLimiter = createLimiter(60 * 1000, 20, 'Too many upload requests. Please slow down.');
