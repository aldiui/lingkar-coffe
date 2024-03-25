<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HargaController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'harga_jual' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
            }

            $user = Auth::user()->hargaJual;
            if (!$user) {
                return $this->errorResponse(null, 'Data Harga Jual tidak ditemukan.', 404);
            }

            $user->update($request->only('harga_jual'));

            return $this->successResponse($user, 'Data Harga Jual berhasil diperbarui.');
        }

        return view('pages.user.harga.index');
    }
}
