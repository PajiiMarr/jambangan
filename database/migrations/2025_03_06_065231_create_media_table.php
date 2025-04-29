<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('file_data');
            $table->enum('type', ['image', 'video']);
            
            $table->unsignedBigInteger('post_id')->nullable();
            
            $table->foreign('post_id')
                ->references('post_id')
                ->on('posts')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('performance_id')->nullable();
            
            $table->foreign('performance_id')
                ->references('performance_id')
                ->on('performances')
                ->onDelete('cascade');

            $table->unsignedBigInteger('event_id')->nullable();
            
            $table->foreign('event_id')
                ->references('event_id')
                ->on('events')
                ->onDelete('cascade');

            $table->unsignedBigInteger('officer_id')->nullable();
            
            $table->foreign('officer_id')
                ->references('officer_id')
                ->on('officers')
                ->onDelete('cascade');

            $table->unsignedBigInteger('slide_id')->nullable();
            
            $table->foreign('slide_id')
                ->references('slide_id')
                ->on('slides')
                ->onDelete('cascade');
            
            $table->timestamp('uploaded_at')->useCurrent();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
