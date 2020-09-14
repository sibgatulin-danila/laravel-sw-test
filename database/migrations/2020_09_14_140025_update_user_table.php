<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('refresh_token')->nullable();
            
            // students
            $table->bigInteger('school_id')->nullable();
            $table->integer('class')->nullable();
            $table->string('class_symbol')->nullable()->comment('Буква параллели');
            $table->timestamp('enrollment_date')->nullable()->comment('Дата зачисления ученика в школе');

            // employee
            $table->timestamp('dismissal_date')->nullable()->comment('дата увольнения сотрудника школы');
            $table->timestamp('hire_date')->nullable()->comment('дата принятия на работу сотрудника школы');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('refresh_token');
            
            // students
            $table->dropColumn('school_id');
            $table->dropColumn('class');
            $table->dropColumn('class_symbol');
            $table->dropColumn('enrollment_date');

            // employee
            $table->dropColumn('dismissal_date');
            $table->dropColumn('hire_date');
        });
    }
}
