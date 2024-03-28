<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="label-modal"></span> Data @yield('title')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    @method('PUT')
                    <input type="hidden" id="id">
                    <div class="form-group mb-3">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control border-custom border-3" id="tanggal" name="tanggal">
                        <small class="text-danger small" id="errortanggal"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="qty" class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" class="form-control border-custom border-3" id="qty" name="qty">
                        <small class="text-danger small" id="errorqty"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
