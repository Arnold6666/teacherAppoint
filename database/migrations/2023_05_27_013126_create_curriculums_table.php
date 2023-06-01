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
        Schema::create('curriculums', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignId('teacher_id')->constrained('teachers');
            $table->foreignId('student_id')->constrained('users');
            $table->date('date');
            $table->time('time');
            $table->foreignId('state_id')->constrained('states')->default(1);
            $table->integer('price')->length(5);
            $table->text('comment')->nullable();
            $table->integer('stars')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};
