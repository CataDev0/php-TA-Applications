<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAPosition extends Model
{
    protected $table = 't_a_positions';

    protected $fillable = [
        'emne',
        'description',
        'positions_available',
        'status',
        'created_by',
    ];

    // Teacher who created the position
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Applications for this position
    public function applications()
    {
        return $this->hasMany(TAApplication::class, 'ta_position_id');
    }

    // Check if position is open
    public function isOpen()
    {
        return $this->status === 'open';
    }
}
