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
        Schema::create('user_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('father_name');
            $table->string('cnic')->nullable();
            $table->integer('age');
            $table->string('phone');
            $table->text('address');
            $table->enum('payment_method', ['cash', 'card']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('burial_status')->default('not_buried');
            $table->timestamp('registration_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
