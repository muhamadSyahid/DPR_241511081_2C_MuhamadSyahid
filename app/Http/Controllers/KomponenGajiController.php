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

}