<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'employee_id','name', 'sex', 'dob', 'joining_date', 'department', 'designation', 
        'current_address', 'permanant_address', 'mobile_number', 'personal_email',
        'adhar_number', 'pan_number', 'working_saturday', 'shift', 'status', 'reporting_to',
        'official_email', 'password', 'photo', 'gross_salary', 'esi_number', 'pf_number', 'fcm_token',
    ];

    protected $hidden = [
        'password',
    ];
}
