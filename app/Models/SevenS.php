<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SevenS extends Model
{
    protected $table = 'seven_summaries';

    protected $fillable = [
        'progress_percent',
        'before_image',
        'after_image',
        'seiri',
        'seiton',
        'seiso',
        'seiketsu',
        'shitsuke',
        'safety_spirit',
        'report',
        'report_file',
        'published',
        'seiri_text',
        'seiton_text',
        'seiso_text',
        'seiketsu_text',
        'shitsuke_text',
        'safety_text',
        'spirit_text',
    ];
}
