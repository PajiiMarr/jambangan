<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id('performance_id');
            $table->string('title');
            // $table->enum('category', ['Cultural Dance', 'Folk Dance', 'Special ']);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            // $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('performances');
    }
};
