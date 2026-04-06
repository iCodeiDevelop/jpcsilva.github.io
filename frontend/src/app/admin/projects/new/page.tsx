'use client';
import { useRouter } from 'next/navigation';
import { useForm, useFieldArray } from 'react-hook-form';
import { Plus, Minus, ArrowLeft, Save } from 'lucide-react';
import AdminLayout from '@/components/admin/AdminLayout';
import { Button } from '@/components/ui/Button';
import { Input, Textarea } from '@/components/ui/Input';
import { api, getErrorMessage } from '@/lib/api';
import toast from 'react-hot-toast';
import Link from 'next/link';
import { useState } from 'react';

export default function NewProjectPage() {
  const router   = useRouter();
  const [saving, setSaving] = useState(false);
  const { register, handleSubmit, control, watch, formState: { errors } } = useForm({
    defaultValues: {
      title:'', description:'', shortDesc:'', category:'web', status:'draft',
      featured: false,
      techStack: [{ name:'', color:'#2563eb' }],
      links: { live:'', github:'', demo:'', docs:'' },
      seo: { metaTitle:'', metaDescription:'' },
    }
  });

  const { fields: techFields, append: appendTech, remove: removeTech } = useFieldArray({ control, name: 'techStack' });

  const onSubmit = async (data: any) => {
    setSaving(true);
    try {
      const res = await api.post('/admin/projects', {
        ...data,
        techStack: data.techStack.filter((t: any) => t.name.trim()),
      });
      toast.success('Project created!');
      router.push('/admin/projects');
    } catch (err) {
      toast.error(getErrorMessage(err));
    } finally { setSaving(false); }
  };

  return (
    <AdminLayout>
      <div className="max-w-3xl mx-auto space-y-6">
        <div className="flex items-center gap-3">
          <Link href="/admin/projects"><button className="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors"><ArrowLeft className="h-5 w-5" /></button></Link>
          <h1 className="text-2xl font-bold text-gray-900 dark:text-white">New Project</h1>
        </div>

        <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
          <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-5">
            <h2 className="font-semibold text-gray-900 dark:text-white">Basic Info</h2>
            <Input label="Project Title" placeholder="E-Commerce Platform" required {...register('title', { required: true })} />
            <Textarea label="Description" placeholder="Full project description..." rows={5} {...register('description', { required: true })} />
            <Textarea label="Short Description" placeholder="One-liner for cards (max 300 chars)..." rows={2} {...register('shortDesc')} />
            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                <select className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" {...register('category')}>
                  {['web','mobile','ai-ml','devops','data','other'].map(c => <option key={c} value={c}>{c}</option>)}
                </select>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" {...register('status')}>
                  <option value="draft">Draft</option><option value="published">Published</option><option value="archived">Archived</option>
                </select>
              </div>
            </div>
            <label className="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" className="rounded text-blue-600" {...register('featured')} />
              <span className="text-sm text-gray-700 dark:text-gray-300">Featured project</span>
            </label>
          </div>

          {/* Tech Stack */}
          <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <div className="flex items-center justify-between">
              <h2 className="font-semibold text-gray-900 dark:text-white">Tech Stack</h2>
              <Button type="button" variant="secondary" size="sm" onClick={() => appendTech({ name:'', color:'#2563eb' })} leftIcon={<Plus className="h-3.5 w-3.5" />}>Add Tech</Button>
            </div>
            {techFields.map((field, i) => (
              <div key={field.id} className="flex items-center gap-3">
                <Input placeholder="Technology name" className="flex-1" {...register(`techStack.${i}.name`)} />
                <input type="color" className="h-9 w-9 cursor-pointer rounded border border-gray-300 dark:border-gray-600" {...register(`techStack.${i}.color`)} />
                {techFields.length > 1 && <button type="button" onClick={() => removeTech(i)} className="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"><Minus className="h-4 w-4" /></button>}
              </div>
            ))}
          </div>

          {/* Links */}
          <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <h2 className="font-semibold text-gray-900 dark:text-white">Links</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <Input label="Live URL"    placeholder="https://myproject.com"  {...register('links.live')} />
              <Input label="GitHub URL"  placeholder="https://github.com/..."  {...register('links.github')} />
              <Input label="Demo URL"    placeholder="https://demo.myproject.com" {...register('links.demo')} />
              <Input label="Docs URL"    placeholder="https://docs.myproject.com" {...register('links.docs')} />
            </div>
          </div>

          {/* SEO */}
          <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <h2 className="font-semibold text-gray-900 dark:text-white">SEO</h2>
            <Input label="Meta Title (max 70 chars)" placeholder="Project Name | Portfolio" {...register('seo.metaTitle')} />
            <Textarea label="Meta Description (max 160 chars)" rows={2} placeholder="Brief description for search engines..." {...register('seo.metaDescription')} />
          </div>

          <div className="flex justify-end gap-3">
            <Link href="/admin/projects"><Button type="button" variant="secondary">Cancel</Button></Link>
            <Button type="submit" isLoading={saving} leftIcon={<Save className="h-4 w-4" />}>Create Project</Button>
          </div>
        </form>
      </div>
    </AdminLayout>
  );
}
