<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;

    // Koneksi database server berbeda
    protected $connection = 'mysql_account';
    protected $table = 'account';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'role',
        'created_at',
        'updated_at',
        'token_version',
        'company',
        'username_vpn'
    ];

    public function accountUser(): BelongsTo
    {
        return $this->belongsTo(AccountUser::class, 'id', 'user_id');
    }
}
