<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name','email','subject','message','project_type','budget_range','is_read','ip_address',
    ];

    protected $casts = ['is_read' => 'boolean'];

    public function scopeUnread($q) { return $q->where('is_read', false); }
}
