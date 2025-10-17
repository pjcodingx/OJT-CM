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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('time_in_photo')->nullable()->after('time_in');
            $table->string('time_out_photo')->nullable()->after('time_out');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
             $table->dropColumn(['time_in_photo', 'time_out_photo', 'overtime_photo']);
        });
    }
};
