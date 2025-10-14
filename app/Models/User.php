<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        "firstname",
        "lastname",
        "username",
        "email",
        "password",
        "role"
    ];

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
        ];
    }

    // Tasks created by teachers
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'teacher_id');
    }

    // Tasks accepted by TAs
    public function acceptedTasks()
    {
        return $this->hasMany(Task::class, 'ta_id');
    }

    // Check if user is teacher
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }
    
    // Check if user is TA
    public function isTA()
    {
        return $this->role === 'ta';
    }
}
