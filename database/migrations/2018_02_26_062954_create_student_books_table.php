<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('refno');
            $table->string('idno');
            $table->string('book_title');
            $table->string('schoolyear');
            $table->integer('status');
            //0 = no action, 1 = paid, 2 = claimed
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
        Schema::dropIfExists('student_books');
    }
}
