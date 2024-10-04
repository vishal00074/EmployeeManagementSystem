<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignLeave extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'leave_id', 'days', 'used_leave', 'start_date', 'end_date', 'hours'];
}
