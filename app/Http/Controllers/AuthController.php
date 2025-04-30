<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        $data = ["title" => "Halaman Login", "header_title" => "Halaman Login"];
        return view('pages.login.index', $data);
    }

    public function login(Request $request)
    {
        // Validate Inputs
        $validatedData = static::validasiInput($request);

        try {
            // Cek user dan password
            $user = User::where('username', $validatedData['username'])->first();


            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                Session::flash('warning', "Username atau password tidak ditemukan");
                return redirect()->route('login.index')->withInput();
            }

            // Auth::login($user);
            // $request->session()->regenerate();

            // dd(Auth::check());
            if (Auth::attempt($validatedData)) {
                $request->session()->regenerate();
                switch ($user->user_role) {
                    case 'admin':
                        return redirect()->route('admin.shippings.index');
                    case 'korlap':
                        return redirect()->route('couriers.index');
                    case 'kurir':
                        return redirect()->route('locations.index');
                    default:
                        dd($user);
                        Auth::logout();
                        Session::flash('warning', 'Peran pengguna tidak valid.');
                        return redirect()->route('login.index');
                }
            }
        } catch (\Throwable $th) {
            Session::flash('error', 'Terjadi kesalahan saat proses login.');
            return redirect()->route('login.index')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')->with('logout_success', 'Berhasil logout.');
    }

    static  private function validasiInput(Request $request, $courier = [])
    {
        $messages = [
            'username.required'        => 'Username wajib diisi.',
            'password.required'         => 'Password wajib diisi.',

        ];

        $validationFormat = [
            'username'        => 'required',
            'password'         => 'required',
        ];


        $validatedData = $request->validate($validationFormat, $messages);
        // dd($validatedData);

        return $validatedData;
    }
}
