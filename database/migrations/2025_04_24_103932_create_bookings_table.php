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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // Unique booking ID
            $table->string('name');
            $table->string('phone');
            $table->string('email');

            $table->string('status')->default('pending');
            
            $table->date('event_start_date');
            $table->date('event_end_date');
            
            $table->string('event_type');
            $table->text('message');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
