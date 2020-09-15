<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('school_class_id');
            $table->timestamp('datetime')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('timetables');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');

        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('school_class_id');
            $table->timestamp('datetime')->nullable();
            $table->string('subject')->nullable();
            $table->timestamps();
        });
    }
}
