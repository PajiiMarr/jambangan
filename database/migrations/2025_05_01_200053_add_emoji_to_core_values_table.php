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
        Schema::table('core_values', function (Blueprint $table) {
            $table->string('emoji', 10)->nullable()->after('core_value_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('core_values', function (Blueprint $table) {
            $table->dropColumn('emoji');
        });
    }
};
