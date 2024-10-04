<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
        {
            Schema::create('leaves', function (Blueprint $table) {
                $table->id();
                $table->foreignId('emp_id')->constrained('employees')->onDelete('cascade');
                $table->string('leave_type');
                $table->date('start_date');
                $table->date('end_date');
                $table->text('reason');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->string('approved_by')->nullable();
                $table->foreign('approved_by')->references('name')->on('employees')->onDelete('set null');
                $table->timestamp('approved_at')->nullable();
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
        Schema::dropIfExists('leaves');
    }
}
