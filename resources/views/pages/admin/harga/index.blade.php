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
                                <label for="harga_pokok" class="form-label">Harga Pokok <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control border-custom border-3" id="harga_pokok"
                                    name="harga_pokok" value="{{ $hargaPokok->harga_pokok }}">
                                <small class="text-danger small" id="errorharga_pokok"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="keuntungan" class="form-label">Keuntungan <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control border-custom border-3" id="keuntungan"
                                    name="keuntungan" value="{{ $hargaPokok->keuntungan }}">
                                <small class="text-danger small" id="errorkeuntungan"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="insentif" class="form-label">Insentif <span class="text-danger">*</span></label>
                                <input type="number" class="form-control border-custom border-3" id="insentif"
                                    name="insentif" value="{{ $hargaPokok->insentif }}">
                                <small class="text-danger small" id="errorinsentif"></small>
                            </div>
                            <div class="form-group mt-4 mb-2">
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </form>
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
                const url = `{{ route('admin.harga') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleSuccess(response, null, null, "no");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleValidationErrors(error, "updateData", ["harga_pokok", "keuntungan",
                        "insentif"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
