<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceAdminController extends Controller
{
    public function index() { return view('admin.experience.index', ['experiences' => Experience::ordered()->get()]); }
    public function create() { return view('admin.experience.form', ['experience' => new Experience()]); }

    public function store(Request $request)
    {
        Experience::create($this->validated($request));
        return redirect()->route('admin.experience.index')->with('success', 'Experience added.');
    }

    public function edit(Experience $experience) { return view('admin.experience.form', compact('experience')); }

    public function update(Request $request, Experience $experience)
    {
        $experience->update($this->validated($request));
        return redirect()->route('admin.experience.index')->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experience.index')->with('success', 'Experience deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'position'        => 'required|string|max:150',
            'company'         => 'required|string|max:150',
            'company_url'     => 'nullable|url|max:255',
            'location'        => 'nullable|string|max:150',
            'employment_type' => 'required|string',
            'start_date'      => 'required|date',
            'end_date'        => 'nullable|date|after:start_date',
            'description'     => 'nullable|string',
            'highlights'      => 'nullable|string',
            'tech_used'       => 'nullable|string',
        ]);
        $data['is_current']  = $request->boolean('is_current');
        $data['is_remote']   = $request->boolean('is_remote');
        $data['highlights']  = $data['highlights']
            ? array_filter(array_map('trim', explode("\n", $data['highlights']))) : [];
        $data['tech_used']   = $data['tech_used']
            ? array_filter(array_map('trim', explode(',', $data['tech_used']))) : [];
        if ($data['is_current']) $data['end_date'] = null;
        return $data;
    }
}
