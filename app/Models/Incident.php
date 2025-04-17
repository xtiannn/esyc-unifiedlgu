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
        'latitude',
        'longitude',
        'description',
        'media_type',
        'media_path',
        'location',
        'status',
        'reported_by',
        'contact_number',

    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
