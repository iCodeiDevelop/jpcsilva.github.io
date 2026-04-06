const mongoose = require('mongoose');

const skillSchema = new mongoose.Schema({
  name:        { type: String, required: true, trim: true, maxlength: 80 },
  category:    { type: String, required: true, enum: ['frontend', 'backend', 'database', 'devops', 'tools', 'soft-skills', 'other'] },
  proficiency: { type: Number, required: true, min: 0, max: 100 },
  icon:        { type: String, default: null },      // icon name or URL
  color:       { type: String, default: '#2563eb' }, // hex color
  yearsOfExp:  { type: Number, default: 0 },
  isVisible:   { type: Boolean, default: true },
  featured:    { type: Boolean, default: false },
  order:       { type: Number, default: 0 },
}, { timestamps: true });

skillSchema.index({ category: 1, order: 1 });

module.exports = mongoose.model('Skill', skillSchema);
