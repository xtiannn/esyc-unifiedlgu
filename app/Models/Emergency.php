<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    use HasFactory;

    protected $table = 'emergency_alerts';


    protected $fillable = [
        'title',
        'message',
        'created_by',
        'media_path',
        'media_type'
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
