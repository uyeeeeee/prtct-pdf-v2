<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->integer('grace_period_minutes')->default(15);
        });
    }
    
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['work_start_time', 'work_end_time', 'grace_period_minutes']);
        });
    }
};
