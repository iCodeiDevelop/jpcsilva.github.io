import { Suspense } from 'react';
import { Metadata } from 'next';
import PublicPortfolio from '@/components/public/PublicPortfolio';

export const revalidate = 60; // ISR: revalidate every 60 seconds

async function getPortfolioData() {
  const base = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:5000/api';
  try {
    const [profileRes, projectsRes, skillsRes, expRes, certRes, blogRes] = await Promise.allSettled([
      fetch(`${base}/profile`,       { next: { revalidate: 60 } }),
      fetch(`${base}/projects?status=published&limit=20`, { next: { revalidate: 60 } }),
      fetch(`${base}/skills`,        { next: { revalidate: 60 } }),
      fetch(`${base}/experiences`,   { next: { revalidate: 60 } }),
      fetch(`${base}/certifications`,{ next: { revalidate: 60 } }),
      fetch(`${base}/blogs?status=published&limit=6`, { next: { revalidate: 60 } }),
    ]);

    const safeJson = async (res: PromiseSettledResult<Response>) => {
      if (res.status === 'fulfilled' && res.value.ok) {
        const data = await res.value.json();
        return data.data;
      }
      return null;
    };

    return {
      profile:        await safeJson(profileRes),
      projects:      (await safeJson(projectsRes))?.projects       || [],
      skills:        (await safeJson(skillsRes))?.grouped           || {},
      allSkills:     (await safeJson(skillsRes))?.skills            || [],
      experiences:   (await safeJson(expRes))?.experiences          || [],
      certifications:(await safeJson(certRes))?.certifications      || [],
      blogs:         (await safeJson(blogRes))?.blogs               || [],
    };
  } catch {
    return { profile: null, projects: [], skills: {}, allSkills: [], experiences: [], certifications: [], blogs: [] };
  }
}

export async function generateMetadata(): Promise<Metadata> {
  const data = await getPortfolioData();
  const p    = data.profile;
  return {
    title:       p?.seo?.metaTitle       || p?.name       || 'Portfolio',
    description: p?.seo?.metaDescription || p?.shortBio   || 'Developer Portfolio',
    keywords:    p?.seo?.keywords?.join(', '),
    openGraph: {
      title:       p?.seo?.metaTitle || p?.name,
      description: p?.seo?.metaDescription || p?.shortBio,
      images:      p?.seo?.ogImage ? [p.seo.ogImage] : [],
    },
  };
}

export default async function HomePage() {
  const data = await getPortfolioData();
  return (
    <Suspense fallback={<div className="min-h-screen flex items-center justify-center"><div className="animate-spin h-10 w-10 border-4 border-primary-500 border-t-transparent rounded-full" /></div>}>
      <PublicPortfolio {...data} />
    </Suspense>
  );
}
