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
        Pembelian Saldo
    </div>
    <div style="text-align:center;padding:15px;"><b>{{$data['user']->u_name}}</b> baru saja membeli paket saldo, dengan
        detail paket</div>
    <div style="text-align:center;padding:5px 15px;"><b>Nama Paket</b> : {{$data['saldo']->s_name}}</div>
    <div style="text-align:center;padding:5px 15px;"><b>Harga</b> :
        {{number_format($data['saldo']->s_price ?? 0,2,',','.')}}</div>
        <div style="text-align:center;padding:15px;">Pesan ini dikirim otomatis oleh sistem ketika ada yang membeli
            saldo.</div>

        <div style="text-align:center;background: #F7F9FB !important; padding:15px;margin-top:15px;">Copyright © 2021
            Project Website </div>
</body>

</html>
