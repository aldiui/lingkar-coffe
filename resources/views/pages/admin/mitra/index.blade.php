@extends('layouts.app')

@section('title', 'Profil')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.css') }}">
@endpush

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-3">Data @yield('title')</h3>
                <button class="btn btn-primary bt-sm" type="button" onclick="getModal('createModal')"><i
                        class="fa-solid fa-plus me-2"></i>Tambah Mitra</button>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100" id="user-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th class="text-start">Nama</th>
                                        <th class="text-start">Email</th>
                                        <th class="text-start">Stok</th>
                                        <th class="text-start" width="15%">Aksi</th>
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
    @include('pages.admin.mitra.modal')
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            datatableCall('user-table', '{{ route('admin.mitra.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-primary", true);
                e.preventDefault();
                const kode = $("#saveData #id").val();
                let url = "{{ route('admin.mitra.store') }}";
                const data = new FormData(this);

                if (kode !== "") {
                    data.append("_method", "PUT");
                    url = `/admin/mitra/${kode}`;
                }

                const successCallback = function(response) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleSuccess(response, "user-table", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleValidationErrors(error, "saveData", ["nama", "email", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
