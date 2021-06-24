@extends('pengguna.main')
@section('extra_style')
<style>
    .navbar-custom {
        box-shadow: 0px 0px 10px rgb(0 0 0 / 9%) !important;
    }

    .box-image-profile {
        border-radius: 100px;
        width: 140px;
        height: 140px;
        display: block;
        margin: 0 auto 25px auto;
        border: 1px #FAEC24 solid;
        position: relative;
    }

    .box-image-profile img {
        border-radius: 100px;
        width: 140px;
        height: 140px;
        border: 1px #FAEC24 solid;

    }

    .btn-profile-image {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 35px;
        border-radius: 100px;
        padding: 5px !important;
    }

    .c-pointer {
        cursor: pointer;
    }

</style>
@endsection
@section('content')
<div class="container min-height-auth">
    <div class="row min-height-auth mb-5">
        <div class="col-lg-12 auth-wrapper min-height-auth" style="background:#fff !important;">
            <div class="auth-box">
                <form id="form-data" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="u_photo" name="u_photo" hidden class="d-none" onchange="imageChange(event)">
                    <div class="p-relative box-image-profile">
                        <img src="{{asset('storage/images/pengguna')}}/{{$user->u_photo}}" id="u_photo_preview"
                            onerror="this.onerror=null; this.src='{{asset('member-template/images/avatar-placeholder.png')}}'">
                        <button class="btn btn-profile-image btn-warning" type="button" onclick="uploadFoto(event)"><i
                                class="fa fa-edit"></i></button>
                    </div>
                    <div class="form-group">
                        <label class="label-form label-required">Nama Lengkap</label>
                        <input type="text" class="form-control input-form" name="u_name" id="u_name"
                            value="{{$user->u_name}}" placeholder="Jhon Doe">
                    </div>
                    <div class="form-group">
                        <label class="label-form label-required">Alamat Email</label>
                        <input type="email" class="form-control input-form" value="{{$user->u_email}}" disabled
                            placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label class="label-form">Password</label>
                        <input type="password" class="form-control input-form" id="u_password" name="u_password"
                            placeholder="Password akun">
                        <div style="font-size:12px" class="mt-1">(Kosongkan jika tidak ingin mengubah password)
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label-form">Nomor Telepon</label>
                        <input type="number" class="form-control input-form" name="u_phone" value="{{$user->u_phone}}"
                            placeholder="Ex: 081285270793">
                    </div>
                </form>
                <button type="button" class="btn btn-primary w-100 font-weight" id="btnUpdateProfile"
                    onclick="updateProfile()">Perbarui Profile</button>
                <a href="{{ Route('auth.logout') }}"><button class="btn btn-secondary w-100 mt-3" type="buttton">Logout</button></a>
            </div>

        </div>
    </div>
    @include('pengguna.layouts._footer')
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

    function updateProfile() {
        let name = $('#u_name').val();

        if (!name) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Nama lengkap tidak boleh kosong.',
            });
            return false;
        }
        var formData = new FormData($('#form-data')[0]);
        $('#btnUpdateProfile').prop('disabled', true);
        $.ajax({
            url: "{{route('profile.update')}}",
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (resp) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: resp.message,
                    showConfirmButton: false,
                    showCloseButton: false,
                    showCancelButton: false,
                });
            },
            error: ajaxError,
            complete: function () {
                $('#btnUpdateProfile').prop('disabled', false);

            },
        });

    }

    function uploadFoto(evt) {
        $('#u_photo').click();
        $("#u_photo_preview").attr("src", "{{asset('member-template/images/avatar-placeholder.png')}}").animate({
            opacity: 1
        }, 700);
    }

    function imageChange(evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();

        var conteks = $(evt.target)
        var that = this;

        if (window.FileReader) {
            var fileReader = new FileReader(),
                files = document.getElementById(conteks.attr('id')).files,
                file;
            if (!files.length) {
                return;
            }
            file = files[0];
            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    var size = file.size / 1024;

                    if (Math.round(size) > 1024) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'File tidak boleh melebihi 1024kb.',
                        });
                        return;
                    }
                    $("#u_photo_preview").attr("src", this.result).animate({
                        opacity: 1
                    }, 700);

                };
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'File yang anda pilih bukan termasuk gambar!',
                });
            }
        }
    }

</script>


@endsection
