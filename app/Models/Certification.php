<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'name','issuer','issued_at','expires_at','credential_id',
        'credential_url','badge_image','skills_covered','is_visible','sort_order',
    ];

    protected $casts = [
        'issued_at'      => 'date',
        'expires_at'     => 'date',
        'skills_covered' => 'array',
        'is_visible'     => 'boolean',
    ];

    public function scopeVisible($q) { return $q->where('is_visible', true)->orderBy('sort_order'); }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
