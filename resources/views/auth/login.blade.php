<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Авторизация</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />


    <link rel="shortcut icon" href="{{URL::to('/')}}/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{URL::to('/')}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::to('/')}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="bg-body">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" >
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <a href="{{URL::to('/')}}" class="">
{{--                <img alt="Logo" src="assets/media/custom/logo.png" class="h-90px" />--}}
                <img alt="Logo" src="{{URL::to('/')}}/assets/media/logos/g10.png" style="height: 65px!important; margin-bottom: 15px;" />
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">Авторизация</h1>
                        <!--end::Title-->

                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid" type="text" name="email" id="login" autocomplete="off" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Пароль</label>
                            <!--end::Label-->
                            <!--begin::Link-->
                            <a href="../../demo6/dist/authentication/flows/basic/password-reset.html" class="link-primary fs-6 fw-bolder d-none">Forgot Password ?</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Input-->
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" id="password" autocomplete="off" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-warning w-100 mb-5">
                            <span class="indicator-label">Авторизоваться</span>
                            <span class="indicator-progress">Авторизация...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Submit button-->
                        <!--begin::Separator-->
                        <div class="text-center text-muted text-uppercase fw-bolder mb-5 d-none">or</div>
                        <!--end::Separator-->
                        <!--begin::Google link-->

                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Main-->
{{--<script>var hostUrl = "assets/";</script>--}}
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{URL::to('/')}}/assets/plugins/global/plugins.bundle.js"></script>
{{--<script src="{{URL::to('/')}}/assets/js/scripts.bundle.js"></script>--}}
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script>
    $(function () {
        $('#kt_sign_in_submit').on('click', function (e) {
            let btn = $(this);
            btn.attr("data-kt-indicator", "on").prop('disabled', true);

            e.preventDefault();

            var data = {
                login: $('#login').val(),
                password: $('#password').val(),
                _token: $('input[name=_token]').val(),
            };

            $.ajax({
                url: '{{URL::to('/')}}/login',
                method: 'post',
                data: data,
                success: function (res, status, xhr, $form) {
                    // console.log(res);
                    // similate 2s delay
                    setTimeout(function () {
                        if (res.error) {
                            btn.removeAttr( 'data-kt-indicator' ).prop('disabled', false);
                            toastr.error(res.error);
                        } else {
                            location.href = "{{URL::to('/')}}/dashboard";
                        }
                    }, 300);
                },
                error:function (error){
                    btn.removeAttr( 'data-kt-indicator' ).prop('disabled', false);
                    toastr.error('server error');
                }
            });
        });
    })
</script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
