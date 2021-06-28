<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Saldo</title>

    <style>
        body {
            font-family: 'Arial';
            padding: 0 !important;
            margin: 0 !important;
            text-align: center;
        }

    </style>
</head>

<body>
    <div style="background:#081f36 !important;text-align:center;padding:30px 10px;color:#fff;font-size:20px;">
        Pembelian Saldo Berhasil
    </div>
    <div style="text-align:center;padding:15px;">Terima kasih telah membeli paket saldo, dengan detail paket sebagai
        berikut :</div>
    <div style="text-align:center;padding:5px 15px;width:100%;"><b>Nama Paket</b> : {{$data['saldo']->s_name}}</div>
    <div style="text-align:center;padding:5px 15px;width:100%;"><b>Harga</b> :
        {{number_format($data['saldo']->s_price ?? 0,2,',','.')}}</div>
        <div style="text-align:center;padding:15px;">Silahkan transfer ke salah satu daftar rekening dibawah sesuai
            dengan nominal
            pembelian :</div>
        @foreach($data['bank'] as $row)
        <div style="text-align:center;border:1px #ddd solid;padding:15px;margin:15px;line-height:2;">
            <div style="text-align:center;">Nama Bank :{{$row->b_name}} </div>
            <div style="text-align:center;">Nomor rekening : <b>{{$row->b_number_account}}</b></div>
            <div style="text-align:center;">a.n {{$row->b_name_account}}</div>
        </div>
        @endforeach

        <div style="text-align:center;background: #F7F9FB !important; padding:15px;margin-top:15px;">Copyright © 2021
            Project Website
        </div>
</body>

</html>
