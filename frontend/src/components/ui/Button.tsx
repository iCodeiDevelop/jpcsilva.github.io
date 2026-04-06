import React from 'react';
import { clsx } from 'clsx';
import { Loader2 } from 'lucide-react';

interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  variant?:  'primary' | 'secondary' | 'ghost' | 'danger' | 'outline';
  size?:     'sm' | 'md' | 'lg';
  isLoading?:boolean;
  leftIcon?:  React.ReactNode;
  rightIcon?: React.ReactNode;
}

const variants = {
  primary:   'bg-primary-600 hover:bg-primary-700 text-white shadow-sm',
  secondary: 'bg-gray-100 hover:bg-gray-200 dark:bg-dark-800 dark:hover:bg-dark-700 text-gray-900 dark:text-white',
  ghost:     'hover:bg-gray-100 dark:hover:bg-dark-800 text-gray-700 dark:text-gray-300',
  danger:    'bg-red-600 hover:bg-red-700 text-white',
  outline:   'border border-primary-600 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20',
};

const sizes = {
  sm:  'px-3 py-1.5 text-sm rounded-md gap-1.5',
  md:  'px-4 py-2   text-sm rounded-lg gap-2',
  lg:  'px-6 py-3   text-base rounded-lg gap-2.5',
};

export const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
  ({ variant='primary', size='md', isLoading, leftIcon, rightIcon, children, className, disabled, ...props }, ref) => (
    <button
      ref={ref}
      disabled={disabled || isLoading}
      className={clsx(
        'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed',
        variants[variant], sizes[size], className
      )}
      {...props}
    >
      {isLoading ? <Loader2 className="h-4 w-4 animate-spin" /> : leftIcon}
      {children}
      {!isLoading && rightIcon}
    </button>
  )
);
Button.displayName = 'Button';
export default Button;
