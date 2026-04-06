'use client';
import { motion } from 'framer-motion';
import { MapPin, Calendar, ExternalLink, Briefcase, Wifi } from 'lucide-react';
import { format, differenceInMonths } from 'date-fns';
import type { Experience } from '@/types';

export default function ExperienceSection({ experiences }: { experiences: Experience[] }) {
  return (
    <section id="experience" className="py-24 bg-gray-50 dark:bg-dark-950">
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} className="text-center mb-16">
          <h2 className="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
            Work <span className="text-primary-600">Experience</span>
          </h2>
          <p className="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            My professional journey — where I've worked and what I've built.
          </p>
        </motion.div>

        {/* Timeline */}
        <div className="relative">
          {/* Vertical line */}
          <div className="absolute left-8 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary-400 via-primary-300 to-transparent dark:from-primary-700" />

          <div className="space-y-12">
            {experiences.map((exp, index) => (
              <ExperienceCard key={exp._id} exp={exp} index={index} isLeft={index % 2 === 0} />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}

function ExperienceCard({ exp, index, isLeft }: { exp: Experience; index: number; isLeft: boolean }) {
  const startDate = new Date(exp.startDate);
  const endDate   = exp.isCurrent ? new Date() : exp.endDate ? new Date(exp.endDate) : new Date();
  const months    = differenceInMonths(endDate, startDate);
  const duration  = months >= 12 ? `${Math.floor(months / 12)}y ${months % 12}m` : `${months}m`;

  return (
    <motion.div
      initial={{ opacity:0, x: isLeft ? -30 : 30 }} whileInView={{ opacity:1, x:0 }}
      viewport={{ once:true }} transition={{ duration:0.5, delay: index * 0.1 }}
      className="relative flex flex-col md:flex-row items-start gap-6">

      {/* Dot */}
      <div className="absolute left-8 md:left-1/2 -translate-x-1/2 w-4 h-4 bg-primary-600 border-4 border-white dark:border-dark-950 rounded-full shadow-md z-10" />

      {/* Card — alternates sides on desktop */}
      <div className={`ml-16 md:ml-0 md:w-[calc(50%-2rem)] ${isLeft ? 'md:mr-auto' : 'md:ml-auto md:text-left'}`}>
        <div className="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-md transition-shadow">
          {/* Header */}
          <div className="flex items-start justify-between gap-3 mb-3">
            <div>
              <h3 className="text-lg font-bold text-gray-900 dark:text-white">{exp.position}</h3>
              <div className="flex items-center gap-1.5 mt-1">
                <a href={exp.companyUrl || '#'} target="_blank" rel="noopener noreferrer"
                  className="font-medium text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1 text-sm">
                  {exp.company}
                  {exp.companyUrl && <ExternalLink className="h-3 w-3" />}
                </a>
              </div>
            </div>
            {exp.isCurrent && (
              <span className="shrink-0 px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">Current</span>
            )}
          </div>

          {/* Meta */}
          <div className="flex flex-wrap gap-3 text-xs text-gray-500 dark:text-gray-400 mb-4">
            <span className="flex items-center gap-1">
              <Calendar className="h-3.5 w-3.5" />
              {format(startDate, 'MMM yyyy')} – {exp.isCurrent ? 'Present' : format(new Date(exp.endDate!), 'MMM yyyy')}
              <span className="text-gray-400">({duration})</span>
            </span>
            {(exp.location || exp.remote) && (
              <span className="flex items-center gap-1">
                {exp.remote ? <Wifi className="h-3.5 w-3.5" /> : <MapPin className="h-3.5 w-3.5" />}
                {exp.remote ? 'Remote' : exp.location}
              </span>
            )}
            <span className="flex items-center gap-1"><Briefcase className="h-3.5 w-3.5" /> {exp.type}</span>
          </div>

          {/* Description */}
          {exp.description && <p className="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">{exp.description}</p>}

          {/* Highlights */}
          {exp.highlights.length > 0 && (
            <ul className="space-y-1.5 mb-4">
              {exp.highlights.map((h, i) => (
                <li key={i} className="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                  <span className="mt-1.5 h-1.5 w-1.5 rounded-full bg-primary-500 shrink-0" />
                  {h}
                </li>
              ))}
            </ul>
          )}

          {/* Tech stack */}
          {exp.techStack.length > 0 && (
            <div className="flex flex-wrap gap-1.5">
              {exp.techStack.map(tech => (
                <span key={tech} className="px-2.5 py-0.5 bg-gray-100 dark:bg-dark-700 text-gray-600 dark:text-gray-400 text-xs rounded-full">{tech}</span>
              ))}
            </div>
          )}
        </div>
      </div>
    </motion.div>
  );
}
