<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'department',
        'interviewer_name',
        'interview_date_time',
        'interview_feedback',
        'interview_status',
        'follow_up_action',
        'next_interview_date',
        'additional_notes',
        'interview_type',
    ];

    // Define relationships if needed
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Add any other methods or relationships as needed
}
