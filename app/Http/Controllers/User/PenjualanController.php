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
            $penjualans = Penjualan::where('user_id', Auth::user()->id)->whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->get();
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
                    ->addIndexColumn()
                    ->rawColumns(['aksi', 'tgl', 'setoran_rupiah', 'keuntungan_rupiah', 'insentif_rupiah'])
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Data tidak valid.', 422);
        }

        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return $this->errorResponse(null, 'Data Penjualan tidak ditemukan.', 404);
        }

        $qty = $request->qty;

        if (Auth::user()->stok < $qty) {
            return $this->errorResponse(null, 'Stok tidak mencukupi.', 409);
        }

        $setoran = $qty * Auth::user()->hargaJual->hargaPokok->harga_pokok;
        $insentif = $qty * Auth::user()->hargaJual->hargaPokok->insentif;
        $pemasukan = $qty * Auth::user()->hargaJual->harga_jual;
        $keuntungan = $qty * Auth::user()->hargaJual->hargaPokok->keuntungan;

        $penjualan->update([
            'tanggal' => $request->tanggal,
            'qty' => $qty,
            'setoran' => $setoran,
            'keuntungan' => $keuntungan,
            'insentif' => $insentif,
            'pemasukan' => $pemasukan,
        ]);

        return $this->successResponse($penjualan, 'Data Penjualan diperbarui.');
    }

    public function destroy($id)
    {

        $penjualan = Penjualan::find($id);

        if (!$penjualan) {
            return $this->errorResponse(null, 'Data Penjualan tidak ditemukan.', 404);
        }

        $penjualan->delete();

        return $this->successResponse(null, 'Data Penjualan telah dihapus.');
    }
}
