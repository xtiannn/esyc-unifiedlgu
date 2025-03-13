<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'scholarship_status',
        'document_link',
        'interview_date',
        'interview_time',
        'interview_location',
        'rejection_reason',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
