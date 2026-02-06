<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_name',
        'description',
        'image',
        'order',
    ];
}
