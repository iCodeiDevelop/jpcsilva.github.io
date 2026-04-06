'use client';
import { motion } from 'framer-motion';
import { Award, ExternalLink, Calendar } from 'lucide-react';
import { format } from 'date-fns';
import type { Certification } from '@/types';

export default function CertificationsSection({ certifications }: { certifications: Certification[] }) {
  return (
    <section id="certifications" className="py-24 bg-white dark:bg-dark-900">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} className="text-center mb-16">
          <h2 className="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
            Certifications & <span className="text-primary-600">Credentials</span>
          </h2>
        </motion.div>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {certifications.map((cert, i) => (
            <motion.div key={cert._id}
              initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} transition={{ delay: i * 0.1 }}
              className="bg-gray-50 dark:bg-dark-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-md transition-shadow">
              <div className="flex items-start gap-4">
                <div className="p-3 bg-primary-100 dark:bg-primary-900/30 rounded-xl">
                  <Award className="h-6 w-6 text-primary-600 dark:text-primary-400" />
                </div>
                <div className="flex-1">
                  <h3 className="font-bold text-gray-900 dark:text-white mb-1">{cert.name}</h3>
                  <p className="text-sm text-primary-600 dark:text-primary-400 font-medium mb-2">{cert.issuer}</p>
                  <p className="text-xs text-gray-500 flex items-center gap-1 mb-3">
                    <Calendar className="h-3.5 w-3.5" />
                    {format(new Date(cert.issueDate), 'MMM yyyy')}
                    {cert.expiryDate && ` – ${format(new Date(cert.expiryDate), 'MMM yyyy')}`}
                  </p>
                  {cert.skills.length > 0 && (
                    <div className="flex flex-wrap gap-1.5 mb-3">
                      {cert.skills.map(s => (
                        <span key={s} className="px-2 py-0.5 bg-white dark:bg-dark-700 border border-gray-200 dark:border-gray-600 text-xs rounded-full text-gray-600 dark:text-gray-400">{s}</span>
                      ))}
                    </div>
                  )}
                  {cert.credentialUrl && (
                    <a href={cert.credentialUrl} target="_blank" rel="noopener noreferrer"
                      className="text-xs text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                      View Credential <ExternalLink className="h-3 w-3" />
                    </a>
                  )}
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
