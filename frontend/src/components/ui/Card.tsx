import { clsx } from 'clsx';
interface CardProps { children: React.ReactNode; className?: string; hover?: boolean; onClick?: () => void }
export const Card = ({ children, className, hover, onClick }: CardProps) => (
  <div
    onClick={onClick}
    className={clsx(
      'bg-white dark:bg-dark-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm',
      hover && 'transition-all duration-200 hover:shadow-md hover:-translate-y-0.5 cursor-pointer',
      className
    )}
  >
    {children}
  </div>
);
export const CardHeader = ({ children, className }: { children: React.ReactNode; className?: string }) => (
  <div className={clsx('px-6 py-4 border-b border-gray-200 dark:border-gray-700', className)}>{children}</div>
);
export const CardBody = ({ children, className }: { children: React.ReactNode; className?: string }) => (
  <div className={clsx('px-6 py-4', className)}>{children}</div>
);
export const CardFooter = ({ children, className }: { children: React.ReactNode; className?: string }) => (
  <div className={clsx('px-6 py-4 border-t border-gray-200 dark:border-gray-700', className)}>{children}</div>
);
export default Card;
