import { clsx } from 'clsx';
const variants: Record<string, string> = {
  default:  'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
  primary:  'bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-300',
  success:  'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
  warning:  'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
  danger:   'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
  draft:    'bg-gray-100 text-gray-600',
  published:'bg-green-100 text-green-700',
  archived: 'bg-orange-100 text-orange-700',
};
interface BadgeProps { children: React.ReactNode; variant?: keyof typeof variants; className?: string }
export const Badge = ({ children, variant = 'default', className }: BadgeProps) => (
  <span className={clsx('inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium', variants[variant], className)}>
    {children}
  </span>
);
export default Badge;
