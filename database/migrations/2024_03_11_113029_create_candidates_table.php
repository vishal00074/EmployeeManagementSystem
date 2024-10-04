<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('resume')->nullable(); // File path for resume
            $table->string('cover_letter')->nullable(); // File path for cover letter
            $table->string('resume_path')->nullable(); // File path for resume
            $table->string('cover_letter_path')->nullable(); // File path for cover letter$table->string('resume')->nullable(); // File path for resume
            $table->string('job_applied_for')->nullable(); 
            $table->enum('status', ['new', 'contacted', 'interviewed', 'hired', 'rejected'])->default('new');
            $table->text('experience')->nullable(); // Candidate's past experience
            $table->text('position')->nullable(); // Desired position
            $table->string('shift')->nullable(); // Shift preference
            $table->decimal('past_salary', 10, 2)->nullable(); // Candidate's past salary
            $table->decimal('expected_salary', 10, 2)->nullable(); // Candidate's salary expectation
            $table->decimal('offered_salary', 10, 2)->nullable(); // Salary offered by HR
            $table->text('reason_for_change')->nullable(); // Reason for changing job
            $table->date('joining_date')->nullable(); // Date of joining
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
        Schema::dropIfExists('candidates');
    }
}
