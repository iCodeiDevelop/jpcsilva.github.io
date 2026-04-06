const mongoose = require('mongoose');

const experienceSchema = new mongoose.Schema({
  company:     { type: String, required: true, trim: true, maxlength: 150 },
  position:    { type: String, required: true, trim: true, maxlength: 150 },
  type:        { type: String, enum: ['full-time', 'part-time', 'contract', 'freelance', 'internship', 'volunteer'], default: 'full-time' },
  location:    { type: String, trim: true },
  remote:      { type: Boolean, default: false },
  startDate:   { type: Date, required: true },
  endDate:     { type: Date, default: null },       // null = current
  isCurrent:   { type: Boolean, default: false },
  description: { type: String, maxlength: 3000 },
  highlights:  [{ type: String, maxlength: 300 }],
  techStack:   [String],
  companyUrl:  { type: String },
  companyLogo: { type: String },
  order:       { type: Number, default: 0 },
  isVisible:   { type: Boolean, default: true },
}, { timestamps: true });

experienceSchema.index({ startDate: -1 });

module.exports = mongoose.model('Experience', experienceSchema);
