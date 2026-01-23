<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add amount column 
            if (!Schema::hasColumn('payments', 'amount')) 
                { $table->decimal('amount', 10, 2)->nullable()->after('status'); } 
            // Add payment_date column 
            if (!Schema::hasColumn('payments', 'payment_date')) 
                { $table->date('payment_date')->nullable()->after('amount'); } 
            // Add method column 
            if (!Schema::hasColumn('payments', 'method')) {
                 $table->enum('method', ['online', 'cash'])->nullable()->after('payment_date'); }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            Schema::table('payments', function (Blueprint $table) { $table->dropColumn(['amount', 'payment_date', 'method']); });
        });
    }
};
