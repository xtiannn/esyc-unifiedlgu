<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'published_at'];

    // Accessor to format the date nicely
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->published_at)->format('F d, Y h:i A');
    }
}
