<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\User_Registration;
use App\Models\Burial;  

class Grave extends Model
{
    protected $guarded = [];


    public function user() {
    return $this->belongsTo(User::class);
}

public function registration() {
    return $this->belongsTo(UserRegistration::class);
}

public function burial() {
    return $this->hasOne(Burial::class);
}

}

