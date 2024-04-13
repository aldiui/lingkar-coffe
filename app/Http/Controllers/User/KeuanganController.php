<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $pemasukan = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('pemasukan');
            $keuntungan = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('keuntungan');
            $insentif = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('status', '1')->sum('insentif');
            $insentifData = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('status', '0')->sum('insentif');
            $setoran = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('status', '0')->sum('setoran') + $insentifData;
            $qty = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('qty');
            if ($request->bulan == now()->month && $request->tahun == now()->year) {
                $qtyBelumSetor = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('status', '0')->sum('qty');
            } else {
                $qtyBelumSetor = 0;
            }

            return $this->successResponse(compact('setoran', 'keuntungan', 'insentif', 'qty', 'pemasukan', 'qtyBelumSetor'), 'Data Keuangan.');
        }

        return view('pages.user.keuangan.index');
    }
}
