/**
 * Build mongoose query pagination from req.query
 * @returns { skip, limit, page, sort }
 */
exports.getPaginationParams = (query) => {
  const page  = Math.max(1, parseInt(query.page)  || 1);
  const limit = Math.min(100, Math.max(1, parseInt(query.limit) || 10));
  const skip  = (page - 1) * limit;

  // Sort: ?sort=-createdAt,title  →  { createdAt: -1, title: 1 }
  const sortString = query.sort || '-createdAt';
  const sort = {};
  sortString.split(',').forEach((field) => {
    if (field.startsWith('-')) sort[field.slice(1)] = -1;
    else sort[field] = 1;
  });

  return { page, limit, skip, sort };
};

exports.buildPaginationMeta = (total, page, limit) => ({
  total,
  page,
  limit,
  totalPages: Math.ceil(total / limit),
  hasNext: page * limit < total,
  hasPrev: page > 1,
});
