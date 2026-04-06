'use strict';

require('dotenv').config();
const express         = require('express');
const cors            = require('cors');
const helmet          = require('helmet');
const compression     = require('compression');
const morgan          = require('morgan');
const cookieParser    = require('cookie-parser');
const mongoSanitize   = require('express-mongo-sanitize');
const path            = require('path');

const connectDB       = require('./config/database');
const logger          = require('./config/logger');
const { apiLimiter }  = require('./middleware/rateLimiter');
const errorHandler    = require('./middleware/errorHandler');
const { sanitizeMiddleware } = require('./utils/sanitize');
const { AppError }    = require('./utils/errors');
const routes          = require('./routes');

const app = express();

// ── Connect Database ──────────────────────────────────────
connectDB();

// ── Security Middleware ───────────────────────────────────
app.use(helmet({
  crossOriginResourcePolicy: { policy: 'cross-origin' },
  contentSecurityPolicy: {
    directives: {
      defaultSrc:  ["'self'"],
      imgSrc:      ["'self'", 'data:', 'https:'],
      scriptSrc:   ["'self'"],
      styleSrc:    ["'self'", "'unsafe-inline'"],
    },
  },
}));

// ── CORS ──────────────────────────────────────────────────
app.use(cors({
  origin: (origin, callback) => {
    const allowed = (process.env.CLIENT_URL || 'http://localhost:3000').split(',');
    if (!origin || allowed.includes(origin)) return callback(null, true);
    callback(new Error('Not allowed by CORS'));
  },
  credentials: true,
  methods:     ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
}));

// ── Body Parsing ──────────────────────────────────────────
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));
app.use(cookieParser());

// ── Sanitization ──────────────────────────────────────────
app.use(mongoSanitize());   // NoSQL injection prevention
app.use(sanitizeMiddleware); // XSS prevention

// ── Compression & Logging ────────────────────────────────
app.use(compression());
if (process.env.NODE_ENV !== 'test') {
  app.use(morgan('combined', { stream: { write: (msg) => logger.http(msg.trim()) } }));
}

// ── Static Files ──────────────────────────────────────────
app.use('/uploads', express.static(path.join(process.cwd(), 'uploads')));

// ── Rate Limiting ─────────────────────────────────────────
app.use('/api', apiLimiter);

// ── API Routes ────────────────────────────────────────────
app.use('/api', routes);

// ── 404 Handler ───────────────────────────────────────────
app.all('*', (req, res, next) => {
  next(new AppError(`Route ${req.originalUrl} not found.`, 404));
});

// ── Global Error Handler ──────────────────────────────────
app.use(errorHandler);

// ── Server Start ──────────────────────────────────────────
const PORT = process.env.PORT || 5000;
const server = app.listen(PORT, () => {
  logger.info(`🚀 Server running in ${process.env.NODE_ENV || 'development'} mode on port ${PORT}`);
  logger.info(`📖 API: http://localhost:${PORT}/api`);
  logger.info(`❤️  Health: http://localhost:${PORT}/api/health`);
});

// ── Graceful Shutdown ─────────────────────────────────────
const gracefulShutdown = (signal) => {
  logger.info(`${signal} received. Shutting down gracefully...`);
  server.close(() => {
    logger.info('HTTP server closed');
    process.exit(0);
  });
  setTimeout(() => process.exit(1), 10000);
};

process.on('SIGTERM', () => gracefulShutdown('SIGTERM'));
process.on('SIGINT',  () => gracefulShutdown('SIGINT'));
process.on('unhandledRejection', (err) => {
  logger.error(`UNHANDLED REJECTION: ${err.message}`, { stack: err.stack });
  gracefulShutdown('unhandledRejection');
});
process.on('uncaughtException', (err) => {
  logger.error(`UNCAUGHT EXCEPTION: ${err.message}`, { stack: err.stack });
  gracefulShutdown('uncaughtException');
});

module.exports = app;
