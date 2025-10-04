<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'username',
        'password',
        'email',
        'nama_depan',
        'nama_belakang',
        'role',
    ];

    protected $casts = [
        'role' => 'string',
    ];

    // Role constants
    const ROLE_ADMIN = 'Admin';
    const ROLE_PUBLIC = 'Public';

    // Static method to get role options
    public static function getRoleOptions()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_PUBLIC => 'Public'
        ];
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Check if user is public
    public function isPublic()
    {
        return $this->role === self::ROLE_PUBLIC;
    }

    // Get full name
    public function getFullNameAttribute()
    {
        return $this->nama_depan . ' ' . $this->nama_belakang;
    }
}
