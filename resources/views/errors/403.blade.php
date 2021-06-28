<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            font-family: 'Arial';
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 !important;
            padding: 0 !important;
        }

        .box-error {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            max-width: 600px;
        }

        .image-error {
            max-width: 420px;
        }

        .title-error {
            font-size: 32px;
            padding-top:25px;
        }

        .description-error {
            font-size: 14px;
            text-align: center;
            color: #364B67;
            line-height: 1.5;
            padding-top: 15px;
        }

        .btn-error {
            max-width: 200px;
            width: 100%;
            padding: 13px 10px;
            background: #1455a8 !important;
            border: 0 !important;
            box-shadow: unset !important;
            color: #fff !important;
            border-radius: 5px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 25px;
            font-size: 16px;
            cursor:pointer;
            text-align:center;
            text-decoration:none !important;
        }        

    </style>
</head>

<body>
    <div class="box-error">
        <img src="{{asset('images/error/500.PNG')}}" class="image-error">
        <div class="title-error">Forbidden Access!</div>
        <div class="description-error">We are sorry,but you do not have access to this page or resource.
        </div>
        <a href="{{url('/')}}" class="btn btn-error">Go Home</a>
    </div>

</body>

</html>
