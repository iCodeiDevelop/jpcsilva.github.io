'use client';
import { motion } from 'framer-motion';
import type { Skill, SkillCategory } from '@/types';

const CATEGORY_LABELS: Record<SkillCategory, string> = {
  frontend:     '🎨 Frontend',
  backend:      '⚙️ Backend',
  database:     '🗄️ Database',
  devops:       '🐳 DevOps',
  tools:        '🔧 Tools',
  'soft-skills':'🤝 Soft Skills',
  other:        '📦 Other',
};

export default function SkillsSection({ grouped }: { grouped: Record<SkillCategory, Skill[]> }) {
  return (
    <section id="skills" className="py-24 bg-white dark:bg-dark-900">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} className="text-center mb-16">
          <h2 className="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
            Skills & <span className="text-primary-600">Expertise</span>
          </h2>
          <p className="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            Technologies and tools I use to bring ideas to life.
          </p>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-10">
          {(Object.entries(grouped) as [SkillCategory, Skill[]][]).map(([category, skills], catIdx) => (
            <motion.div key={category}
              initial={{ opacity:0, x: catIdx % 2 === 0 ? -20 : 20 }}
              whileInView={{ opacity:1, x:0 }} viewport={{ once:true }} transition={{ delay: catIdx * 0.1 }}>
              <h3 className="text-lg font-bold text-gray-800 dark:text-gray-200 mb-6">
                {CATEGORY_LABELS[category] || category}
              </h3>
              <div className="space-y-4">
                {skills.map((skill, i) => (
                  <SkillBar key={skill._id} skill={skill} delay={catIdx * 0.1 + i * 0.05} />
                ))}
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}

function SkillBar({ skill, delay }: { skill: Skill; delay: number }) {
  return (
    <div>
      <div className="flex items-center justify-between mb-1.5">
        <div className="flex items-center gap-2">
          <span className="text-sm font-semibold text-gray-800 dark:text-gray-200">{skill.name}</span>
          {skill.yearsOfExp > 0 && (
            <span className="text-xs text-gray-400">{skill.yearsOfExp}y exp</span>
          )}
        </div>
        <span className="text-sm font-bold text-primary-600 dark:text-primary-400">{skill.proficiency}%</span>
      </div>
      <div className="h-2 bg-gray-100 dark:bg-dark-700 rounded-full overflow-hidden">
        <motion.div
          initial={{ width: 0 }} whileInView={{ width: `${skill.proficiency}%` }}
          viewport={{ once: true }} transition={{ duration: 1, delay, ease: 'easeOut' }}
          className="h-full rounded-full"
          style={{ background: `linear-gradient(90deg, ${skill.color}cc, ${skill.color})` }}
        />
      </div>
    </div>
  );
}
