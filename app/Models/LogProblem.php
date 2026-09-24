<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogProblem extends Model
{
    use HasFactory;

    protected $table = 'log_problem';

    public $timestamps = false;

    protected $fillable = [
        'npk',
        'line',
        'category',
        'problem',
        'attachment_1',
        'attachment_2',
        'attachment_3',
        'countermeasure',
        'status',
        'start_problem',
        'finish_problem',
        'duration',
        'created_at',
        'created_by',
    ];

    /**
     * Relasi ke model Category (merujuk ke kolom category -> id)
     */
    public function categoryDetail(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    /**
     * Relasi ke model Line (merujuk ke kolom line -> id)
     */
    public function lineDetail(): BelongsTo
    {
        return $this->belongsTo(Line::class, 'line', 'id');
    }
}
