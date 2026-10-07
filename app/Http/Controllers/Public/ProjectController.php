<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\{Project, Setting};

class ProjectController extends Controller
{
    public function show(string $slug)
    {
        $project  = Project::where('slug', $slug)->published()->firstOrFail();
        $project->incrementViews();
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $related  = Project::published()->where('category', $project->category)
                        ->where('id', '!=', $project->id)->take(3)->get();
        return view('public.project-detail', compact('project', 'settings', 'related'));
    }
}
