<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Регистрация</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="shortcut icon" href="{{url('/')}}/favicon.ico"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{url('/')}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>

    <style>
        .form-check.form-check-solid .form-check-input:checked {
            background-color: #FF5612;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="toolbar-enabled toolbar-fixed"
      style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

@csrf
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" style="" class="header align-items-stretch">
                <!--begin::Container-->
                <div class="container-xxl d-flex align-items-stretch justify-content-between">
                    <!--begin::Aside mobile toggle-->
                    <!--end::Aside mobile toggle-->
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
                        <a href="{{url('/')}}/">
                            <img alt="Logo" src="{{url('/')}}/assets/media/logos/g10.png" class="h-20px h-lg-30px"/>
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Wrapper-->

                    <!--end::Wrapper-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Toolbar-->
                <div class="toolbar" id="kt_toolbar">
                    <!--begin::Container-->
                    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                        <!--begin::Page title-->
                        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                             data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                             class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                            <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Регистрация</h1>
                        </div>
                        <!--end::Page title-->

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Post-->
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-xxl">

                        <input type="hidden" id="modal_users_add__id">
                        <input value="{{$rec_id}}" type="hidden" id="modal_users_rec_id">

                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-body py-3">
                                <div class="row">
                                    <div class="col-xl-3">

                                    </div>
                                    <div class="col-xl-6 mt-10 mb-10">
                                        <h3>Заполните форму</h3>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Фамилия</label>
                                                    <input id="modal_users_add__lastName"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Имя</label>
                                                    <input id="modal_users_add__firstName"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Телефон</label>
                                                    <input id="modal_users_add__phone"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Email</label>
                                                    <input id="modal_users_add__email"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Viber</label>
                                                    <input id="modal_users_add__viber"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Facebook</label>
                                                    <input id="modal_users_add__facebook"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Банк</label>
                                                    <select class="form-control form-control-sm form-control-solid"
                                                            id="modal_users_add__account_type">
                                                        <option value="1">Польский</option>
                                                        <option value="2">Заграничный</option>
                                                        <option value="3">PayPal</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">Польский</label>
                                                    <input placeholder="Номер банковского счета"
                                                           id="modal_users_add__account_poland"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">PayPal</label>
                                                    <input placeholder="email" id="modal_users_add__account_paypal"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">Название банка</label>
                                                    <input id="modal_users_add__account_bank_name"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">IBAN</label>
                                                    <input id="modal_users_add__account_iban"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">Номер карты</label>
                                                    <input id="modal_users_add__account_card"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">SWIFT</label>
                                                    <input id="modal_users_add__account_swift"
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Пароль</label>

                                                    <div class="input-group input-group-solid mb-5">
                                <span onclick="generatePassword();" style="cursor: pointer" class="input-group-text"
                                ><i class="far fa-keyboard fs-6"></i></span>
                                                        <input id="modal_users_add__password"
                                                               class="form-control form-control-sm form-control-solid"
                                                               type="text"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                           id="flexCheckChecked" checked="checked">
                                                    <label class="form-check-label" for="flexCheckChecked">Соглашение на
                                                        обработку <a href="{{url('/')}}/privacy-policy.pdf">персональных
                                                            данных</a></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display:none;" class="row mb-5">
                                            <div class="col">
                                                <div class="fv-row">
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="kt_ecommerce_add_product_media">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick">
                                                            <!--begin::Icon-->
                                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>

                                                            <div class="ms-4">
                                                                <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Загрузить
                                                                    документ</h3>
                                                                <span class="fs-7 fw-bold text-gray-400">Перетащите документ сюда</span>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                    </div>
                                                    <!--end::Dropzone-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button id="modal_users_add__save" type="button"
                                                        class="btn btn-primary btn-sm">Сохранить
                                                </button>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Post-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted fw-bold me-1">2022©</span>
                    </div>
                    <!--end::Copyright-->

                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>


<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                          fill="currentColor"/>
					<path
                        d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                        fill="currentColor"/>
				</svg>
			</span>
    <!--end::Svg Icon-->
</div>


<script>var hostUrl = "{{url('/')}}/assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{url('/')}}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{url('/')}}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<script>

    $('#modal_users_add__save').click(function (e) {
        e.preventDefault();

        if ($('#flexCheckChecked').is(':checked') == false) {
            alert('Вам нужно дать согласие на обработку персональных данных!');
            return '';
        }


        let self = $(this);

        self.prop('disabled', true);

        var data = {
            recruter_id: $('#modal_users_rec_id').val(),
            email: $('#modal_users_add__email').val(),
            password: $('#modal_users_add__password').val(),
            firstName: $('#modal_users_add__firstName').val(),
            lastName: $('#modal_users_add__lastName').val(),
            phone: $('#modal_users_add__phone').val(),
            viber: $('#modal_users_add__viber').val(),
            facebook: $('#modal_users_add__facebook').val(),
            account_type: $('#modal_users_add__account_type').val(),
            account_poland: $('#modal_users_add__account_poland').val(),
            account_paypal: $('#modal_users_add__account_paypal').val(),
            account_bank_name: $('#modal_users_add__account_bank_name').val(),
            account_iban: $('#modal_users_add__account_iban').val(),
            account_card: $('#modal_users_add__account_card').val(),
            account_swift: $('#modal_users_add__account_swift').val(),

            _token: $('input[name=_token]').val(),
        };

        let remember_token = $('#modal_users_add__id').val();
        if (remember_token !== '') {
            data.remember_token = remember_token;
        }

        $.ajax({
            url: "{{url('/')}}/recruiter/portal/add",
            method: 'post',
            data: data,
            success: function (response, status, xhr, $form) {
                if (response.error) {
                    toastr.error(response.error);
                } else {
                    location.href = '{{url('/')}}/dashboard'
                }
                self.prop('disabled', false);
            }
        });
    });
    var myDropzone = new Dropzone("#kt_ecommerce_add_product_media", {
        url: "{{url('/')}}/files/user/add", // Set the url for your upload script location
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        sending: function (file, xhr, formData) {
            formData.append('_token', $('input[name=_token]').val());
            formData.append('user_id', $('#modal_users_add__id').val());
        },
        success: function (file, done) {
            $('#modal_users_add__id').val(done.remember_token);
        },
        accept: function (file, done) {
            done();
        }
    });

    function generatePassword() {
        var length = 11,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        $('#modal_users_add__password').val(retVal);
    }
</script>
</body>
<!--end::Body-->
</html>
