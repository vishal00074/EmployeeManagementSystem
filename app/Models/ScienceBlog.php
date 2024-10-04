<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScienceBlog extends Model
{
    use HasFactory;

    protected $fillable =['title', 'image', 'para1', 'para2', 'para3'];
}
