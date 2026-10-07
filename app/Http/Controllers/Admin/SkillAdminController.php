<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillAdminController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('sort_order')->orderBy('category')->get()->groupBy('category');
        return view('admin.skills.index', compact('skills'));
    }

    public function create() { return view('admin.skills.form', ['skill' => new Skill()]); }

    public function store(Request $request)
    {
        Skill::create($this->validated($request));
        return redirect()->route('admin.skills.index')->with('success', 'Skill added.');
    }

    public function edit(Skill $skill) { return view('admin.skills.form', compact('skill')); }

    public function update(Request $request, Skill $skill)
    {
        $skill->update($this->validated($request));
        return redirect()->route('admin.skills.index')->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order ?? [] as $index => $id) {
            Skill::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'             => 'required|string|max:80',
            'category'         => 'required|in:backend,frontend,database,devops,tools,design,soft',
            'proficiency'      => 'required|integer|min:0|max:100',
            'hex_color'        => 'required|string|max:7',
            'years_experience' => 'required|integer|min:0|max:50',
            'icon'             => 'nullable|string|max:100',
            'is_visible'       => 'boolean',
            'is_featured'      => 'boolean',
            'sort_order'       => 'integer|min:0',
        ]) + ['is_visible' => $request->boolean('is_visible'), 'is_featured' => $request->boolean('is_featured')];
    }
}
