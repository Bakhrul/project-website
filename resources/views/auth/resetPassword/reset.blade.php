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
                    <input type="hidden" name="u_token" class="d-none" value="{{$user->u_token}}" readonly hidden>
                    <div class="title-auth-box">Reset Password</div>
                    <div class="form-group">
                        <label class="label-form label-required">Password Baru</label>
                        <input type="password" class="form-control input-form" id="new_password" name="new_password"
                            placeholder="Password Baru">

                    </div>
                    <div class="form-group">
                        <label class="label-form label-required">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control input-form" id="confirm_password"
                            name="confirm_password" placeholder="Konfirmasi Password Baru">

                    </div>
                </form>
                <button type="button" class="btn btn-primary w-100 font-weight" id="btnResetPassword"
                    onclick="resetPassword()">Reset Sekarang</button>
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

    function resetPassword() {
        let newPassword = $('#new_password').val();
        let confirmPassword = $('#confirm_password').val();

        if (!newPassword) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Password baru tidak boleh kosong!',
            });
            return false;
        }
        if (!confirmPassword) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Password konfirmasi tidak boleh kosong!',
            });
            return false;
        }
        if (newPassword != confirmPassword) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Password baru dan konfirmasi harus sama!',
            });
            return false;
        }

        $('#btnResetPassword').prop('disabled', true);
        $.ajax({
            url: "{{route('reset_password.process')}}",
            type: 'POST',
            data: $('#form-data').serialize(),
            success: function (resp) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: resp.message,
                    showConfirmButton: true,
                    showCloseButton: false,
                    showCancelButton: false,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = "{{route('login.index')}}";
                    }
                });
            },
            error: ajaxError,
            complete: function () {
                $('#btnResetPassword').prop('disabled', false);

            },
        });

    }

</script>


@endsection
