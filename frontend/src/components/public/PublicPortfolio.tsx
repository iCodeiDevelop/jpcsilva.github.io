'use client';
import Navbar from '@/components/shared/Navbar';
import Footer from '@/components/shared/Footer';
import HeroSection from './HeroSection';
import ProjectsSection from './ProjectsSection';
import SkillsSection from './SkillsSection';
import ExperienceSection from './ExperienceSection';
import ContactSection from './ContactSection';
import CertificationsSection from './CertificationsSection';
import BlogPreviewSection from './BlogPreviewSection';

export default function PublicPortfolio({ profile, projects, skills, allSkills, experiences, certifications, blogs }: any) {
  if (!profile) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-4xl font-bold text-gray-900 dark:text-white mb-4">Portfolio</h1>
          <p className="text-gray-500">Coming soon...</p>
        </div>
      </div>
    );
  }

  return (
    <>
      <Navbar resumeUrl={profile.resume} />
      <HeroSection profile={profile} />
      {projects.length > 0     && <ProjectsSection projects={projects} />}
      {Object.keys(skills).length > 0 && <SkillsSection grouped={skills} />}
      {experiences.length > 0  && <ExperienceSection experiences={experiences} />}
      {certifications.length > 0 && <CertificationsSection certifications={certifications} />}
      {blogs.length > 0        && <BlogPreviewSection blogs={blogs} />}
      {profile.features?.contactFormEnabled && <ContactSection profile={profile} />}
      <Footer profile={profile} />
    </>
  );
}
