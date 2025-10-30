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
        'pay',
        'teacher_id',
        'ta_id',
    ];

    // Teacher who created the task
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // TA who accepted the task
    public function TA()
    {
        return $this->belongsTo(User::class, 'ta_id');
    }
}
