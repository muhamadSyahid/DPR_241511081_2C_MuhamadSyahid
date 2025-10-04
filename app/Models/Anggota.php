<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'gelar_depan',
        'gelar_belakang',
        'jabatan',
        'status_pernikahan'
    ];

    protected $casts = [
        'jabatan' => 'string',
        'status_pernikahan' => 'string',
    ];

    public function getFullNameAttribute()
    {
        $fullName = '';
        
        if ($this->gelar_depan) {
            $fullName .= $this->gelar_depan . ' ';
        }
        
        $fullName .= $this->nama_depan . ' ' . $this->nama_belakang;
        
        if ($this->gelar_belakang) {
            $fullName .= ', ' . $this->gelar_belakang;
        }
        
        return $fullName;
    }

    public static function getJabatanOptions()
    {
        return [
            'Ketua' => 'Ketua',
            'Wakil Ketua' => 'Wakil Ketua',
            'Anggota' => 'Anggota'
        ];
    }

    public static function getStatusPernikahanOptions()
    {
        return [
            'Kawin' => 'Kawin',
            'Belum Kawin' => 'Belum Kawin',
            'Cerai Hidup' => 'Cerai Hidup',
            'Cerai Mati' => 'Cerai Mati'
        ];
    }
}