@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">@yield('title')</h3>
            </div>
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bulan_filter" class="form-label">Bulan</label>
                                    <select name="bulan_filter" id="bulan_filter"
                                        class="form-control border-custom border-3">
                                        @foreach (bulan() as $key => $value)
                                            <option value="{{ $key + 1 }}"
                                                {{ $key + 1 == date('m') ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tahun_filter" class="form-label">Tahun</label>
                                    <select name="tahun_filter" id="tahun_filter"
                                        class="form-control border-custom border-3">
                                        @for ($i = now()->year; $i >= now()->year - 4; $i--)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-wallet me-2"></i>Keuntungan :
                        <span id="keuntungan">Rp. 0</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-money-bill me-2"></i> Setoran :
                        <span id="setor">Rp. 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-weight-hanging me-2"></i> Terjual :
                        <span id="qty">300</span> PCS
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-shop me-2"></i> Tersedia :
                        <span>{{ auth()->user()->stok }} PCS</span>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="card card-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            reloadData('dashboard');

            $("#bulan_filter, #tahun_filter").on("change", function() {
                reloadData('dashboard');
            });
        })
    </script>
@endpush
