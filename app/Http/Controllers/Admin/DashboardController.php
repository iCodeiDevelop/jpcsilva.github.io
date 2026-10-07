<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Project, Blog, Message, Skill, Experience, Certification};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects'       => Project::count(),
            'published'      => Project::where('is_published', true)->count(),
            'skills'         => Skill::count(),
            'experiences'    => Experience::count(),
            'certifications' => Certification::count(),
            'blogs'          => Blog::count(),
            'blog_published' => Blog::where('status', 'published')->count(),
            'messages'       => Message::count(),
            'unread'         => Message::unread()->count(),
            'total_views'    => Project::sum('views'),
        ];

        $recentMessages  = Message::latest()->take(5)->get();
        $recentProjects  = Project::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects'));
    }
}
