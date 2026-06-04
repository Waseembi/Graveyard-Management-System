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
        Schema::create('burial_requests', function (Blueprint $table) {
        $table->id();

        // The account user who registered them
        $table->unsignedBigInteger('user_id');

        // The specific registered person being buried
        $table->unsignedBigInteger('registration_id');
        $table->string('name');
        $table->string('father_name');
        $table->string('cnic')->nullable();
        $table->integer('age');
        $table->string('phone');
        $table->text('address');
        $table->enum('gender', ['male', 'female']);
        $table->date('dob');
        $table->date('date_of_death');
        $table->boolean('in_process')->default(false);

        $table->string('death_certificate');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('registration_id')->references('id')->on('user_registrations')->onDelete('cascade');

        $table->timestamps();

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burial_requests');
    }
};
