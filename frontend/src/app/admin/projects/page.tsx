'use client';
import { useState } from 'react';
import Link from 'next/link';
import { Plus, Edit, Trash2, Eye, ExternalLink, Search } from 'lucide-react';
import AdminLayout from '@/components/admin/AdminLayout';
import { Badge } from '@/components/ui/Badge';
import { Button } from '@/components/ui/Button';
import { useProjects, useApiMutation } from '@/hooks/useQuery';
import { api } from '@/lib/api';
import toast from 'react-hot-toast';
import { format } from 'date-fns';

export default function AdminProjectsPage() {
  const [search, setSearch] = useState('');
  const [status, setStatus] = useState('');
  const { data, isLoading, refetch } = useProjects({ search: search || undefined, status: status || undefined, limit: 50 });
  const projects = data?.data?.projects || [];

  const deleteProject = useApiMutation(
    (id: string) => api.delete(`/admin/projects/${id}`),
    { successMsg: 'Project deleted', invalidateKeys: [['projects']] }
  );

  const handleDelete = async (id: string, title: string) => {
    if (!confirm(`Delete "${title}"? This cannot be undone.`)) return;
    deleteProject.mutate(id);
  };

  return (
    <AdminLayout>
      <div className="space-y-6">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Projects</h1>
            <p className="text-sm text-gray-500 mt-1">{projects.length} projects</p>
          </div>
          <Link href="/admin/projects/new">
            <Button leftIcon={<Plus className="h-4 w-4" />}>New Project</Button>
          </Link>
        </div>

        {/* Filters */}
        <div className="flex flex-col sm:flex-row gap-3">
          <div className="relative flex-1">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
            <input value={search} onChange={e => setSearch(e.target.value)} placeholder="Search projects..."
              className="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <select value={status} onChange={e => setStatus(e.target.value)}
            className="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Status</option>
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
          </select>
        </div>

        {/* Table */}
        <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
          <table className="w-full">
            <thead><tr className="border-b border-gray-200 dark:border-gray-700">
              <th className="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Title</th>
              <th className="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Category</th>
              <th className="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
              <th className="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Views</th>
              <th className="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Created</th>
              <th className="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr></thead>
            <tbody className="divide-y divide-gray-100 dark:divide-gray-700">
              {isLoading ? (
                [...Array(5)].map((_,i) => <tr key={i}><td colSpan={6} className="px-6 py-4"><div className="h-4 bg-gray-100 dark:bg-slate-700 rounded animate-pulse" /></td></tr>)
              ) : projects.map((p: any) => (
                <tr key={p._id} className="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                  <td className="px-6 py-4">
                    <p className="font-medium text-gray-900 dark:text-white text-sm">{p.title}</p>
                    <p className="text-xs text-gray-400 mt-0.5">{p.slug}</p>
                  </td>
                  <td className="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 capitalize">{p.category}</td>
                  <td className="px-6 py-4"><Badge variant={p.status as any}>{p.status}</Badge></td>
                  <td className="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{p.stats?.views || 0}</td>
                  <td className="px-6 py-4 text-sm text-gray-500">{format(new Date(p.createdAt), 'MMM dd, yyyy')}</td>
                  <td className="px-6 py-4">
                    <div className="flex items-center justify-end gap-2">
                      <Link href={`/projects/${p.slug}`} target="_blank"><button className="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"><ExternalLink className="h-4 w-4" /></button></Link>
                      <Link href={`/admin/projects/${p._id}`}><button className="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"><Edit className="h-4 w-4" /></button></Link>
                      <button onClick={() => handleDelete(p._id, p.title)} className="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"><Trash2 className="h-4 w-4" /></button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
          {!isLoading && projects.length === 0 && (
            <div className="py-16 text-center">
              <p className="text-gray-400 mb-4">No projects found.</p>
              <Link href="/admin/projects/new"><Button size="sm" leftIcon={<Plus className="h-4 w-4" />}>Create First Project</Button></Link>
            </div>
          )}
        </div>
      </div>
    </AdminLayout>
  );
}
