<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClassModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->bigInteger('school_id');
            $table->string('symbol')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('class');
            $table->dropColumn('class_symbol');
            $table->dropColumn('school_id');

            $table->bigInteger('school_class_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_classes');

        Schema::table('users', function (Blueprint $table) {
            $table->integer('class')->nullable();
            $table->string('class_symbol')->nullable()->comment('Буква параллели');
            $table->bigInteger('school_id')->nullable();

            $table->dropColumn('school_class_id');
        });
    }
}
