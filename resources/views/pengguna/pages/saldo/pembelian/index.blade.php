@extends('pengguna.main')
@section('extra_style')
<style>
    .navbar-custom {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
    }

    .saldo-element {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
        padding: 20px 15px;
        border-radius: 10px;
        margin-bottom: 25px;
    }
    .saldo-element .title{
        font-size:12px;
        color:#007bff !important;
        padding-bottom:5px;
    }
    .saldo-element .price {
        font-size: 20px;
    }

    .saldo-element .btn-buy-saldo {
        border: 1px #081f36 solid !important;
        color: #081f36 !important;
        background: #fff;
        font-size: 14px;
        padding: 10px 5px;
        margin-top: 15px;
        width: 100%;
        transition: 0.5s;
    }

    .saldo-element .btn-buy-saldo:hover {
        background: #081f36 !important;
        transition: 0.5s;
        color: #fff !important;
    }

    .loader-custom {
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 10px solid #00b6cd;
        border-bottom: 10px solid #00b6cd;
        width: 80px;
        height: 80px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    #modal-loading.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

</style>
@endsection
@section('content')
<div class="container">
    <div class="row min-height-auth">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between mt-5 pb-3 flex-wrap">
                <h5 class="">Tambah Saldo</h5>
                <div style="color:#007bff !important;font-size:18px;font-weight:600;">
                    @if(Auth::user()->u_saldo)
                    {{number_format(Auth::user()->u_saldo,2)}}
                    @else
                    0.00
                    @endif
                </div>
            </div>
            <div class="row">
                @foreach($saldo as $row)
                <div class="col-lg-3 col-md-6">
                    <div class="saldo-element">
                        <div class="title">
                            @if($row->s_name)
                            {{$row->s_name}}
                            @else
                            -
                            @endif
</div>
                        <div class="price">
                            @if($row->s_price)
                            {{number_format($row->s_price,2)}}
                            @else
                            0.00
                            @endif
                        </div>
                        <button class="btn btn-buy-saldo" type="button" onclick="buySaldo({{$row->s_id}})">Beli
                            Saldo</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('pengguna.layouts._footer')
    <div class="modal" tabindex="-1" role="dialog" data-backdrop="static" id="modal-loading">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="loader-custom"></div>
                        <span style="font-size:18px;padding-left:10px;">Mohon Tunggu Sebentar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_script')

<script type="text/javascript">
    var ajaxError = function (jqXHR, xhr, textStatus, errorThrow, exception) {
        if (jqXHR.status === 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Error! Not connect.\n Verify Network.',
            });
        } else if (jqXHR.status == 400) {
            Swal.fire({
                title: 'Peringatan!',
                text: jqXHR['responseJSON'].message,
            });
        } else if (jqXHR.status == 404) {
            Swal.fire({
                title: 'Error!',
                text: 'Requested page not found. [404]',
            });
        } else if (jqXHR.status == 500) {
            Swal.fire({
                title: 'Error!',
                text: 'Internal Server Error [500]. Please try again!',
            });
        } else if (exception === 'parsererror') {
            Swal.fire({
                title: 'Error!',
                text: 'Requested JSON parse failed.',
            });
        } else if (exception === 'timeout') {
            Swal.fire({
                title: 'Error!',
                text: 'Time out error. Please try again!',
            });
        } else if (exception === 'abort') {
            Swal.fire({
                title: 'Error!',
                text: 'Ajax request aborted.',
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Internal Server Error [500]. Please try again!',
            });
        }
    };

    function buySaldo(id) {
        Swal.fire({
            icon: 'question',
            title: 'Apakah anda yakin?',
            text: "Saldo yang anda pilih akan dilakukan pembelian!",
            showConfirmButton: true,
            showCloseButton: true,
            showCancelButton: true,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                buySaldoProcess(id);
            }
        });



    }

    function buySaldoProcess(id) {
        $('#modal-loading').modal('show');
        $.ajax({
            url: "{{route('pembelian_saldo.buy')}}",
            type: 'POST',
            data: {
                saldo: id,
                "_token": "{{ csrf_token() }}"
            },
            success: function (resp) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: resp.message,
                    showConfirmButton: true,
                    showCloseButton: false,
                    showCancelButton: false,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = "{{route('history_saldo.index')}}";
                    }
                });
            },
            error: ajaxError,
            complete: function () {
                $('#modal-loading').modal('hide');
                $('#btnRegister').prop('disabled', false);

            },
        });
    }

</script>
@endsection
