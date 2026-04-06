/**
 * Consistent API response shape
 */
exports.success = (res, data, message = 'Success', statusCode = 200) =>
  res.status(statusCode).json({ status: 'success', message, data });

exports.created = (res, data, message = 'Created successfully') =>
  res.status(201).json({ status: 'success', message, data });

exports.paginated = (res, data, pagination, message = 'Success') =>
  res.status(200).json({ status: 'success', message, data, pagination });

exports.noContent = (res) => res.status(204).send();
