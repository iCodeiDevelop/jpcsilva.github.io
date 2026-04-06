// ── API Response ──────────────────────────────────────────
export interface ApiResponse<T> {
  status:  'success' | 'fail' | 'error';
  message: string;
  data:    T;
}

export interface PaginatedResponse<T> extends ApiResponse<T> {
  pagination: {
    total:      number;
    page:       number;
    limit:      number;
    totalPages: number;
    hasNext:    boolean;
    hasPrev:    boolean;
  };
}

// ── User ──────────────────────────────────────────────────
export interface User {
  _id:       string;
  name:      string;
  email:     string;
  role:      'admin' | 'editor' | 'viewer';
  avatar?:   string;
  isActive:  boolean;
  lastLogin?: string;
  createdAt: string;
}

// ── Profile ───────────────────────────────────────────────
export interface Profile {
  _id:       string;
  name:      string;
  title:     string;
  subtitle?: string;
  bio?:      string;
  shortBio?: string;
  avatar?:   string;
  resume?:   string;
  location?: string;
  email?:    string;
  phone?:    string;
  available: boolean;
  availabilityNote?: string;
  social: {
    github?:   string; linkedin?: string; twitter?: string;
    instagram?:string; youtube?:  string; website?: string;
    devto?:    string; medium?:   string;
  };
  seo:  { metaTitle?: string; metaDescription?: string; keywords?: string[]; ogImage?: string };
  hero: { headline?: string; tagline?: string; ctaPrimary: string; ctaSecondary: string };
  features: { blogEnabled: boolean; darkModeDefault: boolean; contactFormEnabled: boolean };
}

// ── Project ───────────────────────────────────────────────
export type ProjectCategory = 'web' | 'mobile' | 'ai-ml' | 'devops' | 'data' | 'other';
export type ProjectStatus    = 'draft' | 'published' | 'archived';

export interface TechItem  { name: string; color?: string; icon?: string }
export interface ProjectImage { url: string; alt?: string; isPrimary: boolean }

export interface Project {
  _id:         string;
  title:       string;
  slug:        string;
  description: string;
  shortDesc?:  string;
  category:    ProjectCategory;
  status:      ProjectStatus;
  featured:    boolean;
  images:      ProjectImage[];
  techStack:   TechItem[];
  links:       { live?: string; github?: string; demo?: string; docs?: string };
  seo:         { metaTitle?: string; metaDescription?: string; keywords?: string[] };
  stats:       { views: number; likes: number };
  completedAt?: string;
  order:       number;
  createdAt:   string;
  updatedAt:   string;
}

// ── Skill ─────────────────────────────────────────────────
export type SkillCategory = 'frontend' | 'backend' | 'database' | 'devops' | 'tools' | 'soft-skills' | 'other';

export interface Skill {
  _id:         string;
  name:        string;
  category:    SkillCategory;
  proficiency: number;
  icon?:       string;
  color:       string;
  yearsOfExp:  number;
  isVisible:   boolean;
  featured:    boolean;
  order:       number;
}

// ── Experience ────────────────────────────────────────────
export interface Experience {
  _id:         string;
  company:     string;
  position:    string;
  type:        string;
  location?:   string;
  remote:      boolean;
  startDate:   string;
  endDate?:    string;
  isCurrent:   boolean;
  description?: string;
  highlights:  string[];
  techStack:   string[];
  companyUrl?: string;
  companyLogo?:string;
}

// ── Certification ─────────────────────────────────────────
export interface Certification {
  _id:           string;
  name:          string;
  issuer:        string;
  issueDate:     string;
  expiryDate?:   string;
  credentialId?: string;
  credentialUrl?:string;
  image?:        string;
  skills:        string[];
}

// ── Blog ──────────────────────────────────────────────────
export interface Blog {
  _id:         string;
  title:       string;
  slug:        string;
  content?:    string;
  excerpt?:    string;
  coverImage?: string;
  tags:        string[];
  category:    string;
  status:      'draft' | 'published' | 'archived';
  featured:    boolean;
  readingTime: number;
  stats:       { views: number; likes: number };
  publishedAt?: string;
  createdAt:   string;
  createdBy?:  Pick<User, '_id' | 'name'>;
}

// ── Analytics ─────────────────────────────────────────────
export interface DashboardStats {
  overview:       { totalViews: number; recentViews: number; projectViews: number; blogViews: number; contactSubmits: number; totalProjects: number; totalBlogs: number };
  topProjects:    Array<{ _id: string; title: string; stats: { views: number }; category: string }>;
  topBlogs:       Array<{ _id: string; title: string; stats: { views: number } }>;
  recentActivity: Array<{ action: string; resource: string; createdAt: string; user: { name: string } }>;
  viewsByDay:     Array<{ _id: string; count: number }>;
}
