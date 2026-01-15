<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use  App\Models\UserRegistration;
use Carbon\Carbon;

class UpdateExpiredMembers extends Command
{
    // Command signature  
    protected $signature = 'users:update-expired'; 
    // Description protected 
    protected $description = 'Update status to pending when expiry date passes'; 

    public function handle() { 
        UserRegistration::where('status', 'approved') 
        ->where('expiry_date', '<', Carbon::today())
         ->update([ 'status' => 'pending', 'approved_at' => null, 'expiry_date' => null, 
        ]); 
        $this->info('Expired users updated successfully.'); 
    }

    // run this commands manually so it can be tested to unapproved expired members
    // php artisan users:update-expired

}
