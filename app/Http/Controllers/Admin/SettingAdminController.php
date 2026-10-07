<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingAdminController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowed = [
            'hero_greeting','hero_headline','hero_tagline','hero_cta_primary','hero_cta_secondary',
            'about_bio','about_tagline','availability_status','availability_note','resume_url',
            'full_name','display_name','title','location','email','timezone',
            'github_url','linkedin_url','facebook_url','twitter_url','upwork_url',
            'meta_title','meta_description','meta_keywords','og_image',
            'contact_heading','contact_subheading',
        ];
        foreach ($allowed as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }
        return back()->with('success', 'Settings saved successfully.');
    }
}
