import Link from 'next/link';
import { Github, Linkedin, Twitter, Mail, Heart } from 'lucide-react';

interface FooterProps {
  profile?: {
    name?: string;
    social?: { github?: string; linkedin?: string; twitter?: string; email?: string };
  };
}

export default function Footer({ profile }: FooterProps) {
  const currentYear = new Date().getFullYear();
  const social = profile?.social || {};

  return (
    <footer className="bg-gray-900 dark:bg-dark-950 text-gray-300 py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col md:flex-row items-center justify-between gap-6">
          <div className="text-center md:text-left">
            <span className="text-xl font-bold text-white">{'<AJ />'}</span>
            <p className="text-sm text-gray-400 mt-1">{profile?.name || 'Portfolio'} — Full-Stack Developer</p>
          </div>
          <div className="flex items-center gap-4">
            {social.github   && <SocialLink href={social.github}   icon={<Github   className="h-5 w-5" />} label="GitHub"   />}
            {social.linkedin && <SocialLink href={social.linkedin} icon={<Linkedin className="h-5 w-5" />} label="LinkedIn" />}
            {social.twitter  && <SocialLink href={social.twitter}  icon={<Twitter  className="h-5 w-5" />} label="Twitter"  />}
            {social.email    && <SocialLink href={`mailto:${social.email}`} icon={<Mail className="h-5 w-5" />} label="Email" />}
          </div>
        </div>
        <div className="mt-8 pt-8 border-t border-gray-800 text-center">
          <p className="text-sm text-gray-500 flex items-center justify-center gap-1">
            © {currentYear} {profile?.name || 'Portfolio'}. Made with <Heart className="h-3.5 w-3.5 text-red-500 fill-red-500" /> using Next.js & Tailwind CSS.
          </p>
        </div>
      </div>
    </footer>
  );
}

const SocialLink = ({ href, icon, label }: { href: string; icon: React.ReactNode; label: string }) => (
  <a href={href} target="_blank" rel="noopener noreferrer" aria-label={label}
    className="p-2.5 rounded-full bg-gray-800 hover:bg-primary-600 text-gray-400 hover:text-white transition-all duration-200">
    {icon}
  </a>
);
