<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    use HasFactory;

    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id_komponen_gaji';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama_komponen',
        'kategori',
        'jabatan',
        'nominal',
        'satuan'
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'kategori' => 'string',
        'jabatan' => 'string',
        'satuan' => 'string',
    ];

    public static function getKategoriOptions()
    {
        return [
            'Gaji Pokok' => 'Gaji Pokok',
            'Tunjangan Melekat' => 'Tunjangan Melekat',
            'Tunjangan Lain' => 'Tunjangan Lain'
        ];
    }

    public static function getJabatanKomponenOptions()
    {
        return [
            'Ketua' => 'Ketua',
            'Wakil Ketua' => 'Wakil Ketua',
            'Anggota' => 'Anggota',
            'Semua' => 'Semua'
        ];
    }

    public static function getSatuanOptions()
    {
        return [
            'Bulan' => 'Bulan',
            'Hari' => 'Hari',
            'Periode' => 'Periode'
        ];
    }

    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 2, ',', '.');
    }

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'id_komponen_gaji', 'id_komponen_gaji');
    }
}