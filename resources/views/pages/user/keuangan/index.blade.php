@extends('layouts.app')

@section('title', 'Keuangan')

@push('style')
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">Data @yield('title')</h3>
                <button class="btn btn-primary btn-sm rounded-pill" type="button"><i
                        class="fa-solid fa-print me-2"></i>Cetak</button>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5 mb-3">
                        <i class="fa-solid fa-wallet me-2"></i>Keuntungan :
                        <span>Rp 1.000.000</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5 mb-3">
                        <i class="fa-solid fa-money-bill me-2"></i>Insentif : <span>Rp 1.000.000</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5 mb-3">
                        <i class="fa-solid fa-credit-card me-2"></i>Setor Penjualan : <span>Rp 1.000.000</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5">
                        <i class="fa-solid fa-bolt me-2"></i> Target :
                        <span>300 PCS/Bulan</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5">
                        <i class="fa-solid fa-check me-2"></i> Tercapai :
                        <span>310 PCS</span></h5>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
