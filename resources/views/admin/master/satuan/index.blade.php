@extends('admin.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Master Satuan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin-panel')}}">Home</a>
            </li>
            <li class="">
                Master
            </li>
            <li class="active">
                <strong>Master Satuan</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Satuan</h5>
                    <div class="ibox-tools">
                        <button onclick="tambahSatuan()" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&ensp;Tambah
                            Satuan</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table-satuan">
                            <thead>
                                <tr>
                                    <th>Nama Satuan</th>
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
@include('admin.master.satuan._partials.modal')

@endsection


@section('extra_script')

<script type="text/javascript">
    var table;
    setTimeout(function () {
        tableSatuan();
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
    function tableSatuan() {
        $('#table-satuan').dataTable().fnDestroy();
        table = $('#table-satuan').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('master.satuan.datatable') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [
                {
                    data: 'u_name',
                    name: 'u_name'
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
    function tambahSatuan() {
        $('#modal-tambah-satuan').modal('show');
        $('#u_name_store').val('');
        $('#btnStoreSatuan').prop('disabled',false);
    }

    function storeSatuan() {
        let name = $('#u_name_store').val();

        if(!name){
            toastr.warning('Nama satuan tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        $('#btnStoreSatuan').prop('disabled',true);
        var type = 'POST';
        var url = "{{ route('master.satuan.store') }}";
        $.ajax({
            url: url,
            type: type,
            data: $('#form-tambah-satuan').serialize(),
            success: function (data) {
                $('#modal-tambah-satuan').modal('hide');
                toastr.success(data.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnStoreSatuan').prop('disabled',false);
            },
        });
    }


    // Edit Data
    function editSatuan(id) {
        $.ajax({
            url: "{{url('admin-panel/master/satuan/show')}}/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (resp) {
                $('#modal-edit-satuan').modal('show');
                $('#u_id_update').val(resp.data.u_id);
                $('#u_name_update').val(resp.data.u_name);
                $('#btnUpdateSatuan').prop('disabled',false);
            },
            error: ajaxError,
        });
    }


    function updateSatuan() {
        let name = $('#u_name_update').val();
        if(!name){
            toastr.warning('Nama satuan tidak boleh kosong!', 'Peringatan!');
            return false;
        }

        let id = $('#u_id_update').val();
        $('#btnUpdateSatuan').prop('disabled',true);
        $.ajax({
            url: "{{url('admin-panel/master/satuan/update')}}/" + id,
            type: 'POST',
            data: $('#form-edit-satuan').serialize(),
            success: function (resp) {
                $('#modal-edit-satuan').modal('hide');
                toastr.success(resp.message, 'Berhasil!');
                table.ajax.reload();
            },
            error: ajaxError,
            complete: function () {
                $('#btnUpdateSatuan').prop('disabled',false);

            },
        });

    }

    function deleteSatuan(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Satuan akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Sekarang!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{url('admin-panel/master/satuan/delete')}}/" + id,
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
