const mongoose = require('mongoose');
const slugify  = require('slugify');

const blogSchema = new mongoose.Schema({
  title:       { type: String, required: true, trim: true, maxlength: 200 },
  slug:        { type: String, unique: true },
  content:     { type: String, required: true },
  excerpt:     { type: String, maxlength: 400 },
  coverImage:  { type: String, default: null },
  tags:        [{ type: String, lowercase: true, trim: true }],
  category:    { type: String, default: 'general' },
  status:      { type: String, enum: ['draft', 'published', 'archived'], default: 'draft' },
  featured:    { type: Boolean, default: false },
  readingTime: { type: Number, default: 0 },  // minutes
  seo: {
    metaTitle:       { type: String, maxlength: 70 },
    metaDescription: { type: String, maxlength: 160 },
    keywords:        [String],
  },
  stats: { views: { type: Number, default: 0 }, likes: { type: Number, default: 0 } },
  publishedAt: { type: Date },
  createdBy:   { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
}, { timestamps: true });

blogSchema.pre('save', async function (next) {
  // Auto-generate slug
  if (this.isModified('title')) {
    let base = slugify(this.title, { lower: true, strict: true });
    let slug = base; let counter = 1;
    while (await mongoose.models.Blog.findOne({ slug, _id: { $ne: this._id } })) {
      slug = `${base}-${counter++}`;
    }
    this.slug = slug;
  }
  // Auto-calculate reading time
  if (this.isModified('content')) {
    const words = this.content.trim().split(/\s+/).length;
    this.readingTime = Math.ceil(words / 200);
  }
  // Set publishedAt on first publish
  if (this.isModified('status') && this.status === 'published' && !this.publishedAt) {
    this.publishedAt = new Date();
  }
  next();
});

blogSchema.index({ status: 1, publishedAt: -1 });
blogSchema.index({ slug: 1 }, { unique: true });
blogSchema.index({ tags: 1 });

module.exports = mongoose.model('Blog', blogSchema);
