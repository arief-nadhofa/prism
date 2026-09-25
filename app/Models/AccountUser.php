<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountUser extends Model
{
    use HasFactory;

    // Koneksi database server berbeda
    protected $connection = 'mysql_account';
    protected $table = 'user';

    public $timestamps = false;

    protected $fillable = [
        'fullname',
        'npk',
        'department_id',
        'email',
        'created_at',
        'updated_at'
    ];
}
