@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3>DASHBOARD</h3>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5">
                        <i class="fa-solid fa-wallet me-2"></i> Keuntungan :
                        <span>Rp 1.000.000</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5">
                        <i class="fa-solid fa-money-bill me-2"></i> Setoran :
                        <span>Rp 2.500.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h5>Riwayat Penjualan</h5>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5">
                        <i class="fa-solid fa-weight-hanging me-2"></i> Terjual :
                        <span>300 PCS</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <div class="fs-5">
                        <i class="fa-solid fa-shop me-2"></i> Tersedia :
                        <span>200 PCS</span>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="card card-body border border-1 rounded-5 border-dark">
                    <img src="https://www.jaspersoft.com/content/dam/jaspersoft/images/graphics/infographics/column-chart-example.svg"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
