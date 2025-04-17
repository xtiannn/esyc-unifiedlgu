<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipRequirement extends Model
{
    protected $table = 'scholarship_requirements';

    protected $fillable = [
        'name',       // Requirement name
        'description' // Requirement description
    ];

    public $timestamps = true;
}
