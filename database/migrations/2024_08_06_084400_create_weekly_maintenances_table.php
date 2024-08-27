<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyMaintenancesTable extends Migration
{
    public function up()
    {
        Schema::create('weekly_maintenances', function (Blueprint $table) {
            $table->id();  // Automatically creates an unsignedBigInteger
            $table->integer('week_number');
            $table->date('date_from');
            $table->date('date_to');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_maintenances');
    }
}