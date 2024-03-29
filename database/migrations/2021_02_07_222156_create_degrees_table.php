<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('degree_name');
            $table->string('degree_description')->nullable();
            $table->string('degree_code');
            $table->integer('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('graduation_rate')->nullable();
            $table->integer('job_demand');
            $table->string('degree_type');
            $table->string('program_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degrees');
    }
}
