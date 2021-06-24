<div class="modal inmodal fade" id="modal-tambah-bank" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Tambah Data Bank</h5>
            </div>

            <div class="modal-body">
                <form id="form-tambah-bank">
                    @csrf
                    <div class="form-group">
                        <label class="label-notempty">Nama Bank</label>
                        <input type="text" class="form-control" id="b_name_store" name="b_name"
                            placeholder="Masukkan nama bank">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Nomor Rekening</label>
                        <input type="number" class="form-control" id="b_number_account_store" name="b_number_account"
                            placeholder="Masukkan nomor rekening">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Atas Nama</label>
                        <input type="text" class="form-control" id="b_name_account_store" name="b_name_account"
                            placeholder="Masukkan nama pemilik rekening">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="storeBank()" class="btn btn-primary btn-sm" id="btnStoreBank">Simpan Data
                </button>
            </div>

        </div>
    </div>
</div>



<div class="modal inmodal fade" id="modal-edit-bank" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Edit Data Bank</h5>
            </div>

            <div class="modal-body">
                <form id="form-edit-bank">
                    @csrf
                    <input type="hidden" class="d-none" name="b_id" id="b_id_update" readonly>
                    <div class="form-group">
                        <label class="label-notempty">Nama Bank</label>
                        <input type="text" class="form-control" id="b_name_update" name="b_name"
                            placeholder="Masukkan nama bank">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Nomor Rekening</label>
                        <input type="number" class="form-control" id="b_number_account_update" name="b_number_account"
                            placeholder="Masukkan nomor rekening">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Atas Nama</label>
                        <input type="text" class="form-control" id="b_name_account_update" name="b_name_account"
                            placeholder="Masukkan nama pemilik rekening">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="updateBank()" class="btn btn-primary btn-sm"
                    id="btnUpdateBank">Perbarui Data
                </button>
            </div>

        </div>
    </div>
</div>
