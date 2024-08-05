<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->date('date');
        $table->enum('status', ['present', 'late', 'absent']);
        $table->time('check_in')->nullable();
       
       
        $table->timestamps();
    });
}
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}