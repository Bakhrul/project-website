<!DOCTYPE html>
<html>
<meta charset="utf-8">
@hasSection('extra_title')
@yield('extra_title')
@else
<title>Project - Selamat Datang</title>
@endif

@hasSection('extra_meta')
@yield('extra_meta')
@else
@endif

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('pengguna.layouts._head')

<body>
    @include('pengguna.layouts._navbar')
    <div id="main-content">
        @yield('content')

    </div>


    @include('pengguna.layouts._script')
    @yield('extra_script')
</body>

</html>
