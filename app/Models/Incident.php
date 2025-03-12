<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    protected $table = 'incident_logs';
    protected $fillable = [
        'incident_type',
        'description',
        'media_type',
        'media_path',
        'location',
        'status',
        'reported_by',
    ];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
