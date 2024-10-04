<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->string('project_id')->nullable();
            $table->decimal('billing_per_hour_price', 10, 2)->nullable();
            $table->decimal('fixed_total_amount', 10, 2)->nullable();

            // Define foreign key constraint for agency_id
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['agency_id']); // Drop foreign key constraint
            $table->dropColumn('agency_id');
            $table->dropColumn('project_id');
            $table->dropColumn('billing_per_hour_price');
            $table->dropColumn('fixed_total_amount');
        });
    }
}
