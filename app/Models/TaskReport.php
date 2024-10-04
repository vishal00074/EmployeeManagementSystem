<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskReport extends Model
{
    use HasFactory;

    protected $fillable =['task_id', 'employee_id', 'subject', 'task_billing_hours', 'task_non_billing_hours', 'message', 'documents'];
}
