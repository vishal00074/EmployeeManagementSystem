<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidderFeedback extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'remark', 'status', 'type'];
}
