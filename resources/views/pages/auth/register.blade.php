@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.css') }}">
@endpush

@section('main')
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/couch.png') }}" class="mb-3" width="100" alt="">
                    <h2 class="text-dark fw-bold">{{ config('app.name') }}</h2>
                    <h5 class="mb-3">@yield('title')</h5>
                </div>
                <form id="register" class="mb-3" autocomplete="off">
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-custom border-3" id="nama" name="nama">
                        <small class="text-danger small" id="errornama"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control border-custom border-3" id="email" name="email">
                        <small class="text-danger small" id="erroremail"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control border-custom border-3" id="password" name="password">
                        <small class="text-danger small" id="errorpassword"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control border-custom border-3" id="password_confirmation"
                            name="password_confirmation">
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-primary btn-sm rounded-pill btn-block w-100" type="submit">Register</button>
                    </div>
                </form>
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">Sudah punya akun?</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#register").submit(function(e) {
                setButtonLoadingState("#register .btn.btn-primary", true, "Register");
                e.preventDefault();
                const url = "{{ route('register') }}";
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#register .btn.btn-primary", false, "Register");
                    handleSuccess(response, null, null, "/login");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#register .btn.btn-primary", false, "Register");
                    handleValidationErrors(error, "register", ["nama", "email", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
