<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Fleet;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    static private $imgFolder = 'users/images';

    public function index(Request $request)
    {
        $data = ["title" => "Kelola Pengguna", "header_title" => "Kelola Akun Pengguna"];
        $keyword = $request->input('keyword');

        $query = User::select("user_ID", "user_name", "username", "user_role");

        if (!empty($keyword)) {
            $query->where('user_name', 'like', "%{$keyword}%")->orWhere('username', 'like', "%{$keyword}%");
            $data['keyword'] = $keyword;
        }

        $data['users'] = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only('keyword'));

        return view('pages.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = ["title" => "Tambah Akun Pengguna", "header_title" => "Tambah Data Akun Pengguna", "mode_insert" => "not_courier"];
        if (!empty($request->get("mode_insert"))) {
            $data["mode_insert"] = $request->get("mode_insert");
        }

        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereNotIn('courier_ID', User::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();

        // dd($data["couriers"][0]->fleet->fleet_nopol);
        return view('pages.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Inputs
        // dd($request);
        $validatedData = static::validasiInput($request);


        try {
            // Input File
            if ($request->input("mode_insert") == "courier") {
                $courier = Courier::where("courier_ID", $validatedData['courier_ID'])->first();
                $validatedData['username'] = $validatedData['username_courier'];
                $validatedData['user_name'] = $courier->courier_name;
                $validatedData['user_role'] = 'kurir';
                $validatedData['user_img'] = $courier->courier_img;
            } else {
                $validatedData['user_img'] = static::uploadFile($request, $validatedData);
            }

            // Hash Password
            $validatedData['password'] = Hash::make($validatedData['password']);

            // dd($validatedData);

            User::create($validatedData);

            Session::flash('success', 'Data pengguna berhasil ditambahkan!');
            return redirect()->route('admin.users.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal menyimpan data pengguna');
            return redirect()->route('admin.users.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = ["title" => "Edit Akun Pengguna", "header_title" => "Edit Data Akun Pengguna"];

        // Ambil semua courier yang tidak terhapus dan belum ada di tabel fleets
        $data["couriers"] = Courier::whereNull('deleted_at') // Pastikan kurir belum di-soft delete
            ->whereNotIn('courier_ID', User::whereNotNull('courier_ID')->pluck('courier_ID')->toArray()) // Ambil hanya yang sudah terisi
            ->select('courier_ID', 'courier_name') // Pilih hanya field yang diperlukan
            ->get();

        $data['user'] = $user;

        // dd($data["couriers"][0]->fleet->fleet_nopol);
        return view('pages.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate Inputs

        $validatedData = static::validasiInput($request, $user);


        try {
            // Input File
            if ($user->user_role == "kurir" && isset($validatedData['username_courier'])) {
                $validatedData['username'] = $validatedData['username_courier'];
            }

            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            if ($validatedData['password'] === null) {
                $validatedData['password'] = $user->password;
            }


            if (isset($validatedData['user_img'])) {
                $validatedData['user_img'] = static::uploadFile($request, $validatedData, $user);
            }


            // dd($validatedData);


            $user->update($validatedData);
            // User::create($validatedData);

            Session::flash('success', 'Data pengguna berhasil diperbarui!');
            return redirect()->route('admin.users.index');
        } catch (\Throwable $th) {
            // Simpan pesan error ke session
            Session::flash('error', 'Gagal memperbarui data pengguna');
            return redirect()->route('admin.users.edit', $user->user_ID)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Hapus data dari database
            $user->delete();

            Session::flash('success', 'Data pengguna berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus data pengguna: ' . $e->getMessage());
        }

        // Redirect kembali ke daftar kurir
        return redirect()->route('admin.users.index');
    }

    static  private function validasiInput(Request $request, $userData = [])
    {
        $messages = [
            'user_name.required'  => 'Nama pengguna harus diisi.',
            'user_name.string'    => 'Nama pengguna harus berupa teks.',
            'user_name.max'       => 'Nama pengguna maksimal 255 karakter.',

            'username.required'   => 'Username harus diisi.',
            'username.string'     => 'Username harus berupa teks.',
            'username.max'        => 'Username maksimal 255 karakter.',
            'username.unique'     => 'Username sudah digunakan.',

            'username_courier.required'   => 'Username harus diisi.',
            'username_courier.string'     => 'Username harus berupa teks.',
            'username_courier.max'        => 'Username maksimal 255 karakter.',
            'username_courier.unique'     => 'Username sudah digunakan.',

            'password.required'   => 'Kata sandi harus diisi.',
            'password.string'     => 'Kata sandi harus berupa teks.',
            'password.min'        => 'Kata sandi minimal 8 karakter.',

            'user_role.required'  => 'Peran pengguna harus dipilih.',
            'user_role.in'        => 'Peran pengguna tidak valid.',

            'courier_ID.required' => 'Kurir harus diisi.',
            'courier_ID.exists'   => 'Kurir yang dipilih tidak ditemukan.',

            'user_img.required'   => 'Foto pengguna harus harus diisi.',
            'user_img.image'      => 'Foto pengguna harus berupa gambar.',
            'user_img.mimes'      => 'Format gambar harus jpeg, jpg, atau png.',
            'user_img.max'        => 'Ukuran gambar maksimal 2MB.',
        ];

        $validationFormat = [
            'user_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users,username',
            // 'username_courier'   => 'string|max:255|unique:users,username',
            'password'   => 'required|string|min:8', // harus ada input password_confirmation juga
            'user_role'  => 'required|in:admin,korlap',
            // 'courier_ID' => 'nullable|exists:couriers,courier_ID', // hanya kalau rolenya kurir
            'user_img'   => 'required|image|mimes:jpeg,png,jpg|max:2048', // maksimal 2MB
        ];

        // dd($request->get("mode_insert"));
        if ($request->input("mode_insert") == "courier") {
            $validationFormat['username'] = '';
            $validationFormat['username_courier'] = 'required|string|max:255|unique:users,username';
            $validationFormat['courier_ID'] = 'required|exists:couriers,courier_ID';
            $validationFormat['user_name'] = '';
            $validationFormat['user_role'] = '';
            $validationFormat['user_img'] = '';
        }

        if ($request->isMethod('PUT')) {
            $validationFormat['username'] = 'required|string|max:255';
            $validationFormat['username_courier'] = 'required|string|max:255';
            $validationFormat['user_name'] = 'required|string|max:255';

            if (!$request->input("user_role")) {
                $validationFormat['user_role'] = '';
            }

            if ($request->input("password") != null) {
                $validationFormat['password'] = 'string|min:8';
            } else {
                $validationFormat['password'] = '';
            }

            if ($userData['user_img'] != null) {
                $validationFormat['user_img'] = 'mimes:jpg,jpeg,png|max:2048';
            }
        }


        $validatedData = $request->validate($validationFormat, $messages);
        // dd($validatedData);

        return $validatedData;
    }

    static private function uploadFile(Request $request, $data, $user = [])
    {
        $timestamp = now()->timestamp;
        $imgFileName = "";
        $imgPath = "";

        if (!empty($user)) {
            $imgPath = $user["user_img"];
        }

        // dd($user);


        if (isset($data["user_img"])) {
            $imgFileName = "{$timestamp}." . $data["user_img"]->getClientOriginalExtension();
            $existingImages = Storage::disk('public')->files(static::$imgFolder);
            if ($request->isMethod('PUT')) {
                foreach ($existingImages as $file) {
                    if (str_starts_with(basename($file), basename($user['user_img']))) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            $imgPath = $data["user_img"]->storeAs(static::$imgFolder, $imgFileName, 'public');
        }


        return $imgPath;
    }
}
