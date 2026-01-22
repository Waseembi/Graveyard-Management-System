<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserRegistration;
use App\Models\Payment;
use Carbon\Carbon;

class UpdateExpiredMembers extends Command
{
    // Command signature
    protected $signature = 'users:update-expired';

    // Description
    protected $description = 'Update expired users to pending and insert unpaid payment record based on last payment year';

    public function handle()
    {
        // protected $signature = 'users:update-expired'; 
        // protected $description = 'Update status to pending when expiry date passes'; 

        // public function handle() { 
        //     UserRegistration::where('status', 'approved') 
        //     ->where('expiry_date', '<', Carbon::today())
        //      ->update([ 'status' => 'pending', 'approved_at' => null, 'expiry_date' => null, 
        //     ]); 
        //     $this->info('Expired users updated successfully.'); 
        // }

        // run this commands manually so it can be tested to unapproved expired members
        // php artisan users:update-expired
            // Get all expired approved users
        // Get all expired approved users
        $expiredUsers = UserRegistration::where('status', 'approved')
            ->where('expiry_date', '<', Carbon::today())
            ->get();

        foreach ($expiredUsers as $user) {
            // Update user registration status
            $user->update([
                'status' => 'pending',
                'approved_at' => null,
                'expiry_date' => null,
            ]);

            // Find the last payment year for this user
            $lastPayment = Payment::where('user_id', $user->user_id)
                ->orderByDesc('payment_year')
                ->first();

            // If user has paid before, next year = last payment year + 1
            // Otherwise fallback to current year
            $nextYear = $lastPayment
                ? $lastPayment->payment_year + 1
                : Carbon::today()->year;

            // Check if unpaid record already exists for this user/year
            $exists = Payment::where('user_id', $user->user_id)
                ->where('payment_year', $nextYear)
                ->exists();

            if (!$exists) {
                Payment::create([
                    'registration_id' => $user->id,
                    'user_id' => $user->user_id,
                    'method' => null, // filled when user pays
                    'amount' => null, // filled when user pays
                    'purpose' => 'Annual Grave Fee',
                    'payment_date' => null, // stays null until payment
                    'payment_year' => $nextYear,
                    'status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->info('Expired users updated and unpaid payment records created successfully.');
    }
}
