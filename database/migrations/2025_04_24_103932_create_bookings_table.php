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
            $table->string('client_name');
            $table->string('contact_number');
            $table->string('email');
            $table->string('event_name');
            $table->date('event_date');
            $table->string('event_time');
            $table->text('event_location');

            $table->unsignedBigInteger('performance_id')->nullable();
            
            $table->foreign('performance_id')
                ->references('performance_id')
                ->on('performances')
                ->onDelete('cascade');

            $table->decimal('fee', 10, 2);
            $table->string('status')->default('Pending'); // Default to 'Pending'
            $table->timestamp('created_at')->useCurrent();
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
