@extends('layouts.app')

@section('title', 'Penjualan')

@push('style')
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">Data @yield('title')</h3>
                <button class="btn btn-primary btn-sm rounded-pill" type="button"><i class="fa-solid fa-plus me-2"></i>Tambah
                    Penjualan</button>
            </div>
            <div class="col-12">
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Qty</th>
                                <th>Pemasukan</th>
                                <th>Keuntungan</th>
                                <th>Insentif</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12 sep 2024</td>
                                <td>10</td>
                                <td>Rp 70.000</td>
                                <td>RP 10.000</td>
                                <td>RP 10.000</td>
                            </tr>
                            <tr>
                                <td>12 sep 2024</td>
                                <td>10</td>
                                <td>Rp 70.000</td>
                                <td>RP 10.000</td>
                                <td>RP 10.000</td>
                            </tr>
                            <tr>
                                <td>12 sep 2024</td>
                                <td>10</td>
                                <td>Rp 70.000</td>
                                <td>RP 10.000</td>
                                <td>RP 10.000</td>
                            </tr>
                            <tr>
                                <td>12 sep 2024</td>
                                <td>10</td>
                                <td>Rp 70.000</td>
                                <td>RP 10.000</td>
                                <td>RP 10.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="small">Jumlah Terjual : 40 PCS Lingkar Coffee</div>
                <div class="small">*Stok tersisa 20 PCS Lingkar Coffee</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
