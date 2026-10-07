<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','slug','short_description','description','thumbnail','gallery',
        'tech_stack','links','category','client','completed_at','is_featured',
        'is_published','sort_order','views','meta_title','meta_description',
    ];

    protected $casts = [
        'tech_stack'   => 'array',
        'gallery'      => 'array',
        'links'        => 'array',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'completed_at' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = static::generateSlug($project->title);
            }
        });
    }

    public static function generateSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }

    public function scopePublished($q)  { return $q->where('is_published', true); }
    public function scopeFeatured($q)   { return $q->where('is_featured',  true); }
    public function scopeOrdered($q)    { return $q->orderBy('sort_order')->orderByDesc('completed_at'); }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) return $this->thumbnail;
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/placeholder.svg');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'web'     => 'Web Application',
            'mobile'  => 'Mobile App',
            'systems' => 'Systems Development',
            'data'    => 'Data & Analytics',
            'devops'  => 'DevOps & Infrastructure',
            default   => ucfirst($this->category),
        };
    }
}
