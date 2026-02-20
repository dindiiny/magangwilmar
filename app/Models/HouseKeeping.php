<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseKeeping extends Model
{
    protected $fillable = [
        'date',
        'day_name',
        'activities',
        'areas',
        'video_path',
        'published',
    ];

    protected $table = 'house_keeping_logs';
}
