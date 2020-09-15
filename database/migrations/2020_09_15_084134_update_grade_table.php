<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('user_id_from');
            $table->dropColumn('user_id_to');

            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('subject_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->bigInteger('user_id_from')->nullable();
            $table->bigInteger('user_id_to');

            $table->dropColumn('user_id');
            $table->dropColumn('subject_id');
        });
    }
}
