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
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('company_id');
            $table->date('date');
            $table->time('scan_start')->nullable();
            $table->time('scan_end')->nullable();
            $table->decimal('approved_hours', 4, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamps();

            // ✅ explicit foreign key references (adjust if your table names differ)
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime_requests');
    }
};
