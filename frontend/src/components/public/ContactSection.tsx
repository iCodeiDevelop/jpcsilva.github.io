'use client';
import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { motion } from 'framer-motion';
import { Send, MapPin, Mail, Phone, Github, Linkedin, Twitter, CheckCircle2 } from 'lucide-react';
import { Button } from '@/components/ui/Button';
import { Input, Textarea } from '@/components/ui/Input';
import { api, getErrorMessage } from '@/lib/api';
import type { Profile } from '@/types';

const schema = z.object({
  name:    z.string().min(2, 'Name required').max(100),
  email:   z.string().email('Valid email required'),
  subject: z.string().min(5, 'Subject too short').max(200),
  message: z.string().min(20, 'Message too short (min 20 chars)').max(5000),
});
type FormData = z.infer<typeof schema>;

export default function ContactSection({ profile }: { profile: Profile }) {
  const [sent,  setSent]  = useState(false);
  const [error, setError] = useState('');

  const { register, handleSubmit, reset, formState: { errors, isSubmitting } } = useForm<FormData>({
    resolver: zodResolver(schema),
  });

  const onSubmit = async (data: FormData) => {
    setError('');
    try {
      await api.post('/contact', data);
      setSent(true);
      reset();
    } catch (err) {
      setError(getErrorMessage(err));
    }
  };

  return (
    <section id="contact" className="py-24 bg-white dark:bg-dark-900">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div initial={{ opacity:0, y:20 }} whileInView={{ opacity:1, y:0 }} viewport={{ once:true }} className="text-center mb-16">
          <h2 className="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
            Get In <span className="text-primary-600">Touch</span>
          </h2>
          <p className="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
            Have a project in mind or want to collaborate? I'd love to hear from you.
          </p>
        </motion.div>

        <div className="grid grid-cols-1 lg:grid-cols-5 gap-12">
          {/* Info column */}
          <motion.div initial={{ opacity:0, x:-30 }} whileInView={{ opacity:1, x:0 }} viewport={{ once:true }} className="lg:col-span-2 space-y-8">
            <div>
              <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-4">Contact Info</h3>
              <div className="space-y-4">
                {profile.location && <InfoItem icon={<MapPin className="h-5 w-5" />} text={profile.location} />}
                {profile.email    && <InfoItem icon={<Mail    className="h-5 w-5" />} text={profile.email}    href={`mailto:${profile.email}`} />}
                {profile.phone    && <InfoItem icon={<Phone   className="h-5 w-5" />} text={profile.phone} />}
              </div>
            </div>

            {/* Social links */}
            <div>
              <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Find me online</h3>
              <div className="flex flex-wrap gap-3">
                {profile.social?.github   && <SocialBtn href={profile.social.github}   icon={<Github   className="h-5 w-5" />} label="GitHub"   />}
                {profile.social?.linkedin && <SocialBtn href={profile.social.linkedin} icon={<Linkedin className="h-5 w-5" />} label="LinkedIn" />}
                {profile.social?.twitter  && <SocialBtn href={profile.social.twitter}  icon={<Twitter  className="h-5 w-5" />} label="Twitter"  />}
              </div>
            </div>

            {/* Availability */}
            {profile.available && (
              <div className="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                <p className="text-sm font-semibold text-green-800 dark:text-green-400 flex items-center gap-2">
                  <span className="h-2 w-2 rounded-full bg-green-500 animate-pulse" />
                  Open to opportunities
                </p>
                {profile.availabilityNote && (
                  <p className="text-sm text-green-700 dark:text-green-500 mt-1">{profile.availabilityNote}</p>
                )}
              </div>
            )}
          </motion.div>

          {/* Form column */}
          <motion.div initial={{ opacity:0, x:30 }} whileInView={{ opacity:1, x:0 }} viewport={{ once:true }} className="lg:col-span-3">
            {sent ? (
              <div className="h-full flex flex-col items-center justify-center text-center p-12">
                <CheckCircle2 className="h-16 w-16 text-green-500 mb-4" />
                <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">Message Sent!</h3>
                <p className="text-gray-500 dark:text-gray-400 mb-6">Thanks for reaching out. I'll get back to you within 24 hours.</p>
                <Button onClick={() => setSent(false)} variant="outline">Send Another</Button>
              </div>
            ) : (
              <form onSubmit={handleSubmit(onSubmit)} className="bg-gray-50 dark:bg-dark-800 rounded-2xl p-8 border border-gray-200 dark:border-gray-700 space-y-5">
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                  <Input label="Your Name" placeholder="John Doe" error={errors.name?.message} {...register('name')} required />
                  <Input label="Email Address" type="email" placeholder="john@example.com" error={errors.email?.message} {...register('email')} required />
                </div>
                <Input label="Subject" placeholder="Project inquiry..." error={errors.subject?.message} {...register('subject')} required />
                <Textarea label="Message" placeholder="Tell me about your project..." rows={6} error={errors.message?.message} {...register('message')} />
                {error && <p className="text-sm text-red-600 bg-red-50 dark:bg-red-900/20 rounded-lg px-4 py-3">{error}</p>}
                <Button type="submit" size="lg" isLoading={isSubmitting} leftIcon={<Send className="h-4 w-4" />} className="w-full">
                  {isSubmitting ? 'Sending...' : 'Send Message'}
                </Button>
              </form>
            )}
          </motion.div>
        </div>
      </div>
    </section>
  );
}

const InfoItem = ({ icon, text, href }: { icon: React.ReactNode; text: string; href?: string }) => (
  <div className="flex items-center gap-3 text-gray-600 dark:text-gray-400">
    <div className="p-2 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-lg">{icon}</div>
    {href ? <a href={href} className="hover:text-primary-600 transition-colors">{text}</a> : <span>{text}</span>}
  </div>
);

const SocialBtn = ({ href, icon, label }: { href: string; icon: React.ReactNode; label: string }) => (
  <a href={href} target="_blank" rel="noopener noreferrer"
    className="flex items-center gap-2 px-4 py-2 bg-white dark:bg-dark-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-600 dark:text-gray-400 hover:border-primary-400 hover:text-primary-600 transition-all text-sm font-medium">
    {icon} {label}
  </a>
);
