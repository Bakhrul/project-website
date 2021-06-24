@extends('admin.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Konfirmasi Pembelian Saldo</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('/admin-panel')}}">Home</a>
            </li>
            <li class="active">
                <strong>Data pembelian</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Pembelian Saldo</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" id="table-pembelian">
                            <thead>
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Tanggal</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
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
        tablePembelian();
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
    function tablePembelian() {
        $('#table-pembelian').dataTable().fnDestroy();
        table = $('#table-pembelian').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('konfirmasi_saldo.datatable') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}"
                }
            },
            columns: [
                {
                    data: 'u_name',
                    name: 'u_name',
                    class: 'text-left'
                },
                {
                    data: 'u_email',
                    name: 'u_email',
                    class: 'text-left'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    class: 'text-center'
                },
                {
                    data: 'nominal',
                    name: 'nominal',
                    class: 'text-right'
                },
                {
                    data: 'status',
                    name: 'status',
                    class: 'text-center'
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
    function konfirmasiSaldo(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Pembelian saldo akan dikonfirmasi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi Sekarang!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{url('admin-panel/konfirmasi-saldo/konfirmasi')}}/" + id,
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
