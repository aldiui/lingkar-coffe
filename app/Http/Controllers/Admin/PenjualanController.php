<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use DataTables;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $penjualans = Penjualan::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->get();
            if ($request->mode == "datatable") {
                return DataTables::of($penjualans)
                    ->addColumn('aksi', function ($penjualan) {
                        $editButton = '<button class="btn btn-sm btn-warning me-1" onclick="getModal(`createModal`, `/penjualan/' . $penjualan->id . '`, [`id`, `tanggal`, `qty`])"><i class="fas fa-pencil-alt"></i></button>';
                        $deleteButton = '<button class="btn btn-sm btn-danger " onclick="confirmDelete(`/penjualan/' . $penjualan->id . '`, `penjualan-table`)"><i class="fas fa-trash"></i></button>';
                        return $penjualan->status != 1 ? $editButton . $deleteButton : $penjualan->status_badge;
                    })
                    ->addColumn('tgl', function ($penjualan) {
                        return $penjualan->tgl;
                    })
                    ->addColumn('setoran_rupiah', function ($penjualan) {
                        return formatRupiah($penjualan->setoran);
                    })
                    ->addColumn('keuntungan_rupiah', function ($penjualan) {
                        return formatRupiah($penjualan->keuntungan);
                    })
                    ->addColumn('insentif_rupiah', function ($penjualan) {
                        return formatRupiah($penjualan->insentif);
                    })
                    ->addColumn('mitra', function ($stok) {
                        return $stok->user->nama;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'tgl', 'setoran_rupiah', 'keuntungan_rupiah', 'insentif_rupiah', 'mitra'])
                    ->make(true);
            }
        }
        return view('pages.admin.penjualan.index');
    }
}
