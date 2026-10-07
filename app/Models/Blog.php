<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title','slug','excerpt','content','cover_image','tags','status',
        'is_featured','reading_time','views','published_at','meta_title','meta_description',
    ];

    protected $casts = [
        'tags'         => 'array',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $base = Str::slug($blog->title);
                $slug = $base; $i = 1;
                while (static::where('slug', $slug)->exists()) { $slug = "{$base}-{$i}"; $i++; }
                $blog->slug = $slug;
            }
            if (empty($blog->reading_time)) {
                $words = str_word_count(strip_tags($blog->content));
                $blog->reading_time = max(1, ceil($words / 200));
            }
        });
    }

    public function scopePublished($q) { return $q->where('status', 'published'); }
    public function scopeFeatured($q)  { return $q->where('is_featured', true); }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/blog-placeholder.svg');
    }
}
