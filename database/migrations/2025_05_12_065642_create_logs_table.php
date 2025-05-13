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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('action');
            $table->string('navigation');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->unsignedBigInteger('performance_id')->nullable();

            $table->foreign('performance_id')
                ->references('performance_id')
                ->on('performances')
                ->onDelete('set null');

            $table->unsignedBigInteger('post_id')->nullable();

            $table->foreign('post_id')
                ->references('post_id')
                ->on('posts')
                ->onDelete('set null');

            $table->unsignedBigInteger('event_id')->nullable();

            $table->foreign('event_id')
                ->references('event_id')
                ->on('events')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('slide_id')->nullable();

            $table->foreign('slide_id')
                ->references('slide_id')
                ->on('slides')
                ->onDelete('set null');

            $table->unsignedBigInteger('general_id')->nullable();
            $table->foreign('general_id')
                ->references('id')
                ->on('general')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('officer_id')->nullable();
            $table->foreign('officer_id')
                ->references('officer_id')
                ->on('officers')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
