<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\{Project, Skill, Experience, Certification, Blog, Setting};

class HomeController extends Controller
{
    public function index()
    {
        $settings       = Setting::all()->pluck('value', 'key')->toArray();
        $featuredProjects = Project::published()->featured()->ordered()->get();
        $allProjects    = Project::published()->ordered()->get();
        $skillsGrouped  = Skill::visible()->ordered()->get()->groupBy('category');
        $experiences    = Experience::ordered()->get();
        $certifications = Certification::visible()->get();
        $featuredBlogs  = Blog::published()->featured()->latest('published_at')->take(3)->get();
        $services       = json_decode($settings['services'] ?? '[]', true);

        return view('public.home', compact(
            'settings', 'featuredProjects', 'allProjects',
            'skillsGrouped', 'experiences', 'certifications',
            'featuredBlogs', 'services'
        ));
    }
}
