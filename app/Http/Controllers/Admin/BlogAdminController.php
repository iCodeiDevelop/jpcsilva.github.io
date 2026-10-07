<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogAdminController extends Controller
{
    public function index() { return view('admin.blog.index', ['posts' => Blog::latest()->get()]); }
    public function create() { return view('admin.blog.form', ['post' => new Blog()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }
        Blog::create($data);
        return redirect()->route('admin.blog.index')->with('success', 'Post created.');
    }

    public function show(Blog $blog) { return view('admin.blog.show', compact('blog')); }
    public function edit(Blog $blog) { return view('admin.blog.form', ['post' => $blog]); }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validated($request);
        if ($data['status'] === 'published' && !$blog->published_at) {
            $data['published_at'] = now();
        }
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success', 'Post updated.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'excerpt'          => 'nullable|string|max:400',
            'content'          => 'required|string',
            'tags'             => 'nullable|string',
            'status'           => 'required|in:draft,published',
            'meta_title'       => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['tags']        = $data['tags'] ? array_filter(array_map('trim', explode(',', $data['tags']))) : [];
        $words               = str_word_count(strip_tags($data['content']));
        $data['reading_time']= max(1, ceil($words / 200));
        return $data;
    }
}
