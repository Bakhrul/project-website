@extends('admin.main')
@section('content')
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins" style="border-top:4px #1ab394 solid;">
                <div class="ibox-title">
                    <h5>Pendapatan</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">Rp {{number_format($pendapatan, 2)}}</h1>
                    <small>Total Pembelian Saldo</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins" style="border-top:4px #f8ac59 solid;">
                <div class="ibox-title">
                    <h5>Item</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$item}}</h1>
                    <small>Jumlah Item Aktif</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins" style="border-top:4px #ed5565 solid;">
                <div class="ibox-title">
                    <h5>Pengguna</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$pengguna}}</h1>
                    <small>Jumlah Pengguna Aktif</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
