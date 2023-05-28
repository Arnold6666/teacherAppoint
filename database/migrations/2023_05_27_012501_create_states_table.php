<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('state');
        });
        
        DB::table('states')->insert([
            ['state' => '已預約未付款'],
            ['state' => '已付款未上課'],
            ['state' => '已上課未評論'],
            ['state' => '已上課已評論'],
            ['state' => '逾期未上'],
            ['state' => '取消課程'],
            ['state' => '退款中'],
            ['state' => '退款完成'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
