<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable=['url','agency_id', 'upwork_id', 'client_name', 'remarks', 'status', 'bid_url', 'employee_id'];
}
