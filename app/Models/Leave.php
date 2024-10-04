<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'leave_type',
        'date',
        'reason',
        'status',
        'assign_id',
        'approved_by',
        'approved_at',
        'remark',
        'day_type',
    ];

    // Define the relationships

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function leavetype()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type');
    }

  
}
