<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.auth');
        $this->middleware('check.admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
            'satuan' => 'required|in:Bulan,Hari,Periode'
        ]);

        KomponenGaji::create($validatedData);

        return redirect()->route('komponen-gaji.index')->with('success', 'Data komponen gaji berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KomponenGaji $komponenGaji)
    {
        $userRole = session('user_role', 'Public');

        return view('komponen-gaji.show', compact('komponenGaji', 'userRole'));
    }
}