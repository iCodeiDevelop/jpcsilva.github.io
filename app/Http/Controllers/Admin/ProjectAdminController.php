<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->orderByDesc('created_at')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Project::generateSlug($data['title']);
        $data = $this->handleThumbnail($request, $data);
        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request, $project->id);
        $data = $this->handleThumbnail($request, $data, $project);
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);
        return back()->with('success', $project->is_featured ? 'Marked as featured.' : 'Removed from featured.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => "nullable|string|max:255|unique:projects,slug,{$ignoreId}",
            'short_description' => 'required|string|max:500',
            'description'       => 'required|string',
            'category'          => 'required|in:web,mobile,systems,data,devops',
            'client'            => 'nullable|string|max:150',
            'completed_at'      => 'nullable|date',
            'tech_stack'        => 'required|string',
            'link_live'         => 'nullable|url|max:255',
            'link_github'       => 'nullable|url|max:255',
            'link_case_study'   => 'nullable|url|max:255',
            'is_featured'       => 'boolean',
            'is_published'      => 'boolean',
            'sort_order'        => 'integer|min:0',
            'meta_title'        => 'nullable|string|max:70',
            'meta_description'  => 'nullable|string|max:160',
        ]) + [
            'tech_stack' => array_filter(array_map('trim', explode(',', $request->tech_stack))),
            'links'      => array_filter([
                'live'       => $request->link_live,
                'github'     => $request->link_github,
                'case_study' => $request->link_case_study,
            ]),
            'is_featured'  => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
        ];
    }

    private function handleThumbnail(Request $request, array $data, ?Project $project = null): array
    {
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('projects', 'public');
            $data['thumbnail'] = $path;
        }
        return $data;
    }
}
