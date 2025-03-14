<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'password',
        'birth_date',
        'sex',
        'mobile',
        'city',
        'house',
        'street',
        'barangay',
        'working',
        'occupation',
        'verified',
        'reset_token',
        'reset_token_expiry',
        'otp',
        'otp_expiry',
        'session_token',
        'role',
        'session_id',
        'last_activity'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            $user->name = trim("{$user->last_name}, {$user->first_name} {$user->middle_name}");
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reset_token',
        'otp',
        'session_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'verified' => 'boolean',
        'reset_token_expiry' => 'datetime',
        'otp_expiry' => 'datetime',
        'last_activity' => 'datetime',
    ];

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Super Admin';
    }

    /**
     * Relationships
     */
    public function logs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function scholarships()
    {
        return $this->hasOne(Scholarship::class, 'user_id');
    }

    public function emergencies()
    {
        return $this->hasMany(Emergency::class, 'reported_by');
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

    /**
     * Check if user is working
     */
    public function isWorking(): bool
    {
        return $this->working === 'yes';
    }
}
