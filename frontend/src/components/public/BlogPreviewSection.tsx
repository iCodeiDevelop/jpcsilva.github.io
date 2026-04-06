'use client';
import { motion } from 'framer-motion';
import Link from 'next/link';
import { Clock, Tag, ArrowRight } from 'lucide-react';
import { format } from 'date-fns';
import type { Blog } from '@/types';

export default function BlogPreviewSection({ blogs }: { blogs: Blog[] }) {
  return (
    <section id="blog" className="py-24 bg-gray-50 dark:bg-dark-950">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} className="flex items-end justify-between mb-16">
          <div>
            <h2 className="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">
              Latest <span className="text-primary-600">Articles</span>
            </h2>
            <p className="text-gray-500 dark:text-gray-400">Thoughts on software development, architecture, and tech.</p>
          </div>
          <Link href="/blog" className="hidden md:flex items-center gap-1 text-primary-600 dark:text-primary-400 font-medium hover:gap-2 transition-all text-sm">
            All Posts <ArrowRight className="h-4 w-4" />
          </Link>
        </motion.div>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {blogs.slice(0, 6).map((blog, i) => (
            <motion.article key={blog._id}
              initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} transition={{ delay: i * 0.1 }}
              className="group bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all hover:-translate-y-0.5">
              <div className="h-44 bg-gradient-to-br from-primary-100 to-violet-100 dark:from-primary-900/30 dark:to-violet-900/30 flex items-center justify-center">
                <span className="text-6xl font-black text-primary-200 dark:text-primary-800 select-none">
                  {blog.title.charAt(0)}
                </span>
              </div>
              <div className="p-6">
                <div className="flex flex-wrap gap-1.5 mb-3">
                  {blog.tags.slice(0,3).map(tag => (
                    <span key={tag} className="px-2.5 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 text-xs rounded-full">{tag}</span>
                  ))}
                </div>
                <h3 className="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors">
                  <Link href={`/blog/${blog.slug}`}>{blog.title}</Link>
                </h3>
                {blog.excerpt && <p className="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4">{blog.excerpt}</p>}
                <div className="flex items-center justify-between text-xs text-gray-400">
                  <span className="flex items-center gap-1"><Clock className="h-3.5 w-3.5" /> {blog.readingTime} min read</span>
                  {blog.publishedAt && <span>{format(new Date(blog.publishedAt), 'MMM dd, yyyy')}</span>}
                </div>
              </div>
            </motion.article>
          ))}
        </div>
        <div className="mt-10 text-center md:hidden">
          <Link href="/blog" className="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 transition-colors">
            View All Posts <ArrowRight className="h-4 w-4" />
          </Link>
        </div>
      </div>
    </section>
  );
}
