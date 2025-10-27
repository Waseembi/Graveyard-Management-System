<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserRegistration;

class FamilyMember extends Model
{
    protected $guarded = [];


    public function registration() {
    return $this->belongsTo(UserRegistration::class);
    }

    public function user() {
    return $this->belongsTo(User::class);
    }

}
