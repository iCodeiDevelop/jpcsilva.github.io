const mongoose = require('mongoose');

const activityLogSchema = new mongoose.Schema({
  user:    { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
  action:  { type: String, required: true },     // 'CREATE', 'UPDATE', 'DELETE', 'LOGIN', etc.
  resource:{ type: String, required: true },     // 'project', 'skill', 'blog', etc.
  resourceId: { type: mongoose.Schema.Types.ObjectId },
  details: { type: mongoose.Schema.Types.Mixed },
  ip:      { type: String },
  userAgent:{ type: String },
  status:  { type: String, enum: ['success', 'failure'], default: 'success' },
  createdAt:{ type: Date, default: Date.now, expires: '180d' }, // 6-month retention
}, { timestamps: false });

activityLogSchema.index({ user: 1, createdAt: -1 });
activityLogSchema.index({ resource: 1, action: 1 });

module.exports = mongoose.model('ActivityLog', activityLogSchema);
