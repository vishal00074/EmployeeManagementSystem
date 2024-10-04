<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'employee_id',
        'subject',
        'description',
        'status',
    ];

    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Define the relationship with SupportMessage model
    public function messages()
    {
        return $this->hasMany(SupportMessage::class);
    }
}
