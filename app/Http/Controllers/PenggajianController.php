<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Anggota;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenggajianController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.auth');
        $this->middleware('check.admin')->only(['create', 'store', 'edit', 'update', 'destroy', 'getAvailableComponents', 'destroyAll']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $userRole = session('user_role', 'Public');

        // Get payroll data with search functionality
        $payrollData = Penggajian::getPayrollData($search);
        
        // Convert to paginator manually for consistent interface
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $total = $payrollData->count();
        $items = $payrollData->forPage($currentPage, $perPage);
        
        $penggajian = new \Illuminate\Pagination\LengthAwarePaginator(
            $items->values(),
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
        
        $penggajian->appends(['search' => $search]);

        return view('penggajian.index', compact('penggajian', 'userRole', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedAnggotaId = $request->get('anggota_id');
        $anggotaList = Anggota::all();
        $selectedAnggota = null;
        $availableComponents = collect();

        if ($selectedAnggotaId) {
            $selectedAnggota = Anggota::find($selectedAnggotaId);
            if ($selectedAnggota) {
                $availableComponents = Penggajian::getAvailableComponents($selectedAnggotaId);
            }
        }

        return view('penggajian.create', compact(
            'anggotaList', 
            'selectedAnggota', 
            'availableComponents', 
            'selectedAnggotaId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_komponen_gaji' => 'required|exists:komponen_gaji,id_komponen_gaji',
        ]);

        // Custom validation: Check if component can be added
        if (!Penggajian::canAddComponent($validatedData['id_anggota'], $validatedData['id_komponen_gaji'])) {
            $anggota = Anggota::find($validatedData['id_anggota']);
            $komponenGaji = KomponenGaji::find($validatedData['id_komponen_gaji']);
            
            // Check specific reason for rejection
            if (Penggajian::where('id_anggota', $validatedData['id_anggota'])
                         ->where('id_komponen_gaji', $validatedData['id_komponen_gaji'])
                         ->exists()) {
                return back()->withErrors([
                    'id_komponen_gaji' => 'Komponen gaji ini sudah ditambahkan untuk anggota tersebut.'
                ])->withInput();
            }
            
            if ($komponenGaji && $komponenGaji->jabatan !== 'Semua' && $komponenGaji->jabatan !== $anggota->jabatan) {
                return back()->withErrors([
                    'id_komponen_gaji' => "Komponen gaji ini hanya untuk jabatan {$komponenGaji->jabatan}, sedangkan anggota memiliki jabatan {$anggota->jabatan}."
                ])->withInput();
            }

            return back()->withErrors([
                'id_komponen_gaji' => 'Komponen gaji tidak dapat ditambahkan untuk anggota ini.'
            ])->withInput();
        }

        Penggajian::create($validatedData);

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($idAnggota)
    {
        $anggota = Anggota::findOrFail($idAnggota);
        $salaryComponents = Penggajian::getAnggotaSalaryComponents($idAnggota);
        $takeHomePay = Penggajian::calculateTakeHomePay($idAnggota);
        $formattedTakeHomePay = Penggajian::getFormattedTakeHomePay($idAnggota);
        
        // Get breakdown by category
        $componentsByCategory = $salaryComponents->groupBy('komponenGaji.kategori');
        
        // Calculate conditional allowances
        $conditionalAllowances = [];
        if ($anggota->status_pernikahan === 'Kawin') {
            $spouseAllowance = KomponenGaji::where('nama_komponen', 'like', '%Istri/Suami%')
                                          ->where(function($query) use ($anggota) {
                                              $query->where('jabatan', $anggota->jabatan)
                                                    ->orWhere('jabatan', 'Semua');
                                          })
                                          ->first();
            if ($spouseAllowance) {
                $conditionalAllowances['spouse'] = [
                    'name' => $spouseAllowance->nama_komponen,
                    'amount' => $spouseAllowance->nominal,
                    'formatted' => 'Rp ' . number_format($spouseAllowance->nominal, 0, ',', '.')
                ];
            }
        }

        return view('penggajian.show', compact(
            'anggota', 
            'salaryComponents', 
            'takeHomePay', 
            'formattedTakeHomePay',
            'componentsByCategory',
            'conditionalAllowances'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idAnggota, $idKomponenGaji)
    {
        $penggajian = Penggajian::where('id_anggota', $idAnggota)
                                ->where('id_komponen_gaji', $idKomponenGaji)
                                ->firstOrFail();
        
        $anggota = $penggajian->anggota;
        $currentKomponenGaji = $penggajian->komponenGaji;
        
        // Get available components (including current one)
        $availableComponents = Penggajian::getAvailableComponents($idAnggota);
        
        // Add current component to available list
        $availableComponents = $availableComponents->push($currentKomponenGaji)->unique('id_komponen_gaji');

        return view('penggajian.edit', compact(
            'penggajian',
            'anggota', 
            'currentKomponenGaji',
            'availableComponents'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idAnggota, $idKomponenGaji)
    {
        $originalPenggajian = Penggajian::where('id_anggota', $idAnggota)
                                       ->where('id_komponen_gaji', $idKomponenGaji)
                                       ->firstOrFail();

        $validatedData = $request->validate([
            'id_komponen_gaji' => 'required|exists:komponen_gaji,id_komponen_gaji',
        ]);

        $newKomponenGajiId = $validatedData['id_komponen_gaji'];

        // If component is not changing, no validation needed
        if ($newKomponenGajiId == $idKomponenGaji) {
            return redirect()->route('penggajian.index')
                ->with('success', 'Data penggajian berhasil diperbarui.');
        }

        // Custom validation for new component
        if (!Penggajian::canAddComponent($idAnggota, $newKomponenGajiId)) {
            $anggota = Anggota::find($idAnggota);
            $komponenGaji = KomponenGaji::find($newKomponenGajiId);
            
            if (Penggajian::where('id_anggota', $idAnggota)
                         ->where('id_komponen_gaji', $newKomponenGajiId)
                         ->exists()) {
                return back()->withErrors([
                    'id_komponen_gaji' => 'Komponen gaji ini sudah ditambahkan untuk anggota tersebut.'
                ])->withInput();
            }
            
            if ($komponenGaji && $komponenGaji->jabatan !== 'Semua' && $komponenGaji->jabatan !== $anggota->jabatan) {
                return back()->withErrors([
                    'id_komponen_gaji' => "Komponen gaji ini hanya untuk jabatan {$komponenGaji->jabatan}, sedangkan anggota memiliki jabatan {$anggota->jabatan}."
                ])->withInput();
            }

            return back()->withErrors([
                'id_komponen_gaji' => 'Komponen gaji tidak dapat ditambahkan untuk anggota ini.'
            ])->withInput();
        }

        // Delete old record and create new one (since we're changing part of composite key)
        $originalPenggajian->delete();
        
        Penggajian::create([
            'id_anggota' => $idAnggota,
            'id_komponen_gaji' => $newKomponenGajiId
        ]);

        return redirect()->route('penggajian.index')
            ->with('success', 'Data penggajian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idAnggota, $idKomponenGaji)
    {
        $penggajian = Penggajian::where('id_anggota', $idAnggota)
                                ->where('id_komponen_gaji', $idKomponenGaji)
                                ->firstOrFail();

        $anggotaName = $penggajian->anggota->full_name;
        $komponenName = $penggajian->komponenGaji->nama_komponen;
        
        $penggajian->delete();

        return redirect()->route('penggajian.index')
            ->with('success', "Komponen gaji '{$komponenName}' berhasil dihapus dari {$anggotaName}.");
    }

    /**
     * API endpoint to get available components for anggota
     */
    public function getAvailableComponents($idAnggota)
    {
        $availableComponents = Penggajian::getAvailableComponents($idAnggota);
        return response()->json($availableComponents);
    }

    /**
     * Remove all salary components for an anggota
     */
    public function destroyAll($idAnggota)
    {
        $anggota = Anggota::findOrFail($idAnggota);
        $componentsCount = Penggajian::where('id_anggota', $idAnggota)->count();
        
        Penggajian::where('id_anggota', $idAnggota)->delete();

        return redirect()->route('penggajian.index')
            ->with('success', "Semua komponen gaji ({$componentsCount} komponen) berhasil dihapus dari {$anggota->full_name}.");
    }
}