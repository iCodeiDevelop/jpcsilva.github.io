import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import { ThemeProvider } from 'next-themes';
import { QueryProvider } from '@/components/shared/QueryProvider';
import { Toaster } from 'react-hot-toast';
import './globals.css';

const inter = Inter({ subsets: ['latin'], variable: '--font-inter' });

export const metadata: Metadata = {
  title:       { default: 'Portfolio', template: '%s | Portfolio' },
  description: 'Full-Stack Developer Portfolio',
  keywords:    ['developer', 'portfolio', 'react', 'nodejs'],
  authors:     [{ name: 'Portfolio Owner' }],
  viewport:    'width=device-width, initial-scale=1',
  robots:      'index, follow',
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en" suppressHydrationWarning>
      <body className={`${inter.variable} font-sans antialiased`}>
        <ThemeProvider attribute="class" defaultTheme="system" enableSystem>
          <QueryProvider>
            {children}
            <Toaster position="top-right" toastOptions={{
              duration: 4000,
              style: { borderRadius: '10px', background: '#333', color: '#fff' },
            }} />
          </QueryProvider>
        </ThemeProvider>
      </body>
    </html>
  );
}
