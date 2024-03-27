<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $setoran = Penjualan::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('setoran');
            $keuntungan = Penjualan::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('keuntungan');
            $insentif = Penjualan::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('insentif');
            $qty = Penjualan::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('qty');

            return $this->successResponse(compact('setoran', 'keuntungan', 'insentif', 'qty'), 'Data Keuangan.');
        }

        return view('pages.admin.keuangan.index');
    }
}
