<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllStatesJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allStatesJobs', function (Blueprint $table) {
            $table->string('state_name');
            $table->string('state_code');
            $table->string('job_name');
            $table->string('job_code');
            $table->integer('salary')->default(0);
            $table->primary(['state_code', 'job_code']);
            $table->unique(['state_name', 'job_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allStatesJobs');
    }
}
