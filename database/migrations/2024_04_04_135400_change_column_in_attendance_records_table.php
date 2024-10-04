<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInAttendanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            \DB::statement('ALTER TABLE `attendance_records` MODIFY `remark` VARCHAR(195) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL');
            \DB::statement('ALTER TABLE `attendance_records` MODIFY `status` VARCHAR(195) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL');
            \DB::statement('ALTER TABLE `attendance_records` CHANGE `time_in` `time_in` TIME NULL DEFAULT NULL');
            \DB::statement('ALTER TABLE `attendance_records` CHANGE `time_out` `time_out` TIME NULL DEFAULT NULL');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            \DB::statement('ALTER TABLE `attendance_records` MODIFY `remark` VARCHAR(195) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL');
            \DB::statement('ALTER TABLE `attendance_records` MODIFY `status` VARCHAR(195) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL');
            \DB::statement('ALTER TABLE `attendance_records` CHANGE `time_in` `time_in` TIME NULL DEFAULT NOT NULL');
            \DB::statement('ALTER TABLE `attendance_records` CHANGE `time_out` `time_out` TIME NULL DEFAULT NOT NULL');
        });
    }
}
