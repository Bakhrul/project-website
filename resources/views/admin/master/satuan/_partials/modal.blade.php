<div class="modal inmodal fade" id="modal-tambah-satuan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Tambah Data Satuan</h5>
            </div>

            <div class="modal-body">
                <form id="form-tambah-satuan">
                    @csrf
                    <div class="form-group">
                        <label class="label-notempty">Nama Satuan</label>
                        <input type="text" class="form-control" id="u_name_store" name="u_name"
                            placeholder="Masukkan nama satuan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="storeSatuan()" class="btn btn-primary btn-sm" id="btnStoreSatuan">Simpan Data
                </button>
            </div>

        </div>
    </div>
</div>



<div class="modal inmodal fade" id="modal-edit-satuan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Edit Data Satuan</h5>
            </div>

            <div class="modal-body">
                <form id="form-edit-satuan">
                    @csrf
                    <input type="hidden" class="d-none" name="u_id" id="u_id_update" readonly>
                    <div class="form-group">
                        <label class="label-notempty">Nama Satuan</label>
                        <input type="text" class="form-control" id="u_name_update" name="u_name"
                            placeholder="Masukkan nama satuan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="updateSatuan()" class="btn btn-primary btn-sm" id="btnUpdateSatuan">Perbarui Data
                </button>
            </div>

        </div>
    </div>
</div>
