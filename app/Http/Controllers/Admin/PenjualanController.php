<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $penjualans = Penjualan::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->get();
            if ($request->mode == "datatable") {
                return DataTables::of($penjualans)
                    ->addColumn('aksi', function ($penjualan) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getModal(`createModal`, `/admin/penjualan/' . $penjualan->id . '`, [`id`, `tanggal`, `qty`, `mitra`, `status`, `insentif_status`])"><i class="fas fa-pencil-alt"></i></button>';
                        return $editButton;
                    })
                    ->addColumn('status', function ($penjualan) {
                        return $penjualan->status_badge;
                    })
                    ->addColumn('insentif_status', function ($penjualan) {
                        return statusBadgeInsentif($penjualan->insentif_status);
                    })
                    ->addColumn('tanggal', function ($penjualan) {
                        return $penjualan->tgl;
                    })
                    ->addColumn('setoran', function ($penjualan) {
                        return formatRupiah($penjualan->setoran);
                    })
                    ->addColumn('keuntungan', function ($penjualan) {
                        return formatRupiah($penjualan->keuntungan);
                    })
                    ->addColumn('insentif', function ($penjualan) {
                        return formatRupiah($penjualan->insentif);
                    })
                    ->addColumn('mitra', function ($penjualan) {
                        return $penjualan->user->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'tanggal', 'setoran', 'keuntungan', 'insentif', 'mitra', 'status', 'insentif_status'])
                    ->make(true);
            }
        }
        return view('pages.admin.penjualan.index');
    }

    public function show($id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return $this->errorResponse(null, 'Data penjualan tidak ditemukan.', 404);
        }

        $penjualan->mitra = $penjualan->user->nama;

        return $this->successResponse($penjualan, 'Data penjualan ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return $this->errorResponse(null, 'Data penjualan tidak ditemukan.', 404);
        }

        $penjualan->update([
            'status' => $request->status,
            'insentif_status' => ($request->status == 1) ? $request->insentif_status : 3,
        ]);

        return $this->successResponse($penjualan, 'Data penjualan diperbarui.');
    }

}
