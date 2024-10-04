<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{
    use HasFactory;

   protected $fillable = [
    'company_name',
    'job_title',  
    'job_position',
    'job_type',
    'job_location', 
    'qualification',
    'experience',
    'job_skill',
    'job_budget',
    'job_description',
    'email',
    'contact_detail',
    'shift',
    'timing',
    'interview_mode',
    'key_responsibilities',
    'timing',
    'shift'
];


    

}
