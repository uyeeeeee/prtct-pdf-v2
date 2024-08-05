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
        $table->unsignedBigInteger('employee_id');
        $table->date('date');
        $table->dateTime('check_in');
        $table->dateTime('check_out');  
        $table->enum('status', ['present', 'late', 'absent']);
        $table->timestamps();
        
        $table->foreign('employee_id')->references('id')->on('employees');
    });
}
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}