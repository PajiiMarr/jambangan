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
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('spp_status')->default('preview');
            $table->string('status')->default('active');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performances');
    }
};
