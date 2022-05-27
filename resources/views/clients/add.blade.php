<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Клиенты</title>

    @include('includes.global_styles')
    <style>

        .sorting_disabled.sorting_asc:after {
            display: none !important;
        }

        .sorting_disabled.sorting_desc:after {
            display: none !important;
        }
    </style>

</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
      style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
@csrf
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">

    @include('includes.aside')
    <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" style="" class="header align-items-stretch">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Aside mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                             id="kt_aside_mobile_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                            <span class="svg-icon svg-icon-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
											<path
                                                d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                                fill="currentColor"/>
											<path opacity="0.3"
                                                  d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                                  fill="currentColor"/>
										</svg>
									</span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Aside mobile toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="{{url('/')}}/" class="d-lg-none">
                            <img style="margin-top: 8px;" alt="Logo" src="{{url('/')}}/assets/media/logos/g10.png"
                                 class="h-30px"/>
                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                        @include('includes.Navbar')
                        @include('includes.Toolbar')
                    </div>
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
                            <!--begin::Title-->

                            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="{{url('/')}}/dashboard" class="text-muted text-hover-primary">Главная</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                </li>

                                <li class="breadcrumb-item text-muted">
                                    <a href="{{url('/')}}/clients" class="text-muted text-hover-primary">Клиенты</a>
                                </li>

                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                </li>


                                <li class="breadcrumb-item text-dark">Добавить клиента</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Post-->
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container-fluid">
                        <!--begin::Card-->
                        <div class="card">

                            <!--begin::Card body-->
                            <div class="card-body pt-10">

                                <input type="hidden" id="id">
                                <div class="row mb-5">
                                    <div class="col">
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Название</label>
                                                    <input id="name"
                                                           @if($client != null) value="{{$client->name}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="coordinator_id"
                                                       class="required form-label">Координатор</label>
                                                <select id="coordinator_id"
                                                        class="form-select form-select-sm form-select-solid"></select>
                                            </div>

                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="address"
                                                           class="required fs-5 fw-bold mb-2">Адрес</label>
                                                    <input id="address"
                                                           @if($client != null) value="{{$client->address}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <label for="industry_id" class="required form-label">Отрасль</label>
                                                <select id="industry_id" multiple="multiple"
                                                        class="form-select form-select-sm form-select-solid"></select>
                                            </div>
                                            <div class="col">
                                                <label for="work_place_id" class="required form-label">Место
                                                    работы</label>
                                                <select id="work_place_id" multiple="multiple"
                                                        class="form-select form-select-sm form-select-solid"></select>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <label for="nationality_id" class="required form-label">Национальность</label>
                                                <select id="nationality_id" multiple="multiple"
                                                        class="form-select form-select-sm form-select-solid"></select>
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col">
                                                <button id="save_vacancies" type="button"
                                                        class="btn btn-warning btn-sm">Сохранить
                                                </button>
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h3>Контакты</h3>
                                        <div class="contacts">
                                            @if($client != null)
                                                @foreach($client->contacts as $contact)
                                                    <div class="contact">
                                                        <div class="row mb-5">
                                                            <div class="col">
                                                                <div class="d-flex flex-column mb-0 fv-row">
                                                                    <label for="salary"
                                                                           class="required fs-5 fw-bold mb-2">Имя</label>
                                                                    <input
                                                                        value="{{$contact->firstName}}"
                                                                        class="form-control form-control-sm form-control-solid cfirstName"
                                                                        type="text"/>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="d-flex flex-column mb-0 fv-row">
                                                                    <label for="salary"
                                                                           class="required fs-5 fw-bold mb-2">Фамилия</label>
                                                                    <input
                                                                        value="{{$contact->lastName}}"
                                                                        class="form-control form-control-sm form-control-solid clastName"
                                                                        type="text"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col">
                                                                <div class="d-flex flex-column mb-0 fv-row">
                                                                    <label for="salary"
                                                                           class="required fs-5 fw-bold mb-2">Должность</label>
                                                                    <input
                                                                        value="{{$contact->position}}"
                                                                        class="form-control form-control-sm form-control-solid cposition"
                                                                        type="text"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col">
                                                                <div class="d-flex flex-column mb-0 fv-row">
                                                                    <label for="salary"
                                                                           class="required fs-5 fw-bold mb-2">Email</label>
                                                                    <input
                                                                        value="{{$contact->email}}"
                                                                        class="form-control form-control-sm form-control-solid cemail"
                                                                        type="text"/>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="d-flex flex-column mb-0 fv-row">
                                                                    <label for="salary"
                                                                           class="required fs-5 fw-bold mb-2">Телефон</label>
                                                                    <input
                                                                        value="{{$contact->phone}}"
                                                                        class="form-control form-control-sm form-control-solid cphone"
                                                                        type="text"/>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <button style="margin-top: 28px;" type="button"
                                                                        class="btn btn-light  btn-sm delete_contact">
                                                                    Удалить
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>


                                        <div class="row mb-5">
                                            <div class="col">
                                                <button id="add_contact" type="button"
                                                        class="btn btn-warning btn-sm">Добавить
                                                </button>
                                            </div>
                                            <div class="col">
                                            </div>
                                        </div>

                                        <div style="display:none;" id="template_add">
                                            <div class="contact">
                                                <div class="row mb-5">
                                                    <div class="col">
                                                        <div class="d-flex flex-column mb-0 fv-row">
                                                            <label for="salary"
                                                                   class="required fs-5 fw-bold mb-2">Имя</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid cfirstName"
                                                                type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="d-flex flex-column mb-0 fv-row">
                                                            <label for="salary"
                                                                   class="required fs-5 fw-bold mb-2">Фамилия</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid clastName"
                                                                type="text"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col">
                                                        <div class="d-flex flex-column mb-0 fv-row">
                                                            <label for="salary"
                                                                   class="required fs-5 fw-bold mb-2">Должность</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid cposition"
                                                                type="text"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-5">
                                                    <div class="col">
                                                        <div class="d-flex flex-column mb-0 fv-row">
                                                            <label for="salary"
                                                                   class="required fs-5 fw-bold mb-2">Email</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid cemail"
                                                                type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="d-flex flex-column mb-0 fv-row">
                                                            <label for="salary"
                                                                   class="required fs-5 fw-bold mb-2">Телефон</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid cphone"
                                                                type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <button style="margin-top: 28px;" type="button"
                                                                class="btn btn-light  btn-sm delete_contact">
                                                            Удалить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Post-->
            </div>
            <!--end::Content-->

            @include('includes.Footer')
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Root-->
<!--begin::Modal-->


