<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $insentif = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('insentif');
            $setoran = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('setoran') + $insentif;
            $pemasukan = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('pemasukan');
            $keuntungan = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('keuntungan') + $pemasukan;

            $qty = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->sum('qty');
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

            $transaksiPerbulan = Penjualan::where('user_id', Auth::user()->id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get([
                    DB::raw('DATE(tanggal) as date'),
                    DB::raw('SUM(qty) as count'),
                ])
                ->pluck('count', 'date');

            $labels = [];
            $qtyPerhari = [];
            $dates = Carbon::parse($startDate);

            while ($dates <= $endDate) {
                $dateString = $dates->toDateString();
                $labels[] = formatTanggal($tahun . -$bulan, 'd');
                $qtyPerhari[] = $transaksiPerbulan->get($dateString) ?? 0;
                $dates->addDay();
            }

            $chart = [
                'labels' => $labels,
                'qty' => $qtyPerhari,
            ];

            return $this->successResponse(compact('setoran', 'keuntungan', 'qty', 'chart'), 'Data Dashboard.');
        }

        return view('pages.user.dashboard.index');
    }
}
