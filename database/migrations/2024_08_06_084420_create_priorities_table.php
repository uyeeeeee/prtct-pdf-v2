<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id(); 
            $table->string('description');
            $table->date('timeline');
            $table->string('green')->nullable();
            $table->string('yellow')->nullable();
            $table->string('red')->nullable();
            $table->text('status');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->foreignId('weekly_maintenance_id')->nullable()->constrained()->onDelete('set null');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('priorities');
    }
}