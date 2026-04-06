'use client';
import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ExternalLink, Github, Eye, Star } from 'lucide-react';
import Image from 'next/image';
import Link from 'next/link';
import { Badge } from '@/components/ui/Badge';
import type { Project, ProjectCategory } from '@/types';

const CATEGORIES: { value: ProjectCategory | 'all'; label: string }[] = [
  { value: 'all',     label: 'All'       },
  { value: 'web',     label: 'Web'       },
  { value: 'mobile',  label: 'Mobile'    },
  { value: 'ai-ml',   label: 'AI / ML'   },
  { value: 'devops',  label: 'DevOps'    },
  { value: 'data',    label: 'Data'      },
];

interface Props { projects: Project[] }

export default function ProjectsSection({ projects }: Props) {
  const [filter, setFilter] = useState<string>('all');

  const filtered = filter === 'all' ? projects : projects.filter(p => p.category === filter);

  return (
    <section id="projects" className="py-24 bg-gray-50 dark:bg-dark-950">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <motion.div initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} className="text-center mb-16">
          <h2 className="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
            Featured <span className="text-primary-600">Projects</span>
          </h2>
          <p className="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            A collection of projects I've built — from full-stack web apps to AI-powered tools.
          </p>
        </motion.div>

        {/* Filter tabs */}
        <div className="flex flex-wrap items-center justify-center gap-2 mb-12">
          {CATEGORIES.map(cat => (
            <button key={cat.value} onClick={() => setFilter(cat.value)}
              className={`px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                filter === cat.value
                  ? 'bg-primary-600 text-white shadow-md shadow-primary-500/25'
                  : 'bg-white dark:bg-dark-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-primary-400'
              }`}>
              {cat.label}
            </button>
          ))}
        </div>

        {/* Grid */}
        <motion.div layout className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <AnimatePresence mode="popLayout">
            {filtered.map((project, index) => (
              <ProjectCard key={project._id} project={project} index={index} />
            ))}
          </AnimatePresence>
        </motion.div>

        {filtered.length === 0 && (
          <p className="text-center text-gray-400 py-12">No projects in this category yet.</p>
        )}
      </div>
    </section>
  );
}

function ProjectCard({ project, index }: { project: Project; index: number }) {
  const primaryImage = project.images.find(i => i.isPrimary) || project.images[0];

  return (
    <motion.article
      layout initial={{ opacity:0, y:30 }} animate={{ opacity:1, y:0 }}
      exit={{ opacity:0, scale:0.95 }} transition={{ duration:0.4, delay: index * 0.05 }}
      className="group bg-white dark:bg-dark-800 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">

      {/* Image */}
      <div className="relative h-48 bg-gradient-to-br from-primary-100 to-violet-100 dark:from-primary-900/30 dark:to-violet-900/30 overflow-hidden">
        {primaryImage ? (
          <Image src={primaryImage.url} alt={primaryImage.alt || project.title}
            fill className="object-cover group-hover:scale-105 transition-transform duration-500" />
        ) : (
          <div className="absolute inset-0 flex items-center justify-center text-4xl font-black text-primary-300">
            {project.title.charAt(0)}
          </div>
        )}
        <div className="absolute top-3 left-3 flex gap-2">
          <Badge variant="primary">{project.category.toUpperCase()}</Badge>
          {project.featured && <Badge variant="warning">⭐ Featured</Badge>}
        </div>
      </div>

      {/* Content */}
      <div className="flex flex-col flex-1 p-6">
        <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
          {project.title}
        </h3>
        <p className="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-3 flex-1">
          {project.shortDesc || project.description}
        </p>

        {/* Tech stack */}
        <div className="flex flex-wrap gap-1.5 mb-5">
          {project.techStack.slice(0, 5).map(tech => (
            <span key={tech.name} className="px-2.5 py-0.5 rounded-full text-xs font-medium"
              style={{ background: tech.color + '20', color: tech.color, border: `1px solid ${tech.color}40` }}>
              {tech.name}
            </span>
          ))}
          {project.techStack.length > 5 && (
            <span className="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-500">
              +{project.techStack.length - 5}
            </span>
          )}
        </div>

        {/* Stats + Links */}
        <div className="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
          <div className="flex items-center gap-3 text-xs text-gray-400">
            <span className="flex items-center gap-1"><Eye className="h-3.5 w-3.5" /> {project.stats.views}</span>
            <span className="flex items-center gap-1"><Star className="h-3.5 w-3.5" /> {project.stats.likes}</span>
          </div>
          <div className="flex items-center gap-2">
            {project.links.github && (
              <a href={project.links.github} target="_blank" rel="noopener noreferrer"
                className="p-2 rounded-lg text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-700 transition-colors">
                <Github className="h-4 w-4" />
              </a>
            )}
            {project.links.live && (
              <a href={project.links.live} target="_blank" rel="noopener noreferrer"
                className="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                <ExternalLink className="h-4 w-4" />
              </a>
            )}
            <Link href={`/projects/${project.slug}`}
              className="px-3 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-xs font-semibold rounded-lg hover:bg-primary-100 transition-colors">
              Details →
            </Link>
          </div>
        </div>
      </div>
    </motion.article>
  );
}
