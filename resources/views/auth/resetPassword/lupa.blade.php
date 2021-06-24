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
                <form id="form-data">
                    @csrf
                    <div class="title-auth-box">Lupa Password</div>
                    <div class="form-group">
                        <label class="label-form label-required">Alamat Email</label>
                        <input type="email" class="form-control input-form" name="u_email" id="u_email"
                            placeholder="name@example.com">
                    </div>
                </form>
                <button type="button" class="btn btn-primary w-100 font-weight" id="btnForgotPassword"
                    onclick="forgotPassword()">Kirim Email</button>
                <div style="font-size:14px;" class="text-center mt-3">Sudah punya akun? <a
                        href="{{route('login.index')}}">
                        Login disini</a></div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('extra_script')

<script type="text/javascript">
    var ajaxError = function (jqXHR, xhr, textStatus, errorThrow, exception) {
        if (jqXHR.status === 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Error! Not connect.\n Verify Network.',
            });
        } else if (jqXHR.status == 400) {
            Swal.fire({
                title: 'Peringatan!',
                text: jqXHR['responseJSON'].message,
            });
        } else if (jqXHR.status == 404) {
            Swal.fire({
                title: 'Error!',
                text: 'Requested page not found. [404]',
            });
        } else if (jqXHR.status == 500) {
            Swal.fire({
                title: 'Error!',
                text: 'Internal Server Error [500]. Please try again!',
            });
        } else if (exception === 'parsererror') {
            Swal.fire({
                title: 'Error!',
                text: 'Requested JSON parse failed.',
            });
        } else if (exception === 'timeout') {
            Swal.fire({
                title: 'Error!',
                text: 'Time out error. Please try again!',
            });
        } else if (exception === 'abort') {
            Swal.fire({
                title: 'Error!',
                text: 'Ajax request aborted.',
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Internal Server Error [500]. Please try again!',
            });
        }
    };

    function forgotPassword() {
        let email = $("#u_email").val();

        if (!email) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Email tidak boleh kosong!',
            });
            return false;
        }
        let emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
        let emailValidation = emailRegex.test(email);
        if (!emailValidation) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Masukkan email yang valid!',
            });
            return false;
        }

        $('#btnForgotPassword').prop('disabled', true);
        $.ajax({
            url: "{{route('lupa_password.process')}}",
            type: 'POST',
            data: $('#form-data').serialize(),
            success: function (resp) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: resp.message,
                });
            },
            error: ajaxError,
            complete: function () {
                $('#btnForgotPassword').prop('disabled', false);

            },
        });

    }

</script>


@endsection
