<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\User_Registration;
use App\Models\Payment;
use App\Models\MarbleBooking;
use App\Models\Grave;
use App\Models\Burial;  

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $guarded = [];

    public function role() {
    return $this->belongsTo(Role::class);
}

public function registrations() {
    return $this->hasMany(User_Registration::class);
}

public function payments() {
    return $this->hasMany(Payment::class);
}

public function marbleBookings() {
    return $this->hasMany(Marble_Booking::class);
}

public function graves() {
    return $this->hasMany(Grave::class);
}

public function burials() {
    return $this->hasMany(Burial::class);
}



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
