<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HargaJual;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponder;

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
            }

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return $this->errorResponse(null, 'Email atau password tidak valid.', 401);
            }

            $user = Auth::user();

            return $this->successResponse($user, 'Login berhasil.');
        }

        return view('pages.auth.login');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
            }

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'user',
            ]);

            HargaJual::create([
                'user_id' => $user->id,
                'harga_pokok_id' => '1',
                'harga_jual' => '0',
            ]);

            return $this->successResponse($user, 'Register berhasil.');
        }

        return view('pages.auth.register');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
