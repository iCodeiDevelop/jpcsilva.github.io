const mongoose = require('mongoose');

const analyticsSchema = new mongoose.Schema({
  type:    { type: String, enum: ['page_view', 'project_view', 'blog_view', 'contact_submit', 'resume_download'] },
  target:  { type: String },                               // page path or entity ID
  targetId:{ type: mongoose.Schema.Types.ObjectId },
  ip:      { type: String },
  userAgent:{ type: String },
  referrer: { type: String },
  country:  { type: String },
  device:   { type: String, enum: ['desktop', 'tablet', 'mobile', 'unknown'], default: 'unknown' },
  sessionId:{ type: String },
  createdAt:{ type: Date, default: Date.now, expires: '90d' },  // TTL: 90 days
}, { timestamps: false });

analyticsSchema.index({ type: 1, createdAt: -1 });
analyticsSchema.index({ targetId: 1, type: 1 });

module.exports = mongoose.model('Analytics', analyticsSchema);
