<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'username',
        'email',
        'password',
        'deskripsi',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    // ✅ Relasi ke Mentor
    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'id_user', 'id_user');
    }
}