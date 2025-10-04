<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (session('is_authenticated')) {
            return redirect()->route('anggota.index');
        }

        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $request->email;
        $password = $request->password;

        $pengguna = Pengguna::where('email', $email)->first();

        if ($pengguna && Hash::check($password, $pengguna->password)) {
            $request->session()->regenerate();
            $request->session()->put('user_id', $pengguna->id_pengguna);
            $request->session()->put('user_email', $pengguna->email);
            $request->session()->put('user_name', $pengguna->nama_depan);
            $request->session()->put('user_role', $pengguna->role);
            $request->session()->put('is_authenticated', true);

            return redirect()->route('anggota.index')->with('success', 'Login berhasil! Selamat datang, ' . $pengguna->nama_depan);
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Akun yang diberikan tidak sesuai.',
            ])->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Anda telah melakukan logout.');
    }

    public function berhasil()
    {
        if (! session('is_authenticated')) {
            return redirect('/login')->with('error', 'Login untuk memasuki halaman ini.');
        }

        $userName = session('user_name', 'User');

        return view('berhasil', ['nama' => $userName]);
    }

    public static function isAuthenticated()
    {
        return session('is_authenticated', false);
    }

    public static function getSessionUser()
    {
        if (! self::isAuthenticated()) {
            return null;
        }

        return [
            'id' => session('user_id'),
            'email' => session('user_email'),
            'name' => session('user_name'),
        ];
    }
}
