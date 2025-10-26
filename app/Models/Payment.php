<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registration()
    {
        return $this->belongsTo(UserRegistration::class, 'registration_id');
    }
}
