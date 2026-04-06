const mongoose = require('mongoose');

const profileSchema = new mongoose.Schema({
  name:        { type: String, required: true },
  title:       { type: String, required: true },
  subtitle:    { type: String },
  bio:         { type: String, maxlength: 3000 },
  shortBio:    { type: String, maxlength: 300 },
  avatar:      { type: String },
  resume:      { type: String },                  // PDF URL
  location:    { type: String },
  email:       { type: String },
  phone:       { type: String },
  available:   { type: Boolean, default: true },
  availabilityNote: { type: String },
  social: {
    github:    { type: String },
    linkedin:  { type: String },
    twitter:   { type: String },
    instagram: { type: String },
    youtube:   { type: String },
    website:   { type: String },
    devto:     { type: String },
    medium:    { type: String },
  },
  seo: {
    metaTitle:       { type: String },
    metaDescription: { type: String },
    keywords:        [String],
    ogImage:         { type: String },
  },
  hero: {
    headline:    { type: String },
    tagline:     { type: String },
    ctaPrimary:  { type: String, default: 'View Work' },
    ctaSecondary:{ type: String, default: 'Contact Me' },
  },
  features: {
    blogEnabled:       { type: Boolean, default: true },
    darkModeDefault:   { type: Boolean, default: false },
    contactFormEnabled:{ type: Boolean, default: true },
    analyticsEnabled:  { type: Boolean, default: false },
  },
  analytics: {
    googleAnalyticsId: { type: String },
  },
}, { timestamps: true });

module.exports = mongoose.model('Profile', profileSchema);
