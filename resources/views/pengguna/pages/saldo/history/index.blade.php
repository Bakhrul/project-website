@extends('pengguna.main')
@section('extra_style')
<style>
    .navbar-custom {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
    }

    .c-pointer {
        cursor: pointer;
    }

    .table {
        margin-top: 15px;
    }

    .table thead {
        font-size: 14px !important;
        font-weight: 450;
    }

    .table tbody {
        font-size: 13px !important;
    }

</style>
@endsection
@section('content')
<div class="container">
    <div class="row min-height-auth">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between pb-2 mt-5 flex-wrap">
                <h5 class="">Riwayat Pembelian Saldo</h5>
                <div style="color:#007bff !important;font-size:18px;font-weight:600;">
                    @if(Auth::user()->u_saldo)
                    {{number_format(Auth::user()->u_saldo,2)}}
                    @else
                    0.00
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class=" thead-dark">
                        <tr>
                            <th scope="col" class="text-center">Tanggal Pembelian</th>
                            <th scope="col" class="text-right">Harga</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Dibayar Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $row)
                        <tr>
                            <td class="text-center">
                                @if($row->created_at)
                                {{date('d/m/Y', strtotime($row->created_at))}}
                                @else
                                -
                                @endif
                            </td>
                            <td class="text-right">
                                @if($row->hs_price)
                                {{number_format($row->hs_price, 2)}}
                                @else
                                0.00
                                @endif
                            </td>
                            <td class="text-center">
                                @if($row->hs_status == 'waiting')
                                <span class="text-warning font-weight-bold p-2">Menunggu Pembayaran</span>
                                @else
                                <span class="text-success font-weight-bold p-2">Pembayaran Berhasil</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($row->hs_status == 'waiting')
                                -
                                @else
                                @if($row->created_at)
                                {{date('d/m/Y', strtotime($row->hs_confirmation_date))}}
                                @else
                                -
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="w-100 d-flex justify-content-end">
                {{ $history->links() }}
            </div>
        </div>
    </div>
    @include('pengguna.layouts._footer')
</div>

@endsection

