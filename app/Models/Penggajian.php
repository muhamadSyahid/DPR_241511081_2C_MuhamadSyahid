<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian';
    
    // Composite primary key
    protected $primaryKey = ['id_komponen_gaji', 'id_anggota'];
    public $incrementing = false;
    protected $keyType = 'array';
    
    protected $fillable = [
        'id_komponen_gaji',
        'id_anggota'
    ];

    /**
     * Relationship with KomponenGaji
     */
    public function komponenGaji()
    {
        return $this->belongsTo(KomponenGaji::class, 'id_komponen_gaji', 'id_komponen_gaji');
    }

    /**
     * Relationship with Anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Get all salary components for a specific anggota
     */
    public static function getAnggotaSalaryComponents($idAnggota)
    {
        return self::with(['komponenGaji', 'anggota'])
                  ->where('id_anggota', $idAnggota)
                  ->get();
    }

    /**
     * Calculate Take Home Pay for a specific anggota
     */
    public static function calculateTakeHomePay($idAnggota)
    {
        $anggota = Anggota::find($idAnggota);
        if (!$anggota) {
            return 0;
        }

        // Get all salary components for this anggota
        $components = self::with('komponenGaji')
                         ->where('id_anggota', $idAnggota)
                         ->get();

        $totalPay = 0;

        // Group components by satuan for proper calculation
        $componentsBySatuan = $components->groupBy('komponenGaji.satuan');

        foreach ($componentsBySatuan as $satuan => $satuanComponents) {
            $satuanTotal = 0;
            
            foreach ($satuanComponents as $component) {
                $nominal = $component->komponenGaji->nominal;
                
                // Add component based on category
                if (in_array($component->komponenGaji->kategori, ['Gaji Pokok', 'Tunjangan Melekat', 'Tunjangan Lain'])) {
                    $satuanTotal += $nominal;
                }
            }
            
            // Convert all to monthly basis for consistency
            if ($satuan === 'Hari') {
                $satuanTotal *= 30; // Convert daily to monthly
            } elseif ($satuan === 'Periode') {
                // Assume period is monthly for now
                $satuanTotal *= 1;
            }
            
            $totalPay += $satuanTotal;
        }


        return $totalPay;
    }

    /**
     * Get formatted take home pay
     */
    public static function getFormattedTakeHomePay($idAnggota)
    {
        $amount = self::calculateTakeHomePay($idAnggota);
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Check if a salary component can be added to an anggota
     */
    public static function canAddComponent($idAnggota, $idKomponenGaji)
    {
        $anggota = Anggota::find($idAnggota);
        $komponenGaji = KomponenGaji::find($idKomponenGaji);

        if (!$anggota || !$komponenGaji) {
            return false;
        }

        // Check if component already exists
        if (self::where('id_anggota', $idAnggota)
               ->where('id_komponen_gaji', $idKomponenGaji)
               ->exists()) {
            return false;
        }

        // Check jabatan compatibility
        if ($komponenGaji->jabatan !== 'Semua' && $komponenGaji->jabatan !== $anggota->jabatan) {
            return false;
        }

        return true;
    }

    /**
     * Get available components for an anggota based on their jabatan
     */
    public static function getAvailableComponents($idAnggota)
    {
        $anggota = Anggota::find($idAnggota);
        if (!$anggota) {
            return collect();
        }

        // Get components that match anggota's jabatan or are for 'Semua'
        $availableComponents = KomponenGaji::where(function($query) use ($anggota) {
            $query->where('jabatan', $anggota->jabatan)
                  ->orWhere('jabatan', 'Semua');
        })->get();

        // Exclude already assigned components
        $assignedComponentIds = self::where('id_anggota', $idAnggota)
                                   ->pluck('id_komponen_gaji')
                                   ->toArray();

        return $availableComponents->whereNotIn('id_komponen_gaji', $assignedComponentIds);
    }

    /**
     * Get complete payroll data with anggota details and take home pay
     */
    public static function getPayrollData($search = null)
    {
        $query = DB::table('anggota')
            ->select([
                'anggota.id_anggota',
                'anggota.gelar_depan',
                'anggota.nama_depan',
                'anggota.nama_belakang',
                'anggota.gelar_belakang',
                'anggota.jabatan',
                'anggota.status_pernikahan'
            ])
            ->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                        ->from('penggajian')
                        ->whereColumn('penggajian.id_anggota', 'anggota.id_anggota');
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('anggota.nama_depan', 'LIKE', "%{$search}%")
                  ->orWhere('anggota.nama_belakang', 'LIKE', "%{$search}%")
                  ->orWhere('anggota.jabatan', 'LIKE', "%{$search}%")
                  ->orWhere('anggota.id_anggota', 'LIKE', "%{$search}%");
            });
        }

        $results = $query->get();

        // Add calculated take home pay and full name to each record
        foreach ($results as $result) {
            $result->take_home_pay = self::calculateTakeHomePay($result->id_anggota);
            $result->formatted_take_home_pay = self::getFormattedTakeHomePay($result->id_anggota);
            
            // Concatenate full name
            $nameParts = array_filter([
                $result->gelar_depan,
                $result->nama_depan,
                $result->nama_belakang,
                $result->gelar_belakang
            ]);
            $result->full_name = implode(' ', $nameParts);
        }

        // Additional search by take home pay if search is numeric
        if ($search && is_numeric(str_replace(['.', ',', 'Rp', ' '], '', $search))) {
            $searchAmount = (float) str_replace(['.', ',', 'Rp', ' '], '', $search);
            $results = $results->filter(function ($item) use ($searchAmount) {
                return abs($item->take_home_pay - $searchAmount) < 1000; // Allow some variance
            });
        }

        return $results;
    }
}