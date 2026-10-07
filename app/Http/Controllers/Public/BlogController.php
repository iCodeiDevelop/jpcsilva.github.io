<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\{Blog, Setting};

class BlogController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $blogs    = Blog::published()->latest('published_at')->paginate(9);
        return view('public.blog-index', compact('blogs', 'settings'));
    }

    public function show(string $slug)
    {
        $blog     = Blog::where('slug', $slug)->published()->firstOrFail();
        $blog->increment('views');
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $related  = Blog::published()->where('id', '!=', $blog->id)->latest('published_at')->take(3)->get();
        return view('public.blog-detail', compact('blog', 'settings', 'related'));
    }
}
