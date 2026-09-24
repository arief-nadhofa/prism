<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $table = 'line';

    public $timestamps = false;

    protected $fillable = [
        'line',
        'created_at',
        'created_by',
    ];
}
