<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Experience extends Model
{
    protected $fillable = [
        'position','company','company_url','location','is_remote',
        'employment_type','start_date','end_date','is_current',
        'description','highlights','tech_used','sort_order',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'is_current'  => 'boolean',
        'is_remote'   => 'boolean',
        'highlights'  => 'array',
        'tech_used'   => 'array',
    ];

    public function scopeOrdered($q) { return $q->orderByDesc('start_date'); }

    public function getDurationAttribute(): string
    {
        $end   = $this->is_current ? now() : $this->end_date;
        $start = $this->start_date;
        $months = $start->diffInMonths($end);
        if ($months < 12) return "{$months} month" . ($months > 1 ? 's' : '');
        $years  = intdiv($months, 12);
        $rem    = $months % 12;
        $str    = "{$years} yr" . ($years > 1 ? 's' : '');
        if ($rem > 0) $str .= " {$rem} mo";
        return $str;
    }

    public function getEndLabelAttribute(): string
    {
        return $this->is_current ? 'Present' : $this->end_date->format('M Y');
    }
}
