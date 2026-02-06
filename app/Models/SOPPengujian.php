<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOPPengujian extends Model
{
    use HasFactory;

    protected $fillable = ['parameter', 'metode'];
}
