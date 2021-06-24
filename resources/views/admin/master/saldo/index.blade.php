@extends('admin.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Master Saldo</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin-panel')}}">Home</a>
            </li>
            <li class="">
                Master
            </li>
            <li class="active">
                <strong>Master Saldo</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Saldo</h5>
                    <div class="ibox-tools">
                        <button onclick="tambahSaldo()" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&ensp;Tambah
                            Saldo</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table-saldo">
                            <thead>
                                <tr>
                                    <th>Nominal</th>
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
@include('admin.master.saldo._partials.modal')

@endsection


@section('extra_script')

<script type="text/javascript">
    var table;
    setTimeout(function () {
        tableSaldo();
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
    function tableSaldo() {
        $('#table-saldo').dataTable().fnDestroy();
        table = $('#table-saldo').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('master.saldo.datatable') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [
                {
                    data: 'nominal',
                    name: 'nominal',
                    class: 'text-right'
                },
                {
                    data: 'action',
                    name: 'action',
                    class:'text-center'
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
    function tambahSaldo() {
        $('#modal-tambah-saldo').modal('show');
        $('#s_price_store').val('0');
        $('#btnStoreSaldo').prop('disabled',false);
    }

    function storeSaldo() {
        let name = $('#s_price_store').val();

        if(!name){
            toastr.warning('Nominal saldo tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        $('#btnStoreSaldo').prop('disabled',true);
        var type = 'POST';
        var url = "{{ route('master.saldo.store') }}";
        $.ajax({
            url: url,
            type: type,
            data: $('#form-tambah-saldo').serialize(),
            success: function (data) {
                $('#modal-tambah-saldo').modal('hide');
                toastr.success(data.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnStoreSaldo').prop('disabled',false);
            },
        });
    }


    // Edit Data
    function editSaldo(id) {
        $.ajax({
            url: "{{url('admin-panel/master/saldo/show')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {
                $('#modal-edit-saldo').modal('show');
                $('#s_id_update').val(resp.data.s_id);
                $('#s_price_update').val(resp.data.s_price ? humanizePrice(resp.data.s_price) : '0');
                $('#btnUpdateSaldo').prop('disabled',false);
            },
            error: ajaxError,
        });
    }


    function updateSaldo() {
        let name = $('#s_price_update').val();
        if(!name){
            toastr.warning('Nominal saldo tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        let id = $('#s_id_update').val();
        $('#btnUpdateSaldo').prop('disabled',true);
        $.ajax({
            url: "{{url('admin-panel/master/saldo/update')}}/" + id,
            type: 'POST',
            data: $('#form-edit-saldo').serialize(),
            success: function (resp) {
                $('#modal-edit-saldo').modal('hide');
                toastr.success(resp.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnUpdateSaldo').prop('disabled',false);

            },
        });

    }

    function deleteSaldo(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data saldo akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Sekarang!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{url('admin-panel/master/saldo/delete')}}/" + id,
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

</script>


@endsection
