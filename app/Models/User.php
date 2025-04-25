<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'address',
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
        'last_activity',
    ];

    /**
     * Boot method for the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            $user->name = trim(
                "{$user->last_name}, {$user->first_name}" .
                    ($user->middle_name ? " {$user->middle_name}" : '') .
                    ($user->suffix ? " {$user->suffix}" : '')
            );
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'verified' => 'boolean',
        'reset_token_expiry' => 'datetime',
        'otp_expiry' => 'datetime',
        'last_activity' => 'datetime',
    ];

    /**
     * Accessor for full name.
     */
    public function getNameAttribute()
    {
        return trim(
            ucfirst($this->first_name) .
                ($this->middle_name ? ' ' . ucfirst($this->middle_name) : '') .
                ' ' . ucfirst($this->last_name)
        );
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['Super Admin', 'Admin']);
    }

    /**
     * Check if the user is working.
     */
    public function isWorking(): bool
    {
        return strtolower($this->working) === 'yes';
    }

    /**
     * Relationships
     */

    // User's logs
    public function logs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Scholarship assigned to user
    public function scholarships()
    {
        return $this->hasOne(Scholarship::class, 'user_id');
    }

    // Emergencies reported by the user
    public function emergencies()
    {
        return $this->hasMany(Emergency::class, 'reported_by');
    }

    // Messages sent by the user
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Conversations initiated by the user
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    // Conversations assigned to the user (as an agent)
    public function assignedConversations()
    {
        return $this->hasMany(Conversation::class, 'agent_id');
    }
}
