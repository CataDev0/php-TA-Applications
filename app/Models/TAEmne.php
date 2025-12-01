<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAEmne extends Model
{
    protected $table = 'ta_emner';

    protected $fillable = [
        'user_id',
        'emne',
    ];

    public function ta()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
