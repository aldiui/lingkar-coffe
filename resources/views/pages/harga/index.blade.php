@extends('layouts.app')

@section('title', 'Harga')

@push('style')
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">Atur @yield('title')</h3>
            </div>
            <div class="col-lg-6">
                <form action="">
                    <div class="form-group mb-3">
                        <label for="harga_distributor" class="form-label">Harga Distributor</label>
                        <input type="text" class="form-control border-custom border-3" id="harga_distributor">
                    </div>
                    <div class="form-group mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control border-custom border-3" id="harga_jual">
                    </div>
                    <button class="btn btn-primary btn-sm rounded-pill" type="submit">Simpan</button>
                </form>
                <small>*Keuntungan: Harga distributor sudah termasuk profit sharing dan insentif</small>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
