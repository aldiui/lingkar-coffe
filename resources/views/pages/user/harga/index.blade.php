@extends('layouts.app')

@section('title', 'Harga')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.css') }}">
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">Atur @yield('title')</h3>
            </div>
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class=" mb-0">Ubah Data @yield('title')</h5>
                    </div>
                    <div class="card-body">
                        <form id="updateData">
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="harga_distributor" class="form-label">Harga Distributor</span></label>
                                <input type="number" class="form-control border-custom border-3" id="harga_distributor"
                                    value="{{ auth()->user()->hargaJual->hargaPokok->harga }}" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="harga_jual" class="form-label">Markup Harga Jual <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control border-custom border-3" id="harga_jual"
                                    name="harga_jual" value="{{ auth()->user()->hargaJual->harga_jual }}">
                                <small class="text-danger small" id="errorharga_jual"></small>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </form>
                        <small class="text-danger">*Keuntungan: Harga distributor sudah termasuk profit sharing dan
                            insentif</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#updateData").submit(function(e) {
                setButtonLoadingState("#updateData .btn.btn-primary", true);
                e.preventDefault();
                const url = `{{ route('harga') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleSuccess(response, null, null, "no");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleValidationErrors(error, "updateData", ["harga_jual"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
