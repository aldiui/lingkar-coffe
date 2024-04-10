<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Traits\ApiResponder;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        if ($request->ajax()) {
            $penjualans = Penjualan::where('user_id', Auth::user()->id)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->get();
            if ($request->mode == "datatable") {
                return DataTables::of($penjualans)
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
                        return formatRupiah($penjualan->setoran + $penjualan->keuntungan);
                    })
                    ->addColumn('keuntungan', function ($penjualan) {
                        return formatRupiah($penjualan->keuntungan);
                    })
                    ->addColumn('insentif', function ($penjualan) {
                        return formatRupiah($penjualan->status == "1" ? $penjualan->insentif : 0);
                    })
                    ->addColumn('pemasukan', function ($penjualan) {
                        return formatRupiah($penjualan->pemasukan);
                    })
                    ->addIndexColumn()
                    ->rawColumns(['tanggal', 'setoran', 'keuntungan', 'insentif', 'status', 'pemasukan', 'insentif_status'])
                    ->make(true);
            }
        }
        return view('pages.user.penjualan.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $qty = $request->qty;

        if (Auth::user()->stok < $qty) {
            return $this->errorResponse(null, 'Stok tidak mencukupi.', 409);
        }

        $setoran = $qty * Auth::user()->hargaJual->hargaPokok->harga_pokok;
        $insentif = $qty * Auth::user()->hargaJual->hargaPokok->insentif;
        $pemasukan = $qty * Auth::user()->hargaJual->harga_jual;
        $keuntungan = $qty * Auth::user()->hargaJual->hargaPokok->keuntungan;

        $penjualan = Penjualan::create([
            'tanggal' => $request->tanggal,
            'qty' => $qty,
            'setoran' => $setoran,
            'keuntungan' => $keuntungan,
            'insentif' => $insentif,
            'pemasukan' => $pemasukan,
            'user_id' => Auth::user()->id,
        ]);

        Auth::user()->update([
            'stok' => Auth::user()->stok - $qty,
        ]);

        return $this->successResponse($penjualan, 'Data Penjualan ditambahkan.', 201);
    }

    public function show($id)
    {
        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return $this->errorResponse(null, 'Data Penjualan tidak ditemukan.', 404);
        }

        return $this->successResponse($penjualan, 'Data Penjualan ditemukan.');
    }

    public function setorPenjualan(Request $request)
    {
        $now = now();
        $user = Auth::user();
        $penjualan = $user->penjualans()
            ->whereYear('tanggal', $now->year)
            ->whereMonth('tanggal', $now->month)
            ->where('status', '0')
            ->get();

        if ($penjualan->isEmpty()) {
            return $this->errorResponse(null, 'Anda tidak memiliki penjualan untuk bulan ini.');
        }

        $penjualan->each(function ($sale) use ($now) {
            $sale->update([
                'status' => "3",
                'status_time' => $now,
            ]);
        });

        return $this->successResponse(null, 'Setor Penjualan di Proses.');
    }

    public function insentifPenjualan(Request $request)
    {
        $now = now();
        $user = Auth::user();
        $penjualan = $user->penjualans()
            ->whereYear('tanggal', $now->year)
            ->whereMonth('tanggal', $now->month)
            ->where('status', '1')
            ->get();

        if ($penjualan->isEmpty()) {
            return $this->errorResponse(null, 'Anda tidak memiliki penjualan untuk bulan ini.');
        }

        $totalQty = $penjualan->sum('qty');

        if ($totalQty >= Auth::user()->hargaJual->hargaPokok->target) {
            $penjualan->each(function ($sale) use ($now) {
                $sale->update([
                    'insentif_status' => '3',
                    'insentif_time' => $now,
                ]);
            });

            return $this->successResponse(null, 'Insentif Penjualan di Proses.');
        } else {
            return $this->errorResponse(null, 'Anda tidak bisa mendapatkan insentif karena penjualan tidak mencapai target.');
        }
    }

}
