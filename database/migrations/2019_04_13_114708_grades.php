<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Grades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function($table) {
            $table->increments('id')->onDelete('cascade');
            $table->string('name');
            $table->integer('professor_id')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
         Schema::table('grades', function($table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('professor_id')->references('id')->on('professors');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
