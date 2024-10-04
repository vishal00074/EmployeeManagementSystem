<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMorecolumnToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
          $table->string('photo')->nullable();
          $table->string('gross_salary')->nullable();
          $table->string('esi_number')->nullable();
          $table->string('pf_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIfExists('photo')->nullable();
            $table->dropIfExists('gross_salary')->nullable();
            $table->dropIfExists('esi_number')->nullable();
            $table->dropIfExists('pf_number')->nullable();
        });
    }
}
