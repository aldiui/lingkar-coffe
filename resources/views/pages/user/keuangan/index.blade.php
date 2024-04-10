@extends('layouts.app')

@section('title', 'Keuangan')


@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.css') }}">
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">Data @yield('title')</h3>
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
            <div class="col-lg-4 mb-3">
                <div class="card card-body">
                    <div class="fs-5 mb-2">
                        <i class="fa-solid fa-wallet me-2"></i>Keuntungan :
                        <span id="keuntungan">Rp. 0</span>
                    </div>
                    <div class="fs-5 ">
                        <i class="fa-solid fa-wallet me-2"></i>Pemasukan :
                        <span id="pemasukan">Rp. 0</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-money-bill me-2"></i>Insentif : <span id="insentif">Rp. 0</span>
                    </div>
                    <small class="text-small text-danger d-block mb-2">*Insentif bisa ditarik minimal 300 Pcs </small>
                    <button class="btn btn-block btn-success btn-sm" onclick="changeKeungan('insentif')"><i
                            class="fa-solid fa-money-bill me-2"></i>Tarik
                        Insentif</button>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-credit-card me-2"></i>Setor Penjualan : <span id="setor">Rp. 0</span>
                    </div>
                    <small class="text-small text-danger d-block mb-2">*Anda belum melakukakan setoran 30 Pcs serta setoran
                        merupakan insentif + setoran penjualan </small>
                    <button class="btn btn-block btn-info btn-sm" onclick="changeKeungan('setor')"><i
                            class="fa-solid fa-credit-card me-2"></i>Setor Penjualan</button>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-bolt me-2"></i> Target :
                        <span>300</span> PCS/Bulan
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card card-body">
                    <div class="fs-5">
                        <i class="fa-solid fa-check me-2"></i> Tercapai :
                        <span id="qty">0</span> PCS/Bulan</h5>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-striped w-100" id="penjualan-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th class="text-start">Tanggal</th>
                                        <th class="text-start">Qty</th>
                                        <th class="text-start">Pemasukan</th>
                                        <th class="text-start">Keuntungan</th>
                                        <th class="text-start">Insentif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            datatableCall('penjualan-table', '{{ route('penjualan.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tgl',
                    name: 'tgl'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'setoran_rupiah',
                    name: 'setoran_rupiah'
                },
                {
                    data: 'keuntungan_rupiah',
                    name: 'keuntungan_rupiah'
                },
                {
                    data: 'insentif_rupiah',
                    name: 'insentif_rupiah'
                },
            ]);

            reloadData('keuangan_user');

            $("#bulan_filter, #tahun_filter").on("change", function() {
                $("#penjualan-table").DataTable().ajax.reload();
                reloadData('keuangan_user');
            });
        });
    </script>
@endpush
