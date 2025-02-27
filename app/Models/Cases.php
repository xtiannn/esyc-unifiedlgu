<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $fillable = [
        'case_title',
        'case_type',
        'guardian_name',
        'guardian_contact',
        'notes',
        'created_by',
        'status',
    ];
}
