class AppError extends Error {
  constructor(message, statusCode) {
    super(message);
    this.statusCode   = statusCode;
    this.status       = `${statusCode}`.startsWith('4') ? 'fail' : 'error';
    this.isOperational = true;
    Error.captureStackTrace(this, this.constructor);
  }
}

class NotFoundError     extends AppError { constructor(r='Resource') { super(`${r} not found.`, 404); } }
class UnauthorizedError extends AppError { constructor(m='Unauthorized.') { super(m, 401); } }
class ForbiddenError    extends AppError { constructor(m='Forbidden.') { super(m, 403); } }
class ValidationError   extends AppError { constructor(m='Validation failed.') { super(m, 400); } }

module.exports = { AppError, NotFoundError, UnauthorizedError, ForbiddenError, ValidationError };
