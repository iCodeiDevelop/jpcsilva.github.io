const mongoose = require('mongoose');
const slugify  = require('slugify');

const projectSchema = new mongoose.Schema({
  title:       { type: String, required: true, trim: true, maxlength: 200 },
  slug:        { type: String, unique: true },
  description: { type: String, required: true, maxlength: 5000 },
  shortDesc:   { type: String, maxlength: 300 },
  category:    { type: String, required: true, enum: ['web', 'mobile', 'ai-ml', 'devops', 'data', 'other'], default: 'web' },
  status:      { type: String, enum: ['draft', 'published', 'archived'], default: 'draft' },
  featured:    { type: Boolean, default: false },
  images:      [{ url: String, alt: String, isPrimary: { type: Boolean, default: false } }],
  techStack:   [{ name: String, color: String, icon: String }],
  links: {
    live:   { type: String, default: null },
    github: { type: String, default: null },
    demo:   { type: String, default: null },
    docs:   { type: String, default: null },
  },
  seo: {
    metaTitle:       { type: String, maxlength: 70 },
    metaDescription: { type: String, maxlength: 160 },
    keywords:        [String],
  },
  stats: {
    views:    { type: Number, default: 0 },
    likes:    { type: Number, default: 0 },
  },
  completedAt: { type: Date },
  order:       { type: Number, default: 0 },
  createdBy:   { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
}, { timestamps: true });

// ── Auto-slug ─────────────────────────────────────────────
projectSchema.pre('save', async function (next) {
  if (!this.isModified('title')) return next();
  let base = slugify(this.title, { lower: true, strict: true });
  let slug = base;
  let counter = 1;
  while (await mongoose.models.Project.findOne({ slug, _id: { $ne: this._id } })) {
    slug = `${base}-${counter++}`;
  }
  this.slug = slug;
  next();
});

projectSchema.index({ status: 1, featured: -1, order: 1 });
projectSchema.index({ slug: 1 }, { unique: true });
projectSchema.index({ category: 1 });
projectSchema.index({ 'techStack.name': 1 });

module.exports = mongoose.model('Project', projectSchema);
