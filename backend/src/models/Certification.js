const mongoose = require('mongoose');

const certificationSchema = new mongoose.Schema({
  name:         { type: String, required: true, trim: true, maxlength: 200 },
  issuer:       { type: String, required: true, trim: true, maxlength: 150 },
  issueDate:    { type: Date, required: true },
  expiryDate:   { type: Date, default: null },
  credentialId: { type: String, trim: true },
  credentialUrl:{ type: String },
  image:        { type: String, default: null },
  skills:       [String],
  isVisible:    { type: Boolean, default: true },
  order:        { type: Number, default: 0 },
}, { timestamps: true });

certificationSchema.index({ issueDate: -1 });

module.exports = mongoose.model('Certification', certificationSchema);
