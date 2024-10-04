<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','employee_id', 'title', 'description', 'billing_hours', 'non_billing_hours', 'date','documents_name','documents_path'];

     public function project()
      {
        return $this->belongsTo(Project::class, 'project_id');
      }

      public function employeeName(){

        return $this->belongsTo(Employee::class,'employee_id');
     
      }




}