@include('includes.global_scripts')
<script>
    $('#industry_id').select2({
        placeholder: 'Поиск отрасли',
        ajax: {
            url: "{{url('/')}}/search/client/industry",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    f_search: params.term,
                };
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function (index, item) {
                    results.push({
                        id: item.id,
                        text: item.value
                    });
                });
                return {
                    results: results
                };
            }
        },
    });
    $('#work_place_id').select2({
        placeholder: 'Место работы',
        ajax: {
            url: "{{url('/')}}/search/client/workplace",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    f_search: params.term,
                };
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function (index, item) {
                    results.push({
                        id: item.id,
                        text: item.value
                    });
                });
                return {
                    results: results
                };
            }
        },
    });
    $('#nationality_id').select2({
        placeholder: 'Национальность',
        ajax: {
            url: "{{url('/')}}/search/client/nationality",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    f_search: params.term,
                };
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function (index, item) {
                    results.push({
                        id: item.id,
                        text: item.value
                    });
                });
                return {
                    results: results
                };
            }
        },
    });
    $('#coordinator_id').select2({
        placeholder: 'Координатор',
        ajax: {
            url: "{{url('/')}}/search/client/coordinator",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    f_search: params.term,
                };
            },
            processResults: function (data) {
                var results = [];
                $.each(data, function (index, item) {
                    results.push({
                        id: item.id,
                        text: item.value
                    });
                });
                return {
                    results: results
                };
            }
        },
    });

    $('#add_contact').click(function () {
        let html = $('#template_add').html();
        $('.contacts').append(html);
    });

    $(document).on('click', '.delete_contact', function () {
        $(this).parent().parent().parent().remove();
    });

    $('#save_vacancies').click(function (e) {
        e.preventDefault();
        let self = $(this);
        self.prop('disabled', true);


        var data = {
            name: $('#name').val(),
            coordinator_id: $('#coordinator_id').val(),
            address: $('#address').val(),
            industry_id: $('#industry_id').val().join(','),
            work_place_id: $('#work_place_id').val().join(','),
            nationality_id: $('#nationality_id').val().join(','),
            _token: $('input[name=_token]').val(),
        };

        let id = $('#id').val();
        if (id !== '') {
            data.id = id;
        }

        let clients = [];
        $('.contacts .contact').each(function ( ) {
            let firstName = $(this).find('.cfirstName').val();
            let lastName = $(this).find('.clastName').val();
            let position = $(this).find('.cposition').val();
            let phone = $(this).find('.cphone').val();
            let email = $(this).find('.cemail').val();

            if(firstName == ''){
                toastr.error('Имя контакта обязательное поле!');
                self.prop('disabled', false);
                return '';
            }

            if(phone == ''){
                toastr.error('Телефон контакта обязательное поле!');
                self.prop('disabled', false);
                return '';
            }

            clients.push([
                firstName, lastName, position, phone, email
            ]);
        });

        if (clients.length === 0) {
            toastr.error('Добавте хоть один контакт!');
            self.prop('disabled', false);
            return '';
        }

        data.clients = JSON.stringify(clients);

        $.ajax({
            url: "{{route('clients.add')}}",
            method: 'post',
            data: data,
            success: function (response, status, xhr, $form) {
                if (response.error) {
                    toastr.error(response.error);
                } else {
                    location.href = '{{url('/')}}/clients';
                }
                self.prop('disabled', false);
            }
        });

    })


</script>
<script>
    @if(request()->has('id'))
    $('#id').val('{{request('id')}}');
    @endif

    @if($Coordinator != null)
    $('#coordinator_id').append(new Option('{{$Coordinator[1]}}', {{$Coordinator[0]}}, true, true)).trigger('change');
    @endif

    @if($h_v_industry != null)
    @foreach($h_v_industry as $industry)
    $('#industry_id').append(new Option('{{$industry[1]}}', {{$industry[0]}}, true, true)).trigger('change');
    @endforeach
    @endif

    @if($h_v_city != null)
    @foreach($h_v_city as $city)
    $('#work_place_id').append(new Option('{{$city[1]}}', {{$city[0]}}, true, true)).trigger('change');
    @endforeach
    @endif

    @if($h_v_nationality != null)
    @foreach($h_v_nationality as $nationality)
    $('#nationality_id').append(new Option('{{$nationality[1]}}', {{$nationality[0]}}, true, true)).trigger('change');
    @endforeach
    @endif


</script>


</body>
<!--end::Body-->
</html>
