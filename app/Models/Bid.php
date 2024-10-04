<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'agency_id', 'upwork_id', 'employee_id', 'connects', 'date', 'status'];
}
