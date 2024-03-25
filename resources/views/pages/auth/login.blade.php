@extends('layouts.auth')

@section('title', 'Login')

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
                <form id="login" class="mb-3" autocomplete="off">
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
                    <div class="form-group mt-4">
                        <button class="btn btn-primary btn-sm rounded-pill btn-block w-100" type="submit">Login</button>
                    </div>
                </form>
                <div class="text-center">
                    <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun?</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#login").submit(function(e) {
                setButtonLoadingState("#login .btn.btn-primary", true, "Login");
                e.preventDefault();
                const url = "{{ route('login') }}";
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#login .btn.btn-primary", false, "Login");
                    handleSuccess(response, null, null, "/");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#login .btn.btn-primary", false, "Login");
                    handleValidationErrors(error, "login", ["email", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
