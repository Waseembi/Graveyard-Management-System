<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserRegistration;
use App\Models\Grave;   

class Burial extends Model
{
    protected $guarded = [];


    public function user() {
    return $this->belongsTo(User::class);
}

public function registration() {
    return $this->belongsTo(UserRegistration::class);
}

public function grave() {
    return $this->belongsTo(Grave::class);
}

}
