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
        // Drop the existing table
        Schema::dropIfExists('bookings');

        // Create the table with new structure
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Full Name
            $table->string('email'); // Email Address
            $table->string('phone'); // Phone Number
            $table->date('event_date'); // Event Date
            $table->string('event_type'); // Event Type
            $table->text('message')->nullable(); // Additional Details
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new table
        Schema::dropIfExists('bookings');

        // Recreate the original table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('contact_number');
            $table->string('email');
            $table->string('event_name');
            $table->date('event_date');
            $table->string('event_time');
            $table->text('event_location');
            $table->unsignedBigInteger('performance_id')->nullable();
            $table->decimal('fee', 10, 2);
            $table->string('status')->default('Pending');
            $table->timestamps();

            $table->foreign('performance_id')
                ->references('performance_id')
                ->on('performances')
                ->onDelete('cascade');
        });
    }
};
