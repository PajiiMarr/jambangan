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
        Schema::create('officers', function (Blueprint $table) {
            $table->id('officer_id');
            $table->string('name');
            $table->string('position');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officers');
    }
};
