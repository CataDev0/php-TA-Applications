<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        "phone",
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

    public function fullName()
    {
        return $this->getAttributeValue("firstname") . " " . $this->getAttributeValue("lastname");
    }

    public function getRoleName()
    {
        return $this->getAttributeValue("role") === "ta" ? "Teaching Assistant" : "Teacher";
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

    // Get teacher's assigned emner
    public function teacherEmner()
    {
        return $this->hasMany(TeacherEmne::class, 'user_id');
    }

    // Get TA's assigned emner
    public function taEmner()
    {
        return $this->hasMany(TAEmne::class, 'user_id');
    }

    // Check if teacher has access to an emne
    public function hasEmne($emne)
    {
        if ($this->isTeacher()) {
            return $this->teacherEmner()->where('emne', $emne)->exists();
        }
        if ($this->isTA()) {
            return $this->taEmner()->where('emne', $emne)->exists();
        }
        return false;
    }

    // Get list of emner names
    public function getEmnerList()
    {
        if ($this->isTeacher()) {
            return $this->teacherEmner()->pluck('emne')->toArray();
        }
        if ($this->isTA()) {
            return $this->taEmner()->pluck('emne')->toArray();
        }
        return [];
    }
}
