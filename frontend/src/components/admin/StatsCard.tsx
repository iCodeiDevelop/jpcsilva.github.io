import { clsx } from 'clsx';
import type { LucideIcon } from 'lucide-react';

interface StatsCardProps {
  title:     string;
  value:     string | number;
  icon:      LucideIcon;
  change?:   number;
  color?:    'blue' | 'green' | 'purple' | 'orange';
}

const COLORS = {
  blue:   { bg: 'bg-blue-50 dark:bg-blue-900/20',    icon: 'text-blue-600 dark:text-blue-400',   ring: 'ring-blue-500/20' },
  green:  { bg: 'bg-green-50 dark:bg-green-900/20',  icon: 'text-green-600 dark:text-green-400', ring: 'ring-green-500/20' },
  purple: { bg: 'bg-purple-50 dark:bg-purple-900/20',icon: 'text-purple-600 dark:text-purple-400',ring:'ring-purple-500/20' },
  orange: { bg: 'bg-orange-50 dark:bg-orange-900/20',icon: 'text-orange-600 dark:text-orange-400',ring:'ring-orange-500/20' },
};

export default function StatsCard({ title, value, icon: Icon, change, color = 'blue' }: StatsCardProps) {
  const c = COLORS[color];
  return (
    <div className="bg-white dark:bg-dark-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
      <div className="flex items-start justify-between">
        <div>
          <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{title}</p>
          <p className="text-3xl font-bold text-gray-900 dark:text-white">{typeof value === 'number' ? value.toLocaleString() : value}</p>
          {change !== undefined && (
            <p className={clsx('text-sm mt-1 font-medium', change >= 0 ? 'text-green-600' : 'text-red-500')}>
              {change >= 0 ? '↑' : '↓'} {Math.abs(change)}% vs last month
            </p>
          )}
        </div>
        <div className={clsx('p-3 rounded-xl ring-1', c.bg, c.ring)}>
          <Icon className={clsx('h-6 w-6', c.icon)} />
        </div>
      </div>
    </div>
  );
}
