<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('client_name');
            $table->string('upwork_id')->nullable();
            $table->foreign('upwork_id')->references('id')->on('upworks')->onDelete('cascade');
            $table->string('project_type');
            $table->string('department'); 
            $table->foreign('department')->references('id')->on('departments')->onDelete('cascade');
            $table->string('emp_name');
            $table->foreign('emp_name')->references('id')->on('employees')->onDelete('cascade');
            $table->text('project_description');
            $table->string('assign_by');
            $table->foreign('assign_by')->references('id')->on('departments')->onDelete('cascade');
            $table->timestamp('assign_date');
            $table->integer('billing_hours')->nullable();
            $table->enum('project_status', ['Completed', 'In-Processing', 'Pending'])->default('Pending');
            $table->timestamps();
        });
    }
       


  // Define the relationships

    public function department()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_name');
    }

    public function assigner()
    {
        return $this->belongsTo(Department::class, 'assign_by');
    }

    public function upwork()
    {
        return $this->belongsTo(Upwork::class, 'upwork_id');
    }




       
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
