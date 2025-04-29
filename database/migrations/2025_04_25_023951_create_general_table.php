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
        Schema::create('general', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('Jambangan');
            $table->string('about_us')->nullable(); // Store about us content
            $table->string('contact_email')->nullable(); // Store contact email
            $table->string('contact_number')->nullable(); // Store contact email
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general');
    }
};
