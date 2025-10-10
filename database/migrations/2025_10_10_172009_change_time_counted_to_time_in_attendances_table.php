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
             $table->time('time_in_counted')->nullable()->after('time_in')->change();
            $table->time('time_out_counted')->nullable()->after('time_out')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
             $table->dropColumn(['time_in_counted', 'time_out_counted']);
        });

    }
};
