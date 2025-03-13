<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profile extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'password',
        'address',
        'birth_date',
        'gender',
        'civil_status',
        'occupation',
        'household_number',
        'barangay_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'birth_date' => 'date',
    ];
}

