<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesStatusesOverridesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades_statuses_overrides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->string('schoolyear');
            $table->integer('quarter');
            $table->string('subjecttype');
            $table->integer('status');
            $table->string('user');
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
        Schema::dropIfExists('grades_statuses_overrides');
    }
}
