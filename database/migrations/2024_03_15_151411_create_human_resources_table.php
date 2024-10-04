<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_resources', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');

            $table->string('job_title');
            $table->string('job_position');
            $table->string('job_type');
            $table->string('job_location');
            $table->string('qualification');
            $table->string('experience');
            $table->string('job_skill');
            $table->string('job_budget')->nullable();
            $table->text('job_description')->nullable();
            $table->string('interview_mode')->nullable();
            $table->text('key_responsibilities')->nullable();

            $table->string('email');
            $table->string('contact_detail');
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
        Schema::dropIfExists('human_resources');
    }
}
