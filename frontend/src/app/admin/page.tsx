'use client';
import { Eye, FolderOpen, Send, TrendingUp } from 'lucide-react';
import { LineChart, Line, BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';
import AdminLayout from '@/components/admin/AdminLayout';
import StatsCard from '@/components/admin/StatsCard';
import { useDashboardStats } from '@/hooks/useQuery';
import { format } from 'date-fns';

export default function AdminDashboard() {
  const { data, isLoading } = useDashboardStats();
  const stats   = data?.overview;
  const viewsData = (data?.viewsByDay || []).map((d: any) => ({
    date: format(new Date(d._id), 'MMM dd'), views: d.count,
  }));

  return (
    <AdminLayout>
      <div className="space-y-8">
        <div>
          <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
          <p className="text-sm text-gray-500 mt-1">Overview of your portfolio performance.</p>
        </div>
        {isLoading ? (
          <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
            {[...Array(4)].map((_,i) => <div key={i} className="h-28 bg-gray-100 dark:bg-slate-700 rounded-xl animate-pulse" />)}
          </div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <StatsCard title="Total Views"       value={stats?.totalViews    || 0} icon={Eye}       color="blue"   />
            <StatsCard title="30-Day Views"      value={stats?.recentViews   || 0} icon={TrendingUp} color="green"  />
            <StatsCard title="Published Projects"value={stats?.totalProjects || 0} icon={FolderOpen} color="purple" />
            <StatsCard title="Contact Submissions"value={stats?.contactSubmits || 0} icon={Send}    color="orange" />
          </div>
        )}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h2 className="font-semibold text-gray-900 dark:text-white mb-4">Page Views (Last 30 Days)</h2>
            <ResponsiveContainer width="100%" height={200}>
              <LineChart data={viewsData}>
                <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" />
                <XAxis dataKey="date" tick={{ fontSize: 11 }} />
                <YAxis tick={{ fontSize: 11 }} />
                <Tooltip />
                <Line type="monotone" dataKey="views" stroke="#2563eb" strokeWidth={2} dot={false} />
              </LineChart>
            </ResponsiveContainer>
          </div>
          <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h2 className="font-semibold text-gray-900 dark:text-white mb-4">Top Projects</h2>
            <ResponsiveContainer width="100%" height={200}>
              <BarChart data={(data?.topProjects || []).map((p: any) => ({ name: p.title.slice(0,20), views: p.stats?.views || 0 }))} layout="vertical">
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis type="number" tick={{ fontSize: 11 }} />
                <YAxis type="category" dataKey="name" tick={{ fontSize: 10 }} width={110} />
                <Tooltip />
                <Bar dataKey="views" fill="#2563eb" radius={[0,4,4,0]} />
              </BarChart>
            </ResponsiveContainer>
          </div>
        </div>
        <div className="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
          <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 className="font-semibold text-gray-900 dark:text-white">Recent Activity Log</h2>
          </div>
          <div className="divide-y divide-gray-100 dark:divide-gray-700 max-h-72 overflow-y-auto">
            {(data?.recentActivity || []).slice(0,10).map((log: any, i: number) => (
              <div key={i} className="flex items-center gap-4 px-6 py-3">
                <div className="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-xs font-bold text-blue-700 dark:text-blue-400">
                  {log.user?.name?.charAt(0) || 'S'}
                </div>
                <div className="flex-1">
                  <p className="text-sm text-gray-700 dark:text-gray-300">
                    <span className="font-medium">{log.user?.name || 'System'}</span>
                    {' '}<span className="text-gray-400">{log.action?.toLowerCase()}</span>
                    {' '}<span className="text-blue-600 dark:text-blue-400 capitalize">{log.resource}</span>
                  </p>
                </div>
                <time className="text-xs text-gray-400 shrink-0">{format(new Date(log.createdAt), 'MMM dd HH:mm')}</time>
              </div>
            ))}
            {(!data?.recentActivity || data.recentActivity.length === 0) && (
              <p className="px-6 py-8 text-sm text-center text-gray-400">No activity yet.</p>
            )}
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
