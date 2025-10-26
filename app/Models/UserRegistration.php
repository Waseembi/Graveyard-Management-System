<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Grave;
use App\Models\Payment;
use App\Models\FamilyMember;    

class UserRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'father_name',
        'cnic',
        'age',
        'phone',
        'address',
        'payment_method',
        'status',
    ];

    public function user() {
    return $this->belongsTo(User::class);
}

public function graves() {
    return $this->hasMany(Grave::class);
}

public function payments() {
    return $this->hasMany(Payment::class);
}

public function familyMembers() {
    return $this->hasMany(Family_Member::class);
}

public function marbleBookings() {
    return $this->hasMany(Marble_Booking::class);
}

public function burials() {
    return $this->hasMany(Burial::class);
}

}
