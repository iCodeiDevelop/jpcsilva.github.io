<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name','category','proficiency','icon','hex_color',
        'years_experience','is_visible','is_featured','sort_order',
    ];

    protected $casts = [
        'is_visible'  => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeVisible($q)  { return $q->where('is_visible', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }
    public function scopeOrdered($q)  { return $q->orderBy('sort_order'); }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'backend'  => 'Backend Development',
            'frontend' => 'Frontend Development',
            'database' => 'Database & Storage',
            'devops'   => 'DevOps & Cloud',
            'tools'    => 'Tools & Platforms',
            'design'   => 'Design',
            'soft'     => 'Soft Skills',
            default    => ucfirst($this->category),
        };
    }
}
