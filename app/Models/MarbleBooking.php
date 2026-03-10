<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarbleBooking extends Model
{
    protected $guarded = [];


    public function user() {
    return $this->belongsTo(User::class);
    }

    public function registration() {
    return $this->belongsTo(UserRegistration::class);
    }

    public function burial() {
        return $this->belongsTo(Burial::class, 'grave_id', 'grave_id');
    // return $this->belongsTo(Burial::class);
    }

}
