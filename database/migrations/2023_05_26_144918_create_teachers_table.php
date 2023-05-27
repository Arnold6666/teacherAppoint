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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image', 255)->nullable();
            $table->text('intro')->nullable();
            $table->string('country');
            $table->string('email');
            $table->integer('monday')->length(1)->default(0);
            $table->integer('tuesday')->length(1)->default(0);
            $table->integer('wednesday')->length(1)->default(0);
            $table->integer('thursday')->length(1)->default(0);
            $table->integer('friday')->length(1)->default(0);
            $table->integer('saturday')->length(1)->default(0);
            $table->integer('sunday')->length(1)->default(0);
            $table->integer('price')->length(5);
            $table->integer('stars')->length(1)->nullable();
            $table->integer('comments')->length(5)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
