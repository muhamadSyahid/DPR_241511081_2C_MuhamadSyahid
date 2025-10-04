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


}
