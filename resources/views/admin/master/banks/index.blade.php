@extends('admin.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Master Bank</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin-panel')}}">Home</a>
            </li>
            <li class="">
                Master
            </li>
            <li class="active">
                <strong>Master Bank</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Bank</h5>
                    <div class="ibox-tools">
                        <button onclick="tambahBank()" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&ensp;Tambah
                            Bank</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table-bank">
                            <thead>
                                <tr>
                                    <th>Nama Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Nama Pemilik Rekening</th>
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
@include('admin.master.banks._partials.modal')

@endsection


@section('extra_script')

<script type="text/javascript">
    var table;
    setTimeout(function () {
        tableBank();
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
    function tableBank() {
        $('#table-bank').dataTable().fnDestroy();
        table = $('#table-bank').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('master.banks.datatable') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'b_name',
                    name: 'b_name'
                },
                {
                    data: 'b_number_account',
                    name: 'b_number_account',
                    class: 'text-center'
                },
                {
                    data: 'b_name_account',
                    name: 'b_name_account'
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
    function tambahBank() {
        $('#modal-tambah-bank').modal('show');
        $('#b_name_store').val('');
        $('#b_number_account_store').val('');
        $('#b_name_account_store').val('');
        $('#btnStoreBank').prop('disabled', false);
    }

    function storeBank() {
        let name = $('#b_name_store').val();
        let nomorRekening = $("#b_number_account_store").val();
        let atasNamaRekening = $('#b_name_account_store').val();

        if (!name) {
            toastr.warning('Nama bank tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!nomorRekening) {
            toastr.warning('Nomor rekening tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!atasNamaRekening) {
            toastr.warning('Nama pemilik rekening tidak boleh kosong!', 'Peringatan!');
            return false;
        }


        $('#btnStoreBank').prop('disabled', true);
        var type = 'POST';
        var url = "{{ route('master.banks.store') }}";
        $.ajax({
            url: url,
            type: type,
            data: $('#form-tambah-bank').serialize(),
            success: function (data) {
                $('#modal-tambah-bank').modal('hide');
                toastr.success(data.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnStoreBank').prop('disabled', false);
            },
        });
    }


    // Edit Data
    function editBank(id) {
        $.ajax({
            url: "{{url('admin-panel/master/banks/show')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {
                $('#modal-edit-bank').modal('show');
                $('#b_id_update').val(resp.data.b_id);
                $('#b_name_update').val(resp.data.b_name);
                $('#b_number_account_update').val(resp.data.b_number_account);
                $('#b_name_account_update').val(resp.data.b_name_account);
                $('#btnUpdateBank').prop('disabled', false);
            },
            error: ajaxError,
        });
    }


    function updateBank() {
        let name = $('#b_name_update').val();
        let nomorRekening = $("#b_number_account_update").val();
        let atasNamaRekening = $('#b_name_account_update').val();

        if (!name) {
            toastr.warning('Nama bank tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!nomorRekening) {
            toastr.warning('Nomor rekening tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        if (!atasNamaRekening) {
            toastr.warning('Nama pemilik rekening tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        let id = $('#b_id_update').val();
        $('#btnUpdateBank').prop('disabled', true);
        $.ajax({
            url: "{{url('admin-panel/master/banks/update')}}/" + id,
            type: 'POST',
            data: $('#form-edit-bank').serialize(),
            success: function (resp) {
                $('#modal-edit-bank').modal('hide');
                toastr.success(resp.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnUpdateBank').prop('disabled', false);

            },
        });

    }

    function deleteBank(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data Bank akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Sekarang!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{url('admin-panel/master/banks/delete')}}/" + id,
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
