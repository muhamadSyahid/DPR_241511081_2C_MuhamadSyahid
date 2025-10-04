<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.auth');
        $this->middleware('check.admin'); // Only Admin can access all komponen-gaji routes
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (session('user_role') !== 'Admin') {
            return redirect()->route('anggota.index')
                ->with('error', 'Access denied. Only administrators can access salary components.');
        }

        $search = $request->get('search');
        $userRole = session('user_role', 'Public');

        $query = KomponenGaji::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_komponen', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%")
                  ->orWhere('satuan', 'LIKE', "%{$search}%")
                  ->orWhere('nominal', 'LIKE', "%{$search}%");
            });
        }

        $komponenGaji = $query->paginate(10)->appends(['search' => $search]);

        return view('komponen-gaji.index', compact('komponenGaji', 'userRole', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions = KomponenGaji::getKategoriOptions();
        $jabatanOptions = KomponenGaji::getJabatanKomponenOptions();
        $satuanOptions = KomponenGaji::getSatuanOptions();

        return view('komponen-gaji.create', compact('kategoriOptions', 'jabatanOptions', 'satuanOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_komponen' => 'required|string|max:100',
            'kategori' => 'required|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota,Semua',
            'nominal' => 'required|numeric|min:0',
            'satuan' => 'required|in:Bulan,Hari,Periode',
            'deskripsi' => 'nullable|string|max:255'
        ]);

        KomponenGaji::create($validatedData);

        return redirect()->route('komponen-gaji.index')->with('success', 'Data komponen gaji berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KomponenGaji $komponenGaji)
    {
        if (session('user_role') !== 'Admin') {
            return redirect()->route('anggota.index')
                ->with('error', 'Access denied. Only administrators can access salary components.');
        }

        $userRole = session('user_role', 'Public');

        return view('komponen-gaji.show', compact('komponenGaji', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KomponenGaji $komponenGaji)
    {
        if (session('user_role') !== 'Admin') {
            return redirect()->route('anggota.index')
                ->with('error', 'Access denied. Only administrators can access salary components.');
        }

        $kategoriOptions = KomponenGaji::getKategoriOptions();
        $jabatanOptions = KomponenGaji::getJabatanKomponenOptions();
        $satuanOptions = KomponenGaji::getSatuanOptions();

        return view('komponen-gaji.edit', compact('komponenGaji', 'kategoriOptions', 'jabatanOptions', 'satuanOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KomponenGaji $komponenGaji)
    {
        if (session('user_role') !== 'Admin') {
            return redirect()->route('anggota.index')
                ->with('error', 'Access denied. Only administrators can access salary components.');
        }

        $validatedData = $request->validate([
            'nama_komponen' => 'required|string|max:100',
            'kategori' => 'required|in:Gaji Pokok,Tunjangan Melekat,Tunjangan Lain',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota,Semua',
            'nominal' => 'required|numeric|min:0',
            'satuan' => 'required|in:Bulan,Hari,Periode',
            'deskripsi' => 'nullable|string|max:255'
        ]);

        $komponenGaji->update($validatedData);

        return redirect()->route('komponen-gaji.index')->with('success', 'Data komponen gaji berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KomponenGaji $komponenGaji)
    {
        if (session('user_role') !== 'Admin') {
            return redirect()->route('anggota.index')
                ->with('error', 'Access denied. Only administrators can access salary components.');
        }

        // Check if this component is being used in penggajian
        $penggunaan = $komponenGaji->penggajian()->count();
        
        if ($penggunaan > 0) {
            return redirect()->route('komponen-gaji.index')
                ->with('error', "Komponen gaji '{$komponenGaji->nama_komponen}' tidak dapat dihapus karena sedang digunakan dalam {$penggunaan} data penggajian.");
        }

        $namaKomponen = $komponenGaji->nama_komponen;
        $komponenGaji->delete();

        return redirect()->route('komponen-gaji.index')->with('success', "Komponen gaji '{$namaKomponen}' berhasil dihapus.");
    }
}