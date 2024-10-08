<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PplPendaftar;
use App\Models\MasterProdi;
use App\Models\User;
use App\Models\KuliahLapanganFakultas;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }
    public function konfirmasi($username, $password)
    {
        return view('konfirmasi-akun', [
            'username' => $username,
            'password' => $password,
        ]);
    }
    public function resetPassword(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        // return $user;
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah password',
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }
    }

    public function authenticate(Request $request)
    {
        // return $request->all();
        $user = User::where('username', $request->username)->count();
        if ($user == 0) {
            // return $user;
            // return "ggwp";
            return redirect()->route('confirm.user', [$request->username, $request->password]);
        } else {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
            // return Auth::attempt($credentials);
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // $role  = Auth::user()->roleDefault()->role->nama_role;
                $role = Auth::user()->userRole->role->nama_role;
                if ($role == "administrator" || $role == "admin_fakultas") {
                    $data = KuliahLapanganFakultas::with('fakultas')->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id)->first();
                    session(['role' => $role, 'fakultasData' => $data]);
                    return redirect()->intended(route('dashboard'));
                } else if ($role == "mahasiswa") {
                    $data = KuliahLapanganFakultas::with('fakultas')->where('master_fakultas_id', Auth::user()->userMahasiswa->mahasiswa->prodi->master_fakultas_id)->first();
                    session(['role' => $role, 'fakultasData' => $data]);
                    return redirect()->intended(route('mahasiswa.dashboard'));
                } else if ($role == "tenaga_kependidikan" || $role == "dosen") {
                    session(['role' => $role]);
                    return redirect()->intended(route('pembimbing.dashboard'));
                }
            }
            // return $credentials;
            return back()->withInput()->with('fail', 'Login Gagal, pastikan username dan password sesuai');
        }
    }

    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login-page');
    }
    // public function indexApi()
    // {
    //     return view('login-api');
    // }



    // public function sessionDirect(Request $request, $role)
    // {
    // return $request->all();
    // return redirect()->route('create.session');
    // return array('datanya inimi' => );
    // $check = PplPendaftar::where([
    //     'iddata' => $request->iddata,
    //     // 'is_update' => 0
    //     // ])->first();
    // ])->first();
    // return $check;
    // if ($role == "mahasiswa") {
    //     $credentials = [
    //         'email' => 'mhs@mail.com',
    //         'password' => '1234qwer'
    //     ];
    //     if (Auth::attempt($credentials)) {

    // $request->session()->regenerate();
    // $prodi = MasterProdi::with('masterFakultas')->where('prodi_kode', $request->idprodi)->first();
    // session(
    //     [
    //         'iddata' => $request->iddata,
    //         'fakultas_id' => $prodi->masterFakultas->id
    //     ]
    // );
    //             $check = PplPendaftar::where([
    //                 'iddata' => $request->iddata,
    //                 // 'is_update' => 0
    //                 // ])->first();
    //             ]);
    //             return $check;
    //             if (!empty($check)) {
    //                 if ($check->is_update == 0)

    //                     return redirect()->intended(route('mahasiswa.dashboard'));
    //             }
    //             // return $request->session()->get('role');

    //             return redirect()->intended(route('mahasiswa.dashboard'));
    //         }
    //     } else {
    //         $credentials = [
    //             'email' => 'pembimbing@mail.com',
    //             'password' => '1234qwer'
    //         ];
    //         if (Auth::attempt($credentials)) {
    //             $request->session()->regenerate();
    //             session(
    //                 [
    //                     'role' => "pembimbing",
    //                     'data' => $id
    //                 ]
    //             );
    //             return redirect()->intended(route('pembimbing.dashboard'));
    //         }
    //     }
    //     // return $request->session()->get('role');
    //     // return Auth::user()->userRole->nama_role;
    // }
    // public function createSession(Request $request)
    // {
    //     return redirect()->route('create.session');
    //     // return array('datanya inimi' => );
    //     if ($request->role == "mahasiswa") {
    //         $credentials = [
    //             'email' => 'mhs@mail.com',
    //             'password' => '1234qwer'
    //         ];
    //         if (Auth::attempt($credentials)) {
    //             $request->session()->regenerate();
    //             session(
    //                 [
    //                     'role' => "mahasiswa",
    //                     'data' => json_decode($request->data)
    //                 ]
    //             );

    //             // return redirect()->intended(route('dashboard'));
    //         }
    //     } else {
    //         session(
    //             [
    //                 'role' => "pembimbing",
    //             ]
    //         );
    //     }
    //     return $request->session()->get('data');
    //     return Auth::user()->userRole->nama_role;
    // }


}
