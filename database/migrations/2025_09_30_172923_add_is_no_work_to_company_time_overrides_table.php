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
        Schema::table('company_time_overrides', function (Blueprint $table) {
               $table->boolean('is_no_work')->default(false)->after('time_out_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_time_overrides', function (Blueprint $table) {
                    $table->dropColumn('is_no_work');

        });
    }
};
