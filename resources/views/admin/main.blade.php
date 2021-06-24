<!DOCTYPE html>
<html>
@include('admin.layouts._head')

<body>
    <div id="overlay-loading">
        <div class="content-loader">
            <div class="lds-dual-ring"></div><br>
            <span class="text">Sedang memuat halaman, mohon tunggu sebentar.</span>
        </div>
    </div>
    <div id="wrapper">

        @include('admin.layouts._sidebar')

        <div id="page-wrapper" class="dashbard-1" style="background:#ebedef;">
            <div class="row">
                @include('admin.layouts._navbar')
            </div>

            @yield('content')

            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper wrapper-content">
                    </div>
                </div>
                @include('admin.layouts._footer')
            </div>
        </div>

    </div>
    </div>

    <!-- Mainly scripts -->
    @include('admin.layouts._script')
    @yield('extra_script')
</body>

</html>
