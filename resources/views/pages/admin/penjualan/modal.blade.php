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
                        <label for="mitra" class="form-label">Mitra</label>
                        <input type="text" class="form-control border-custom border-3" readonly id="mitra">
                        <small class="text-danger small" id="errormitra"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control border-custom border-3" readonly id="tanggal">
                        <small class="text-danger small" id="errortanggal"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" class="form-control border-custom border-3" readonly id="qty">
                        <small class="text-danger small" id="errorqty"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select border-custom border-3">
                            <option value="1">Disetujui</option>
                            <option value="2">Ditolak</option>
                            <option value="3">Periksa</option>
                            <option value="0">Belum Diperiksa</option>
                        </select>
                        <small class="text-danger small" id="errorstatus"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="insentif_status" class="form-label">Status Penarikan</label>
                        <select name="insentif_status" id="insentif_status" class="form-select border-custom border-3">
                            <option value="1">Disetujui</option>
                            <option value="2">Ditolak</option>
                            <option value="3">Proses Penarikan</option>
                            <option value="0">Tidak Dapat Penarikan</option>
                        </select>
                        <small class="text-danger small" id="errorinsentif_status"></small>
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
