<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationAdminController extends Controller
{
    public function index() { return view('admin.certifications.index', ['certs' => Certification::orderBy('sort_order')->get()]); }
    public function create() { return view('admin.certifications.form', ['cert' => new Certification()]); }

    public function store(Request $request)
    {
        Certification::create($this->validated($request));
        return redirect()->route('admin.certifications.index')->with('success', 'Certification added.');
    }

    public function edit(Certification $certification) { return view('admin.certifications.form', ['cert' => $certification]); }

    public function update(Request $request, Certification $certification)
    {
        $certification->update($this->validated($request));
        return redirect()->route('admin.certifications.index')->with('success', 'Certification updated.');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();
        return redirect()->route('admin.certifications.index')->with('success', 'Certification deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'           => 'required|string|max:200',
            'issuer'         => 'required|string|max:150',
            'issued_at'      => 'required|date',
            'expires_at'     => 'nullable|date',
            'credential_id'  => 'nullable|string|max:100',
            'credential_url' => 'nullable|url|max:255',
            'skills_covered' => 'nullable|string',
            'sort_order'     => 'integer|min:0',
        ]);
        $data['is_visible']     = $request->boolean('is_visible');
        $data['skills_covered'] = $data['skills_covered']
            ? array_filter(array_map('trim', explode(',', $data['skills_covered']))) : [];
        return $data;
    }
}
