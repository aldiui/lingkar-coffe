<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HargaPokok;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HargaController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $hargaPokok = HargaPokok::first();
        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'harga_pokok' => 'required|numeric|min:0',
                'keuntungan' => 'required|numeric|min:0',
                'insentif' => 'required|numeric|min:0',
                'target' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Data tidak valid', 422);
            }

            if (!$hargaPokok) {
                return $this->errorResponse(null, 'Data Harga Pokok tidak ditemukan.', 404);
            }

            $hargaPokok->update($request->only('harga_pokok', 'keuntungan', 'insentif', 'target'));

            return $this->successResponse($hargaPokok, 'Data Harga Pokok berhasil diperbarui.');
        }

        return view('pages.admin.harga.index', compact('hargaPokok'));
    }
}
