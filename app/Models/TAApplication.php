<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAApplication extends Model
{
    protected $table = 'ta_applications';

    protected $fillable = [
        'ta_position_id',
        'user_id',
        'message',
        'status',
    ];

    // The position being applied to
    public function position()
    {
        return $this->belongsTo(TAPosition::class, 'ta_position_id');
    }

    // The TA who applied
    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
