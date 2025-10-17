<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date_time',
        'urgency',
        'status',
        'teacher_id',
        'ta_id',
    ];

    // Teacher who created the task
    public function getTeacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // TA who accepted the task
    public function getTA()
    {
        return $this->belongsTo(User::class, 'ta_id');
    }
}
