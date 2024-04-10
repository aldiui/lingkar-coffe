<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $stoks = Stok::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->get();
            if ($request->mode == "datatable") {
                return DataTables::of($stoks)
                    ->addColumn('aksi', function ($stok) {
                        $editButton = '<button class="btn btn-sm btn-success me-1" onclick="getModal(`createModal`, `/admin/stok/' . $stok->id . '`, [`id`, `tanggal`, `qty`, `mitra`])"><i class="fas fa-check"></i></button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger " onclick="confirmDelete(`/admin/stok/' . $stok->id . '`, `stok-table`)"><i class="fas fa-trash"></i></button>';
                        return $stok->status != 1 ? $editButton . $deleteButton : $stok->status_badge;
                    })
                    ->addColumn('tgl', function ($stok) {
                        return $stok->tgl;
                    })
                    ->addColumn('status_badge', function ($stok) {
                        return $stok->status_badge;
                    })
                    ->addColumn('mitra', function ($stok) {
                        return $stok->user->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'tgl', 'status_badge', 'mitra'])
                    ->make(true);
            }
        }

        return view('pages.admin.stok.index');
    }

    public function show($id)
    {
        $stok = StoK::find($id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data Stok tidak ditemukan.', 404);
        }

        $stok->mitra = $stok->user->nama;

        return $this->successResponse($stok, 'Data Stok ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $stok = Stok::find($id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data Stok tidak ditemukan.', 404);
        }

        $status = $request->status;

        $stok->update([
            'status' => $status,
        ]);

        if ($status == 1) {
            $stok->user->update([
                'stok' => $stok->user->stok + $stok->qty,
            ]);
        }

        return $this->successResponse($stok, 'Data Stok diperbarui.');
    }

    public function destroy($id)
    {
        $stok = Stok::find($id);

        if (!$stok) {
            return $this->errorResponse(null, 'Data Stok tidak ditemukan.', 404);
        }

        $stok->delete();

        return $this->successResponse(null, 'Data Stok dihapus.');
    }
}