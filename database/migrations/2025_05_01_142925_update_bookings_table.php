<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Since SQLite doesn't support changing column types directly,
        // we'll create a new table with the desired structure
        Schema::create('bookings_new', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('event_date');
            $table->enum('event_type', ['wedding', 'corporate', 'cultural', 'other']);
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // Copy data from old table to new table
        DB::statement('INSERT INTO bookings_new SELECT * FROM bookings');

        // Drop the old table
        Schema::drop('bookings');

        // Rename the new table to the original name
        Schema::rename('bookings_new', 'bookings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create a backup of the current table
        Schema::create('bookings_old', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('event_date');
            $table->string('event_type');
            $table->text('message');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Copy data from current table to backup
        DB::statement('INSERT INTO bookings_old SELECT * FROM bookings');

        // Drop the current table
        Schema::drop('bookings');

        // Rename the backup to the original name
        Schema::rename('bookings_old', 'bookings');
    }
};
