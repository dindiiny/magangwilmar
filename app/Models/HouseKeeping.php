<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseKeeping extends Model
{
    protected $fillable = [
        'weekly_schedule',
        'areas',
        'video_path',
        'published',
    ];
}

