<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndRemoveColumnToLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->integer('day_type')->default(0);
            $table->dropColumn('end_date')->default(0);
            \DB::statement('ALTER TABLE `leaves` CHANGE `start_date` `date` DATE NOT NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('day_type')->default(0);
            $table->datetime('end_date')->default(0);
            \DB::statement('ALTER TABLE `leaves` CHANGE `date` `start_date` DATETIME NOT NULL');
        });
    }
}
