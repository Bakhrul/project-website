@extends('admin.main')
@section('extra_css')
<style>
    .d-none {
        display: none !important;
    }

</style>
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Master Item</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin-panel')}}">Home</a>
            </li>
            <li class="">
                Master
            </li>
            <li class="active">
                <strong>Master Item</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Item</h5>
                    <div class="ibox-tools">
                        <button onclick="tambahItem()" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&ensp;Tambah
                            Item</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table-item">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Item</th>
                                    <th>Satuan</th>
                                    <th style="text-align:center">Aksi</th>
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
@include('admin.master.item._partials.modal')

@endsection


@section('extra_script')

<script type="text/javascript">
    var table, tablePrice;
    setTimeout(function () {
        tableItem();
    }, 500);
    var ajaxError = function (jqXHR, xhr, textStatus, errorThrow, exception) {
        if (jqXHR.status === 0) {
            toastr.error('Not connect.\n Verify Network.', 'Error!');
        } else if (jqXHR.status == 400) {
            toastr.warning(jqXHR['responseJSON'].message, 'Peringatan!');
        } else if (jqXHR.status == 404) {
            toastr.error('Requested page not found. [404]', 'Error!');
        } else if (jqXHR.status == 500) {
            toastr.error('Internal Server Error [500].' + jqXHR['responseJSON'].message, 'Error!');
        } else if (exception === 'parsererror') {
            toastr.error('Requested JSON parse failed.', 'Error!');
        } else if (exception === 'timeout') {
            toastr.error('Time out error.', 'Error!');
        } else if (exception === 'abort') {
            toastr.error('Ajax request aborted.', 'Error!');
        } else {
            toastr.error('Uncaught Error.\n' + jqXHR.responseText, 'Error!');
        }
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    // function to retrieve DataTable server side
    function tableItem() {
        $('#table-item').dataTable().fnDestroy();
        table = $('#table-item').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('master.item.datatable') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'image',
                    name: 'image',
                    class: 'text-center',
                },
                {
                    data: 'i_name',
                    name: 'i_name',
                },
                {
                    data: 'u_name',
                    name: 'u_name',
                    class: 'text-center',
                },
                {
                    data: 'action',
                    name: 'action',
                    class: 'text-center'
                }
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, 'All']
            ]
        });
    }


    // Add Data
    function tambahItem() {
        $('#modal-tambah-item').modal('show');
        $('#i_name_store').val('');
        $('#i_unit_store').val('').trigger('change');
        $('#i_icon_store').val('');
        $('#i_icon_preview_store').attr('src', `{{asset('admin-template/img/item.png')}}`);
        $('#btnStoreItem').prop('disabled', false);
    }

    function storeItem() {
        let name = $('#i_name_store').val();
        let satuan = $('#i_unit_store').val();

        if (!name) {
            toastr.warning('Nama item tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!satuan) {
            toastr.warning('Silahkan pilih satuan terlebih dahulu!', 'Peringatan!');
            return false;
        }

        $('#btnStoreItem').prop('disabled', true);
        var formData = new FormData($('#form-tambah-item')[0]);
        var type = 'POST';
        var url = "{{ route('master.item.store') }}";
        $.ajax({
            url: url,
            type: type,
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (data) {
                $('#modal-tambah-item').modal('hide');
                toastr.success(data.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnStoreItem').prop('disabled', false);
            },
        });
    }


    // Edit Data
    function editItem(id) {
        $.ajax({
            url: "{{url('admin-panel/master/item/show')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {
                $('#modal-edit-item').modal('show');
                $('#i_id_update').val(resp.data.i_id);
                $('#i_name_update').val(resp.data.i_name);
                $('#i_unit_update').val(resp.data.i_unit).trigger('change');
                $('#i_icon_update').val('');
                if (resp.data.i_icon) {
                    $('#i_icon_preview_update').attr('src', `{{asset('storage/images/item')}}/` + resp.data
                        .i_icon);
                }
                $('#btnUpdateItem').prop('disabled', false);
            },
            error: ajaxError,
        });
    }


    function updateItem() {
        let name = $('#i_name_update').val();
        let satuan = $('#i_unit_update').val();

        if (!name) {
            toastr.warning('Nama item tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!satuan) {
            toastr.warning('Silahkan pilih satuan terlebih dahulu!', 'Peringatan!');
            return false;
        }

        let id = $('#i_id_update').val();
        var formData = new FormData($('#form-edit-item')[0]);
        $('#btnUpdateItem').prop('disabled', true);
        $.ajax({
            url: "{{url('admin-panel/master/item/update')}}/" + id,
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (resp) {
                $('#modal-edit-item').modal('hide');
                toastr.success(resp.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnUpdateItem').prop('disabled', false);

            },
        });

    }

    function deleteItem(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data item akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Sekarang!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{url('admin-panel/master/item/delete')}}/" + id,
                    type: 'POST',
                    success: function (resp) {
                        toastr.success(resp.message, 'Berhasil!');
                        table.ajax.reload();
                    },
                    error: ajaxError,
                });

            }
        })
    }

    function resetImage(evt, type) {
        if (type == 'store') {
            $('#i_icon_preview_store').attr('src', `{{asset('admin-template/img/item.png')}}`);
        } else {
            $('#i_icon_preview_update').attr('src', `{{asset('admin-template/img/item.png')}}`);
        }

    }

    function imageChange(evt, type) {
        evt.preventDefault();
        evt.stopImmediatePropagation();

        var conteks = $(evt.target)
        var that = this;

        if (window.FileReader) {
            var fileReader = new FileReader(),
                files = document.getElementById(conteks.attr('id')).files,
                file;
            if (!files.length) {
                return;
            }
            file = files[0];
            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    var size = file.size / 1024;

                    if (Math.round(size) > 1024) {
                        toast('File tidak boleh melebihi 1024kb.', 'info');
                        return;
                    }
                    if (type == 'store') {
                        $('#i_icon_preview_store').attr('src', this.result);
                    } else {
                        $('#i_icon_preview_update').attr('src', this.result);
                    }


                };
            } else {
                toastr.error('File yang anda pilih tidak termasuk gambar.', 'Error!');
            }
        }
    }

    function settingItem(id) {
        flagInsertPriceItem();
        $('#ip_item_store').val(id);
        $('#modal-price-item').modal('show');

        $('#table-price-item').dataTable().fnDestroy();
        tablePrice = $('#table-price-item').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('master.item.price.datatable') }}",
                type: "post",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'tanggal',
                    name: 'tanggal',
                    class: 'text-center',
                },
                {
                    data: 'nominal',
                    name: 'nominal',
                    class: 'text-right',
                },
                {
                    data: 'action',
                    name: 'action',
                    class: 'text-center'
                }
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, 'All']
            ]
        });
    }

    function storePriceItem() {
        let date = $('#ip_date_store').val();
        let price = $('#ip_price_store').val();

        if (!date) {
            toastr.warning('Tanggal tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!price) {
            toastr.warning('Harga tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        $('#btnStorePriceItem').prop('disabled', true);
        var type = 'POST';
        var url = "{{ route('master.item.price.store') }}";
        $.ajax({
            url: url,
            type: type,
            data: $('#form-tambah-price').serialize(),
            success: function (data) {
                flagInsertPriceItem();
                toastr.success(data.message, 'Berhasil!');
                tablePrice.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnStorePriceItem').prop('disabled', false);
            },
        });
    }

    // Edit Data
    function editPrice(id) {
        $.ajax({
            url: "{{url('admin-panel/master/item/price/show')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {
                flagUpdatePriceItem();
                $('#ip_id_update').val(resp.data.ip_id);
                $('#ip_date_update').val(humanizeDate(resp.data.ip_date));
                $('#ip_price_update').val(humanizePrice(resp.data.ip_price));

            },
            error: ajaxError,
        });
    }

    function updatePriceItem() {
        let date = $('#ip_date_update').val();
        let price = $('#ip_price_update').val();

        if (!date) {
            toastr.warning('Tanggal tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!price) {
            toastr.warning('Harga tidak boleh kosong!', 'Peringatan!');
            return false;
        }
        let id = $('#ip_id_update').val();

        $('#btnUpdatePriceItem').prop('disabled', true);
        $('#btnCancelUpdatePriceItem').prop('disabled', true);

        var type = 'POST';
        var url = "{{ url('admin-panel/master/item/price/update')}}/" + id;
        $.ajax({
            url: url,
            type: type,
            data: $('#form-edit-price').serialize(),
            success: function (data) {
                flagInsertPriceItem();
                toastr.success(data.message, 'Berhasil!');
                tablePrice.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnUpdatePriceItem').prop('disabled', false);
                $('#btnCancelUpdatePriceItem').prop('disabled', true);
            },
        });
    }

    function flagInsertPriceItem() {
        $('#store-price-item-group').removeClass('d-none');
        $('#update-price-item-group').addClass('d-none');

        $('#ip_date_store').val('');
        $('#ip_price_store').val('0');

        $('#btnStorePriceItem').prop('disabled', false);
    }

    function flagUpdatePriceItem() {
        $('#store-price-item-group').addClass('d-none');
        $('#update-price-item-group').removeClass('d-none');

        $('#ip_id_update').val('');
        $('#ip_date_update').val('');
        $('#ip_price_update').val('0');

        $('#btnUpdatePriceItem').prop('disabled', false);
        $('#btnCancelUpdatePriceItem').prop('disabled', false);
    }

</script>


@endsection
