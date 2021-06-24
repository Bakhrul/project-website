<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>
    <link href="{{asset('admin-template/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin-template/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin-template/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin-template/css/plugins/jQueryUI/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('admin-template/css/plugins/dataTables/datatables2.min.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{asset('admin-template/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- Gritter -->
    <link href="{{asset('admin-template/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin-template/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin-template/css/custom.css')}}" rel='stylesheet'>
    @yield('extra_css')
    <style>
        .mr-2 {
            margin-right: 10px;
        }

        .label-notempty::after {
            content: ' *';
            color: red;
            font-weight: bold;
        }

        .select2-container--open {
            z-index: 9999999
        }

    </style>
</head>
