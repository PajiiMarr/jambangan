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
        // database/migrations/xxxx_create_page_views_table.php
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->integer('views')->default(1);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
