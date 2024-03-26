@extends('layouts.app')

@section('title', 'Profil')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.css') }}">
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="mb-3">Data @yield('title')</h3>
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
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control border-custom border-3" id="nama"
                                    name="nama" value="{{ auth()->user()->nama }}">
                                <small class="text-danger small" id="errornama"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control border-custom border-3" id="email"
                                    name="email" value="{{ auth()->user()->email }}">
                                <small class="text-danger small" id="erroremail"></small>
                            </div>
                            <div class="form-group mt-4">
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class=" mb-0">Ubah Password</h5>
                    </div>
                    <div class="card-body">
                        <form id="updatePassword">
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="password_lama" class="form-label">Password Lama<span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control border-custom border-3" id="password_lama"
                                    name="password_lama">
                                <small class="text-danger small" id="errorpassword_lama"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control border-custom border-3" id="password"
                                    name="password">
                                <small class="text-danger small" id="errorpassword"></small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control border-custom border-3"
                                    id="password_confirmation" name="password_confirmation">
                            </div>
                            <div class="form-group mt-4">
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
                const url = `{{ route('admin.profil') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleSuccess(response, null, null, "no");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleValidationErrors(error, "updateData", ["nama", "email"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updatePassword").submit(function(e) {
                setButtonLoadingState("#updatePassword .btn.btn-primary", true);
                e.preventDefault();
                const url = `{{ route('admin.profil.password') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updatePassword .btn.btn-primary", false);
                    handleSuccess(response, null, null, "no");
                    $('#updatePassword .small').html("");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updatePassword .btn.btn-primary", false);
                    handleValidationErrors(error, "updatePassword", ["password_lama", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
