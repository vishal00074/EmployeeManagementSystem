<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'resume',
        'cover_letter',
        'resume_path',
        'cover_letter_path',
        'job_applied_for',
        'status',
        'experience',
        'position',
        'shift',
        'past_salary',
        'expected_salary',
        'offered_salary',
        'reason_for_change',
        'lwd_np',
        'remarks'
    ];

}
