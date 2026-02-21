<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SevenReport extends Model
{
    protected $table = 'seven_reports';

    protected $fillable = [
        'seven_s_id',
        'title',
        'content',
        'file_path',
    ];
}
