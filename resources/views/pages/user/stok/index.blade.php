@extends('layouts.app')

@section('title', 'Stok')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/dataTables.bootstrap5.min.css') }}">
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-3">Data @yield('title')</h3>
                <button class="btn btn-primary bt-sm" type="button"><i class="fa-solid fa-plus me-2"></i>Minta
                    Stok Barang</button>
            </div>
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th>Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ auth()->user()->stok }} PCS Lingkar Coffee</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Stok Masuk</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>12 sep 2024</td>
                                        <td>330</td>
                                    </tr>

                                    <tr>
                                        <td>12 sep 2024</td>
                                        <td>330</td>
                                    </tr>

                                    <tr>
                                        <td>12 sep 2024</td>
                                        <td>330</td>
                                    </tr>

                                    <tr>
                                        <td>12 sep 2024</td>
                                        <td>330</td>
                                    </tr>

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
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        })
    </script>
@endpush
