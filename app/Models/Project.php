<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'client_name',
        'upwork_id',
        'project_type',
        'department',
        'emp_name',
        'project_description',
        'assign_by',
        'assign_date',
        'billing_hours',
        'project_status',
         'star_rating',
         'feedback_comment',

        'agency_id',
        'project_id',
        'billing_per_hour_price',
        'fixed_total_amount',


    ];

    // Define the relationships

    public function department()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_name');
    }

  
    public function upwork()
    {
        return $this->belongsTo(Upwork::class, 'upwork_id');
    }

}
