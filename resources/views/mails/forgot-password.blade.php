<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Akun</title>

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
        Lupa Password Akun
    </div>
    <div style="text-align:center;padding:15px;margin-bottom:15px;">Terima kasih telah lupa password akun anda, tekan
        tombol dibawah guna mereset akun anda</div>
    <div style="width:100%;text-align:center;">
        <a href="{{url('reset-password')}}?token={{$data['token']}}"
            style="text-align:center;background: #081f36;color:#fff;padding:15px;border-radius:10px;">Reset Password</a>
    </div>

    <div style="text-align:center;padding:15px;margin-top:15px;">Abaikan pesan ini jika tidak merasa melakukan lupa
        password akun anda.</div>
    <div style="text-align:center;background: #F7F9FB !important; padding:15px;margin-top:15px;">Copyright © 2021
        Project Website
    </div>
</body>

</html>
