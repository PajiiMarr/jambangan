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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->string('title');
            $table->text('content');
            $table->string('spp_status')->default('preview');
            $table->timestamps();
        
            $table->unsignedBigInteger('event_id')->nullable();
        
            $table->foreign('event_id')
                ->references('event_id')
                ->on('events')
                ->onDelete('set null');
            
            $table->unsignedBigInteger('performance_id')->nullable();
        
            $table->foreign('performance_id')
                ->references('performance_id')
                ->on('performances')
                ->onDelete('set null');
        
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};