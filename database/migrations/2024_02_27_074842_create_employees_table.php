<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sex');
            $table->datetime('dob');
            $table->datetime('joining_date');
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->text('current_address')->nullable();
            $table->text('permanant_address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('adhar_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('working_saturday')->nullable();
            $table->string('shift')->nullable();
            $table->integer('status');
            $table->string('reporting_to');
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
        Schema::dropIfExists('employees');
    }
}
