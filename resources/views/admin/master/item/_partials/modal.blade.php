<div class="modal inmodal fade" id="modal-tambah-item" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Tambah Data item</h5>
            </div>

            <div class="modal-body">
                <form id="form-tambah-item" method="POST" enctype="multipart/form-data">
                    @csrf
                    <img src="{{asset('admin-template/img/item.png')}}" height="100px" id="i_icon_preview_store"
                        style="display:block;margin:0 auto 30px auto;">
                    <div class="form-group">
                        <label>Gambar Item</label>
                        <input type="file" class="form-control" accept="image/*" name="i_icon" id="i_icon_store"
                            onClick="resetImage(event,'store')" onChange="imageChange(event,'store')">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Nama Item</label>
                        <input type="text" class="form-control" id="i_name_store" name="i_name"
                            placeholder="Masukkan nama item">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Satuan</label>
                        <select class="form-control select2" id="i_unit_store" name="i_unit">
                            <option value="">Pilih Satuan</option>
                            @foreach($satuan as $row)
                            <option value="{{$row->u_id}}">{{$row->u_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="storeItem()" class="btn btn-primary btn-sm" id="btnStoreItem">Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal fade" id="modal-edit-item" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Edit Data item</h5>
            </div>

            <div class="modal-body">
                <form id="form-edit-item" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="i_id_update" hidden readonly class="d-none">
                    @csrf
                    <img src="{{asset('admin-template/img/item.png')}}" height="100px" id="i_icon_preview_update"
                        style="display:block;margin:0 auto 30px auto;">
                    <div class="form-group">
                        <label>Gambar Item</label>
                        <input type="file" class="form-control" accept="image/*" name="i_icon" id="i_icon_update"
                            onClick="resetImage(event,'update')" onChange="imageChange(event,'update')">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Nama Item</label>
                        <input type="text" class="form-control" id="i_name_update" name="i_name"
                            placeholder="Masukkan nama item">
                    </div>
                    <div class="form-group">
                        <label class="label-notempty">Satuan</label>
                        <select class="form-control select2" id="i_unit_update" name="i_unit">
                            <option value="">Pilih Satuan</option>
                            @foreach($satuan as $row)
                            <option value="{{$row->u_id}}">{{$row->u_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" onclick="updateItem()" class="btn btn-primary btn-sm" id="btnUpdateItem">Perbarui
                    Data
                </button>
            </div>
        </div>
    </div>
</div>



<div class="modal inmodal fade" id="modal-price-item" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h5 class="modal-title">Setting Harga item</h5>
            </div>

            <div class="modal-body">
                <div id="store-price-item-group">
                    <form id="form-tambah-price">
                        <input type="hidden" id="ip_item_store" name="ip_item" hidden class="d-none" readonly hidden>
                        @csrf
                        <div class="form-group">
                            <label class="label-notempty">Tanggal</label>
                            <input type="date" class="form-control" id="ip_date_store" data-date-format="DD MMMM YYYY"
                                name="ip_date" required>
                        </div>
                        <div class="form-group">
                            <label class="label-notempty">Harga</label>
                            <input type="text" class="form-control input-currency" value="0" name="ip_price"
                                id="ip_price_store">
                        </div>
                    </form>
                    <div class="w-100 text-right ">
                        <button class="btn btn-primary btn-sm" type="button" onclick="storePriceItem()"
                            id="btnStorePriceItem">Tambah Data</button>
                    </div>
                </div>
                <div id="update-price-item-group">
                    <form id="form-edit-price">
                        @csrf
                        <input type="hidden" id="ip_id_update" hidden class="d-none" readonly hidden>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="readonly" id="ip_date_update" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label class="label-notempty">Harga</label>
                            <input type="text" class="form-control input-currency" name="ip_price" id="ip_price_update">
                        </div>
                    </form>
                    <div class="w-100 text-right ">
                        <button class="btn btn-secondary btn-sm" type="button" onclick="flagInsertPriceItem()"
                            id="btnCancelUpdatePriceItem">Batalkan</button>
                        <button class="btn btn-warning btn-sm" type="button" onclick="updatePriceItem()"
                            id="btnUpdatePriceItem">Perbarui Data</button>
                    </div>
                </div>
                <div class="table-responsive" style="margin-top:30px !important;">
                    <table class="table table-striped table-bordered w-100" id="table-price-item">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-right">Harga</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
