<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('department')->nullable();
            $table->text('interviewer_name')->nullable();
            $table->dateTime('interview_date_time');
            $table->text('interview_feedback')->nullable();
            $table->enum('interview_status', ['scheduled', 'attend', 'not_attend'])->default('scheduled');
            $table->text('follow_up_action')->nullable();
            $table->date('next_interview_date')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('interview_type', ['online', 'offline'])->default('offline');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
