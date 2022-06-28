<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function indexApi()
    {
        return view('login-api');
    }
    public function sessionDirect($role, $id, Request $request)
    {
        // return redirect()->route('create.session');
        // return array('datanya inimi' => );
        if ($role == "mahasiswa") {
            $credentials = [
                'email' => 'mhs@mail.com',
                'password' => '1234qwer'
            ];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                session(
                    [
                        'role' => "mahasiswa",
                        'data' => $id
                    ]
                );
                // return $request->session()->get('role');

                return redirect()->intended(route('mahasiswa.dashboard'));
            }
        } else {
            $credentials = [
                'email' => 'pembimbing@mail.com',
                'password' => '1234qwer'
            ];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                session(
                    [
                        'role' => "pembimbing",
                        'data' => $id
                    ]
                );
                return redirect()->intended(route('pembimbing.dashboard'));
            }
        }
        // return $request->session()->get('role');
        // return Auth::user()->userRole->nama_role;
    }
    public function createSession(Request $request)
    {
        return redirect()->route('create.session');
        // return array('datanya inimi' => );
        if ($request->role == "mahasiswa") {
            $credentials = [
                'email' => 'mhs@mail.com',
                'password' => '1234qwer'
            ];
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                session(
                    [
                        'role' => "mahasiswa",
                        'data' => json_decode($request->data)
                    ]
                );

                // return redirect()->intended(route('dashboard'));
            }
        } else {
            session(
                [
                    'role' => "pembimbing",
                ]
            );
        }
        return $request->session()->get('data');
        return Auth::user()->userRole->nama_role;
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            session(
                [
                    'role' => "admin",
                ]
            );
            // dd($request->session()->get('test1'));
            return redirect()->intended(route('dashboard'));
        }
        return back()->withInput()->with('fail', 'Login Gagal, pastikan username dan password sesuai');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
