<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'is_completed',
        'category_id',
        'priority_id'
    ];
}
