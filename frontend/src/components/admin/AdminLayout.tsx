'use client';
import { useState, useEffect } from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import { clsx } from 'clsx';
import {
  LayoutDashboard, FolderOpen, Wrench, Briefcase, Award, BookOpen,
  User, Settings, LogOut, Menu, X, Bell, ChevronRight, BarChart3
} from 'lucide-react';
import { useAuthStore } from '@/store/authStore';
import toast from 'react-hot-toast';

const NAV_ITEMS = [
  { href: '/admin',                  label: 'Dashboard',      icon: LayoutDashboard, exact: true },
  { href: '/admin/profile',          label: 'Profile',        icon: User     },
  { href: '/admin/projects',         label: 'Projects',       icon: FolderOpen },
  { href: '/admin/skills',           label: 'Skills',         icon: Wrench   },
  { href: '/admin/experience',       label: 'Experience',     icon: Briefcase },
  { href: '/admin/certifications',   label: 'Certifications', icon: Award    },
  { href: '/admin/blog',             label: 'Blog',           icon: BookOpen },
  { href: '/admin/analytics',        label: 'Analytics',      icon: BarChart3 },
  { href: '/admin/settings',         label: 'Settings',       icon: Settings },
];

export default function AdminLayout({ children }: { children: React.ReactNode }) {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const pathname = usePathname();
  const router   = useRouter();
  const { user, logout } = useAuthStore();

  const handleLogout = async () => {
    await logout();
    toast.success('Logged out successfully');
    router.push('/admin/login');
  };

  return (
    <div className="flex h-screen bg-gray-50 dark:bg-dark-950 overflow-hidden">
      {/* Sidebar overlay (mobile) */}
      {sidebarOpen && (
        <div className="fixed inset-0 z-20 bg-black/50 lg:hidden" onClick={() => setSidebarOpen(false)} />
      )}

      {/* Sidebar */}
      <aside className={clsx(
        'fixed lg:static inset-y-0 left-0 z-30 flex flex-col w-64 bg-white dark:bg-dark-900 border-r border-gray-200 dark:border-gray-700 transition-transform duration-300',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
      )}>
        {/* Logo */}
        <div className="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-700">
          <Link href="/admin" className="flex items-center gap-2">
            <div className="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
              <span className="text-white font-bold text-sm">P</span>
            </div>
            <span className="font-bold text-gray-900 dark:text-white">Portfolio CMS</span>
          </Link>
          <button className="lg:hidden text-gray-500" onClick={() => setSidebarOpen(false)}>
            <X className="h-5 w-5" />
          </button>
        </div>

        {/* Navigation */}
        <nav className="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
          {NAV_ITEMS.map(item => {
            const active = item.exact ? pathname === item.href : pathname.startsWith(item.href);
            return (
              <Link key={item.href} href={item.href}
                className={clsx(
                  'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group',
                  active
                    ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-dark-800 hover:text-gray-900 dark:hover:text-white'
                )}
                onClick={() => setSidebarOpen(false)}>
                <item.icon className={clsx('h-5 w-5 shrink-0', active ? 'text-primary-600 dark:text-primary-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300')} />
                {item.label}
                {active && <ChevronRight className="h-4 w-4 ml-auto text-primary-500" />}
              </Link>
            );
          })}
        </nav>

        {/* User info */}
        <div className="p-4 border-t border-gray-200 dark:border-gray-700">
          <div className="flex items-center gap-3 mb-3">
            <div className="w-9 h-9 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
              <span className="text-sm font-bold text-primary-700 dark:text-primary-400">
                {user?.name?.charAt(0) || 'A'}
              </span>
            </div>
            <div className="flex-1 min-w-0">
              <p className="text-sm font-medium text-gray-900 dark:text-white truncate">{user?.name}</p>
              <p className="text-xs text-gray-500 capitalize">{user?.role}</p>
            </div>
          </div>
          <button onClick={handleLogout}
            className="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
            <LogOut className="h-4 w-4" /> Sign Out
          </button>
        </div>
      </aside>

      {/* Main content */}
      <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
        {/* Top bar */}
        <header className="flex items-center justify-between h-16 px-6 bg-white dark:bg-dark-900 border-b border-gray-200 dark:border-gray-700 shrink-0">
          <button className="lg:hidden text-gray-500 hover:text-gray-700" onClick={() => setSidebarOpen(true)}>
            <Menu className="h-6 w-6" />
          </button>
          <div className="flex-1 lg:flex-none">
            <h1 className="text-sm font-semibold text-gray-500 dark:text-gray-400">
              {NAV_ITEMS.find(n => n.exact ? pathname === n.href : pathname.startsWith(n.href))?.label || 'Admin'}
            </h1>
          </div>
          <div className="flex items-center gap-3">
            <Link href="/" target="_blank" className="text-xs text-gray-500 hover:text-primary-600 transition-colors">
              View Portfolio →
            </Link>
            <button className="relative p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
              <Bell className="h-5 w-5" />
            </button>
          </div>
        </header>

        {/* Page content */}
        <main className="flex-1 overflow-y-auto p-6">
          {children}
        </main>
      </div>
    </div>
  );
}
