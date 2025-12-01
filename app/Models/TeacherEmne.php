<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherEmne extends Model
{
    protected $table = 'teacher_emner';

    protected $fillable = [
        'user_id',
        'emne',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

