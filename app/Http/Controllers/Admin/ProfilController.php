<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
            }

            $user = Auth::user();
            if (!$user) {
                return $this->errorResponse(null, 'Data profil tidak ditemukan.', 404);
            }

            $user->update($request->only('nama', 'email'));

            return $this->successResponse($user, 'Data profil berhasil diperbarui.');
        }

        return view('pages.admin.profil.index');
    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
        }

        $user = Auth::user();
        if (!$user) {
            return $this->errorResponse(null, 'Data Karyawan tidak ditemukan.', 404);
        }

        if (!Hash::check($request->password_lama, Auth::user()->password)) {
            return $this->errorResponse(null, 'Password lama tidak sesuai.', 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return $this->successResponse($user, 'Password berhasil diperbarui.');
    }
}
