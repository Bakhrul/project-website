@extends('pengguna.main')
@section('extra_style')
<style>
    .navbar-custom {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
    }

</style>
@endsection
@section('content')
<div class="container min-height-auth">
    <div class="row min-height-auth">
        <div class="col-lg-12 auth-wrapper min-height-auth">
            <div class="auth-box">
                @if (\Session::has('error'))
                <div class="mb-3">
                    <div class="alert alert-danger" role="alert" style="font-size:14px;">
                        {!! \Session::get('error') !!}
                    </div>
                </div>
                @endif
                @if (\Session::has('success'))
                <div class="mb-3">
                    <div class="alert alert-success" role="alert" style="font-size:14px;">
                        {!! \Session::get('success') !!}
                    </div>
                </div>
                @endif

                <form id="form-data" method="post" action="{{route('login.process')}}">
                    @csrf
                    <div class="title-auth-box">Login ke Akun Anda</div>
                    <div class="form-group">
                        <label class="label-form label-required">Alamat Email</label>
                        <input type="email" class="form-control input-form" name="u_email" id="u_email"
                            placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label class="label-form label-required">Password</label>
                        <input type="password" class="form-control input-form" id="u_password" name="u_password"
                            placeholder="Password akun">
                        <div style="font-size:14px;" class="text-right mt-1 mb-2"><a
                                href="{{route('lupa_password.index')}}">
                                Lupa password?</a></div>
                    </div>

                    <button type="submit" id="btnlogin" class="btn btn-primary w-100 font-weight">Login
                        Sekarang</button>
                </form>
                <div style="font-size:14px;" class="text-center mt-3">Belum punya akun? <a
                        href="{{route('register.index')}}">
                        Daftar disini</a></div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('extra_script')

<script type="text/javascript">
    $('#form-data').on('submit', function () {
        $('#btnlogin').prop('disabled', true);
    });

</script>


@endsection
