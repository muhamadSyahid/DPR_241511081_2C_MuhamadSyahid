<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
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

        $query = Anggota::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_depan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_belakang', 'LIKE', "%{$search}%")
                  ->orWhere('gelar_depan', 'LIKE', "%{$search}%")
                  ->orWhere('gelar_belakang', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%")
                  ->orWhere('status_pernikahan', 'LIKE', "%{$search}%");
            });
        }

        $anggota = $query->paginate(10)->appends(['search' => $search]);

        return view('anggota.index', compact('anggota', 'userRole', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatanOptions = Anggota::getJabatanOptions();
        $statusPernikahanOptions = Anggota::getStatusPernikahanOptions();

        return view('anggota.create', compact('jabatanOptions', 'statusPernikahanOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'status_pernikahan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
        ]);

        Anggota::create($validatedData);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        $userRole = session('user_role', 'Public');

        return view('anggota.show', compact('anggota', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota)
    {
        $jabatanOptions = Anggota::getJabatanOptions();
        $statusPernikahanOptions = Anggota::getStatusPernikahanOptions();

        return view('anggota.edit', compact('anggota', 'jabatanOptions', 'statusPernikahanOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validatedData = $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Anggota',
            'status_pernikahan' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati'
        ]);

        $anggota->update($validatedData);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        // Check if this anggota has penggajian records
        $penggajianCount = $anggota->penggajian()->count();
        
        if ($penggajianCount > 0) {
            return redirect()->route('anggota.index')
                ->with('error', "Anggota '{$anggota->full_name}' tidak dapat dihapus karena memiliki {$penggajianCount} data penggajian.");
        }

        $namaAnggota = $anggota->full_name;
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', "Data anggota '{$namaAnggota}' berhasil dihapus.");
    }
}
