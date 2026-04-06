require('dotenv').config();
const mongoose = require('mongoose');
const bcrypt   = require('bcryptjs');
const User     = require('../models/User');
const Profile  = require('../models/Profile');
const Project  = require('../models/Project');
const Skill    = require('../models/Skill');
const Experience = require('../models/Experience');
const Certification = require('../models/Certification');
const Blog     = require('../models/Blog');
const logger   = require('../config/logger');

const seedData = async () => {
  await mongoose.connect(process.env.MONGODB_URI);
  logger.info('Connected to MongoDB for seeding...');

  // Clean up
  await Promise.all([
    User.deleteMany({}), Profile.deleteMany({}), Project.deleteMany({}),
    Skill.deleteMany({}), Experience.deleteMany({}), Certification.deleteMany({}),
    Blog.deleteMany({}),
  ]);
  logger.info('Cleared existing data');

  // Admin user
  const admin = await User.create({
    name:     process.env.ADMIN_NAME     || 'Alex Johnson',
    email:    process.env.ADMIN_EMAIL    || 'admin@portfolio.dev',
    password: process.env.ADMIN_PASSWORD || 'Admin@123!',
    role:     'admin',
    isActive: true,
  });

  // Profile
  await Profile.create({
    name:     'Alex Johnson',
    title:    'Senior Full-Stack Developer',
    subtitle: 'Building scalable web applications with modern technologies',
    bio:      `Passionate full-stack developer with 8+ years of experience building high-performance web applications. I specialize in React, Node.js, and cloud architecture. When I'm not coding, you'll find me contributing to open source, writing technical articles, or exploring new technologies.`,
    shortBio: 'Full-Stack Developer | 8+ years | React & Node.js specialist',
    location: 'San Francisco, CA',
    email:    'alex@portfolio.dev',
    available: true,
    availabilityNote: 'Open to full-time and contract opportunities',
    social: {
      github:   'https://github.com/alexjohnson',
      linkedin: 'https://linkedin.com/in/alexjohnson',
      twitter:  'https://twitter.com/alexjohnson',
      devto:    'https://dev.to/alexjohnson',
    },
    hero: {
      headline:     'Hi, I\'m Alex 👋',
      tagline:      'I build exceptional digital experiences that live on the internet.',
      ctaPrimary:   'View My Work',
      ctaSecondary: 'Get In Touch',
    },
    seo: {
      metaTitle:       'Alex Johnson | Senior Full-Stack Developer',
      metaDescription: 'Full-stack developer specializing in React, Node.js, and cloud architecture. Available for freelance and full-time opportunities.',
      keywords:        ['full-stack developer', 'react developer', 'node.js', 'javascript'],
    },
    features: { blogEnabled: true, darkModeDefault: false, contactFormEnabled: true },
  });

  // Skills
  await Skill.insertMany([
    { name:'React',       category:'frontend', proficiency:95, color:'#61DAFB', icon:'react',      yearsOfExp:6, featured:true, order:1 },
    { name:'Next.js',     category:'frontend', proficiency:90, color:'#000000', icon:'nextjs',     yearsOfExp:4, featured:true, order:2 },
    { name:'TypeScript',  category:'frontend', proficiency:88, color:'#3178C6', icon:'typescript',  yearsOfExp:5, featured:true, order:3 },
    { name:'Tailwind CSS',category:'frontend', proficiency:92, color:'#06B6D4', icon:'tailwind',   yearsOfExp:3, order:4 },
    { name:'Node.js',     category:'backend',  proficiency:93, color:'#339933', icon:'nodejs',     yearsOfExp:7, featured:true, order:5 },
    { name:'Express.js',  category:'backend',  proficiency:90, color:'#000000', icon:'express',    yearsOfExp:6, order:6 },
    { name:'Python',      category:'backend',  proficiency:80, color:'#3776AB', icon:'python',     yearsOfExp:4, order:7 },
    { name:'GraphQL',     category:'backend',  proficiency:75, color:'#E10098', icon:'graphql',    yearsOfExp:3, order:8 },
    { name:'MongoDB',     category:'database', proficiency:88, color:'#47A248', icon:'mongodb',    yearsOfExp:6, featured:true, order:9 },
    { name:'PostgreSQL',  category:'database', proficiency:85, color:'#336791', icon:'postgresql', yearsOfExp:5, order:10 },
    { name:'Redis',       category:'database', proficiency:78, color:'#DC382D', icon:'redis',      yearsOfExp:3, order:11 },
    { name:'Docker',      category:'devops',   proficiency:85, color:'#2496ED', icon:'docker',     yearsOfExp:4, featured:true, order:12 },
    { name:'AWS',         category:'devops',   proficiency:80, color:'#FF9900', icon:'aws',        yearsOfExp:4, order:13 },
    { name:'Git',         category:'tools',    proficiency:96, color:'#F05032', icon:'git',        yearsOfExp:8, order:14 },
    { name:'Figma',       category:'tools',    proficiency:70, color:'#F24E1E', icon:'figma',      yearsOfExp:2, order:15 },
  ]);

  // Experience
  await Experience.insertMany([
    {
      company:'TechVision Inc.',  position:'Senior Full-Stack Developer',
      type:'full-time', location:'San Francisco, CA', remote:false,
      startDate: new Date('2021-03-01'), isCurrent:true,
      description:'Lead development of a multi-tenant SaaS platform serving 50,000+ users.',
      highlights: ['Architected microservices migration reducing latency by 40%','Led team of 6 developers across 3 time zones','Implemented CI/CD pipeline cutting deployment time from 2 hours to 15 minutes'],
      techStack:['React','Node.js','PostgreSQL','AWS','Docker'],
      order:1,
    },
    {
      company:'StartupXYZ', position:'Full-Stack Developer',
      type:'full-time', location:'Remote', remote:true,
      startDate: new Date('2019-06-01'), endDate: new Date('2021-02-28'),
      description:'Built and maintained a real-time collaboration platform from ground up.',
      highlights:['Built real-time features using WebSockets serving 10,000+ concurrent users','Reduced page load time by 60% through code splitting and lazy loading'],
      techStack:['React','Socket.io','Node.js','MongoDB','Redis'],
      order:2,
    },
    {
      company:'DigitalCraft Agency', position:'Frontend Developer',
      type:'full-time', location:'New York, NY', remote:false,
      startDate: new Date('2017-01-01'), endDate: new Date('2019-05-31'),
      description:'Developed responsive web applications for 20+ clients across various industries.',
      highlights:['Delivered 25+ client projects on time and within budget','Mentored 3 junior developers'],
      techStack:['React','Vue.js','JavaScript','SCSS','WordPress'],
      order:3,
    },
  ]);

  // Certifications
  await Certification.insertMany([
    { name:'AWS Solutions Architect Associate', issuer:'Amazon Web Services', issueDate:new Date('2023-01-01'), credentialId:'AWS-SAA-12345', credentialUrl:'https://aws.amazon.com/certification', skills:['AWS','Cloud Architecture'], order:1 },
    { name:'Google Professional Cloud Developer',issuer:'Google Cloud', issueDate:new Date('2022-06-01'), credentialId:'GCP-DEV-67890', skills:['GCP','Cloud Development'], order:2 },
    { name:'MongoDB Certified Developer',        issuer:'MongoDB University', issueDate:new Date('2021-09-01'), credentialUrl:'https://university.mongodb.com', skills:['MongoDB','Database Design'], order:3 },
  ]);

  // Projects
  const p1 = await Project.create({
    title:'E-Commerce Platform',
    description:'A full-featured e-commerce platform built with microservices architecture. Features include real-time inventory management, AI-powered product recommendations, and seamless payment processing.',
    shortDesc:'Scalable e-commerce platform with microservices, AI recommendations, and real-time inventory.',
    category:'web', status:'published', featured:true,
    images:[{ url:'https://picsum.photos/seed/proj1/800/500', alt:'E-Commerce Platform', isPrimary:true }],
    techStack:[{name:'React',color:'#61DAFB'},{name:'Node.js',color:'#339933'},{name:'PostgreSQL',color:'#336791'},{name:'Redis',color:'#DC382D'},{name:'Docker',color:'#2496ED'}],
    links:{ live:'https://ecommerce-demo.dev', github:'https://github.com/alexjohnson/ecommerce' },
    seo:{ metaTitle:'E-Commerce Platform | Alex Johnson', metaDescription:'Full-featured e-commerce platform with AI recommendations', keywords:['ecommerce','react','nodejs'] },
    completedAt: new Date('2023-12-01'), order:1, createdBy:admin._id,
  });

  await Project.create({
    title:'Real-Time Analytics Dashboard',
    description:'A real-time analytics dashboard that processes millions of events per day. Built with a focus on performance and scalability, featuring live charts, custom date ranges, and exportable reports.',
    shortDesc:'High-performance analytics dashboard processing millions of daily events.',
    category:'data', status:'published', featured:true,
    images:[{ url:'https://picsum.photos/seed/proj2/800/500', alt:'Analytics Dashboard', isPrimary:true }],
    techStack:[{name:'Next.js',color:'#000000'},{name:'Python',color:'#3776AB'},{name:'ClickHouse',color:'#FFCC01'},{name:'Apache Kafka',color:'#000000'}],
    links:{ live:'https://analytics-demo.dev', github:'https://github.com/alexjohnson/analytics' },
    completedAt: new Date('2023-06-15'), order:2, createdBy:admin._id,
  });

  await Project.create({
    title:'AI Chat Assistant',
    description:'An intelligent conversational AI assistant built on top of large language models. Features include context-aware responses, multiple conversation threads, document Q&A, and API access.',
    shortDesc:'LLM-powered chat assistant with document Q&A and multi-thread conversations.',
    category:'ai-ml', status:'published', featured:false,
    images:[{ url:'https://picsum.photos/seed/proj3/800/500', alt:'AI Chat', isPrimary:true }],
    techStack:[{name:'React',color:'#61DAFB'},{name:'Python',color:'#3776AB'},{name:'FastAPI',color:'#009688'},{name:'OpenAI',color:'#412991'}],
    links:{ live:'https://ai-chat-demo.dev', github:'https://github.com/alexjohnson/ai-chat' },
    completedAt: new Date('2024-01-20'), order:3, createdBy:admin._id,
  });

  // Blog posts
  await Blog.create([
    {
      title:'Building Scalable APIs with Node.js and Express',
      content:`# Building Scalable APIs with Node.js and Express\n\nWhen building production APIs, scalability and maintainability are paramount.\n\n## Key Principles\n\n### 1. Clean Architecture\nOrganize your code in layers: routes → controllers → services → repositories. Each layer has a single responsibility.\n\n### 2. Proper Error Handling\nImplement centralized error handling middleware instead of try-catch in every route handler.\n\n### 3. Rate Limiting & Security\nAlways implement rate limiting, helmet.js for secure headers, and input sanitization.\n\n## Conclusion\nBuilding scalable APIs requires discipline and following established patterns. The investment in clean architecture pays dividends as your application grows.`,
      excerpt:'Learn the key principles and patterns for building production-ready, scalable REST APIs with Node.js and Express.',
      tags:['nodejs','express','api','backend'],
      category:'backend', status:'published', featured:true,
      readingTime:8, createdBy:admin._id,
    },
    {
      title:'React Performance Optimization: A Practical Guide',
      content:`# React Performance Optimization\n\nPerformance optimization in React is both an art and a science.\n\n## Techniques\n\n### 1. Code Splitting\nUse React.lazy() and Suspense to split your bundle and load only what's needed.\n\n### 2. Memoization\nUse useMemo and useCallback strategically to prevent unnecessary re-renders.\n\n### 3. Virtualization\nFor long lists, use react-window or react-virtual to render only visible items.`,
      excerpt:'Practical techniques to significantly improve your React application performance — from code splitting to advanced memoization.',
      tags:['react','performance','frontend','javascript'],
      category:'frontend', status:'published', featured:true,
      readingTime:12, createdBy:admin._id,
    },
  ]);

  logger.info('✅ Seed data inserted successfully!');
  logger.info(`   Admin: ${admin.email} / ${process.env.ADMIN_PASSWORD || 'Admin@123!'}`);
  await mongoose.disconnect();
  process.exit(0);
};

seedData().catch(err => {
  logger.error(`Seed error: ${err.message}`);
  process.exit(1);
});
