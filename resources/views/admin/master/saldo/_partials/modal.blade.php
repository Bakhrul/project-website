<div class="modal inmodal fade" id="modal-tambah-saldo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Tambah Data Saldo</h5>
            </div>

            <div class="modal-body">
                <form id="form-tambah-saldo">
                    @csrf
                    <div class="form-group">
                        <label class="label-notempty">Nama Paket</label>
                        <input type="text" class="form-control" id="s_name_store" name="s_name"
                            placeholder="Masukkan nama paket">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Nominal Saldo</label>
                        <input type="text" class="form-control input-currency" id="s_price_store" name="s_price"
                            placeholder="Masukkan nominal saldo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="storeSaldo()" class="btn btn-primary btn-sm" id="btnStoreSaldo">Simpan
                    Data
                </button>
            </div>

        </div>
    </div>
</div>



<div class="modal inmodal fade" id="modal-edit-saldo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Edit Data Saldo</h5>
            </div>

            <div class="modal-body">
                <form id="form-edit-saldo">
                    @csrf
                    <input type="hidden" class="d-none" name="s_id" id="s_id_update" readonly>
                    <div class="form-group">
                        <label class="label-notempty">Nama Paket</label>
                        <input type="text" class="form-control" id="s_name_update" name="s_name"
                            placeholder="Masukkan nama paket">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Nominal Saldo</label>
                        <input type="text" class="form-control input-currency" id="s_price_update" name="s_price"
                            placeholder="Masukkan nominal saldo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="updateSaldo()" class="btn btn-primary btn-sm"
                    id="btnUpdateSaldo">Perbarui Data
                </button>
            </div>
        </div>
    </div>
</div>
