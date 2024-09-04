<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePrioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('timeline');
            $table->string('green')->nullable();
            $table->string('yellow')->nullable();
            $table->string('red')->nullable();
            $table->text('status');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('weekly_maintenance_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_priorities');
    }
}