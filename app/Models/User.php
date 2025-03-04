<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\ScholarshipController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'reset_token',
        'reset_expires',
        'contact_number',
        'address',
        'birth_date',
        'gender',
        'civil_status',
        'occupation',
        'household_number',
        'barangay_id',
        'is_resident',
        'profile_picture',
        'is_agent'
    ];

    public function logs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function scholarships()
    {
        return $this->hasMany(ScholarshipController::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    public function assignedConversations()
    {
        return $this->hasMany(Conversation::class, 'agent_id');
    }


    public function isAgent(): bool
    {
        return $this->is_agent;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_agent' => 'boolean',
        ];
    }
}
