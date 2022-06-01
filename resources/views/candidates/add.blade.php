<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Добавить кандидата</title>

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

                                <li class="breadcrumb-item text-dark">Добавить кандидата</li>
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

                            <div class="card-body pt-15">

                                <input type="hidden" id="id">
                                <input type="hidden" id="r_id">
                                <div class="row">
                                    <div class="col">
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Фамилия</label>
                                                    <input
                                                        @if($canddaite != null) value="{{$canddaite->lastName}}" @endif
                                                    id="lastName"
                                                        class="form-control form-control-sm form-control-solid"
                                                        type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Имя</label>
                                                    <input
                                                        @if($canddaite != null) value="{{$canddaite->firstName}}" @endif
                                                    id="firstName"
                                                        class="form-control form-control-sm form-control-solid"
                                                        type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">Дата рождения</label>
                                                    <input
                                                        @if($canddaite != null) value="{{\Carbon\Carbon::parse($canddaite->dateOfBirth)->format('d.m.Y')}}"
                                                        @endif
                                                        id="dateOfBirth"
                                                        class="form-control form-control-sm form-control-solid"
                                                        type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Телефон</label>
                                                    <input
                                                        @if($canddaite != null) value="{{$canddaite->phone}}" @endif
                                                    id="phone"
                                                        class="form-control form-control-sm form-control-solid"
                                                        type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Номер Viber</label>
                                                    <input id="viber"
                                                           @if($canddaite != null) value="{{$canddaite->viber}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Дополнительный
                                                        контакт</label>
                                                    <input
                                                        @if($canddaite != null) value="{{$canddaite->phone_parent}}"
                                                        @endif
                                                        id="phone_parent"
                                                        class="form-control form-control-sm form-control-solid"
                                                        type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">Гражданство</label>
                                                    <select
                                                        id="citizenship_id"
                                                        class="form-select  form-select-sm form-select-solid"> </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">Страна прибывания</label>
                                                    <select id="country_id"
                                                            class="form-select  form-select-sm form-select-solid"> </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">Планируемая дата
                                                        приезда</label>
                                                    <input id="date_arrive"
                                                           @if($canddaite != null) value="{{\Carbon\Carbon::parse($canddaite->date_arrive)->format('d.m.Y')}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">Документ</label>
                                                    <select id="type_doc_id"
                                                            class="form-select  form-select-sm form-select-solid"> </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">Транспортные
                                                        расходы</label>
                                                    <select id="transport_id"
                                                            class="form-select  form-select-sm form-select-solid"> </select>

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">ИНН</label>
                                                    <input id="inn"
                                                           @if($canddaite != null) value="{{$canddaite->inn}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="kt_file_doc">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick">
                                                            <!--begin::Icon-->
                                                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                            <!--end::Icon-->

                                                            <!--begin::Info-->
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
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class=" fs-5 fw-bold mb-2">Комментарий</label>
                                                    <textarea id="comment"
                                                              class="form-control form-control-sm form-control-solid"
                                                              cols="30"
                                                              rows="10"> @if($canddaite != null){{$canddaite->comment}}@endif</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col">

                                        <div class="col-6">
                                            <div class="d-flex flex-column mb-0 fv-row">
                                                <label class="fs-5 fw-bold mb-2">Рекрутер</label>

                                                <select id="recruiter_id"
                                                        class="form-select  form-select-sm form-select-solid"> </select>
                                            </div>
                                        </div>

                                        @if(Auth::user()->group_id == 4 || Auth::user()->group_id == 1)
                                            <h3 class="mb-5">Логист</h3>
                                            <div class="row mb-5">
                                                <div class="col-6">
                                                    <div class="d-flex flex-column mb-0 fv-row">
                                                        <label class="fs-5 fw-bold mb-2">Дата и время
                                                            приезда</label>
                                                        <input
                                                            @if($canddaite != null) value="{{\Carbon\Carbon::parse($canddaite->logist_date_arrive)->format('d.m.Y H:i')}}"
                                                            @endif
                                                            id="logist_date_arrive"
                                                            class="form-control form-control-sm form-control-solid"
                                                            type="text"/>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-6">
                                                    <div class="d-flex flex-column mb-0 fv-row">
                                                        <label class="fs-5 fw-bold mb-2">Место приезда</label>
                                                        <select id="logist_place_arrive_id"
                                                                class="form-select  form-select-sm form-select-solid"> </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-5">
                                                <div class="col">
                                                    <div class="d-flex flex-column mb-0 fv-row">
                                                        <!--begin::Dropzone-->
                                                        <div class="dropzone" id="kt_file_ticket">
                                                            <!--begin::Message-->
                                                            <div class="dz-message needsclick">
                                                                <!--begin::Icon-->
                                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                <!--end::Icon-->

                                                                <!--begin::Info-->
                                                                <div class="ms-4">
                                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">
                                                                        Загрузить билет</h3>
                                                                    <span class="fs-7 fw-bold text-gray-400">Перетащите документ сюда</span>
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                        </div>
                                                        <!--end::Dropzone-->
                                                    </div>
                                                </div>
                                            </div>
                                        @endif



                                        <h3 class="mb-5">Трудоустройство</h3>
                                        <div class="row mb-5">
                                            <div class="col-6">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">Вакансия по
                                                        факту</label>

                                                    <select id="real_vacancy_id"
                                                            class="form-select  form-select-sm form-select-solid"> </select>
                                                </div>
                                            </div>
                                            @if(Auth::user()->group_id == 5 || Auth::user()->group_id == 1)
                                                <div class="col-6">
                                                    <div class="d-flex flex-column mb-0 fv-row">
                                                        <label class="fs-5 fw-bold mb-2">Статус
                                                            трудоустройства</label>
                                                        <select id="real_status_work_id"
                                                                class="form-select  form-select-sm form-select-solid"> </select>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <button id="modal_users_add__save" type="button" class="btn btn-primary btn-sm">
                                    Сохранить
                                </button>

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


@include('includes.global_scripts')
<script>

    $('#modal_users_add__save').click(function (e) {
        e.preventDefault();


        let self = $(this);
        self.prop('disabled', true);

        var data = {
            lastName: $('#lastName').val(),
            firstName: $('#firstName').val(),
            dateOfBirth: $('#dateOfBirth').val(),
            phone: $('#phone').val(),
            viber: $('#viber').val(),
            phone_parent: $('#phone_parent').val(),
            citizenship_id: $('#citizenship_id').val(),
            country_id: $('#country_id').val(),
            date_arrive: $('#date_arrive').val(),
            type_doc_id: $('#type_doc_id').val(),
            transport_id: $('#transport_id').val(),
            inn: $('#inn').val(),
            comment: $('#comment').val(),
            logist_date_arrive: $('#logist_date_arrive').val(),
            logist_place_arrive_id: $('#logist_place_arrive_id').val(),
            real_vacancy_id: $('#real_vacancy_id').val(),
            real_status_work_id: $('#real_status_work_id').val(),
            recruiter_id: $('#recruiter_id').val(),
            _token: $('input[name=_token]').val(),
        };

        let id = $('#id').val();
        if (id !== '') {
            data.id = id;
        }

        $.ajax({
            url: "{{route('candidate.add')}}",
            method: 'post',
            data: data,
            success: function (response, status, xhr, $form) {
                if (response.error) {
                    toastr.error(response.error);
                } else {
                    location.href = '{{url('/')}}/candidates';
                }
                self.prop('disabled', false);
            }
        });
    });


    $('#dateOfBirth').flatpickr({
        dateFormat: 'd.m.Y',
        locale: {
            firstDayOfWeek: 1
        },
    });
    $('#date_arrive').flatpickr({
        dateFormat: 'd.m.Y',
        locale: {
            firstDayOfWeek: 1
        },
    });
    $('#logist_date_arrive').flatpickr({
        dateFormat: 'd.m.Y H:i',
        enableTime: true,
        locale: {
            firstDayOfWeek: 2
        },
    });


    $('#citizenship_id').select2({
        placeholder: 'Поиск гражданства',
        ajax: {
            url: "{{url('/')}}/search/candidate/citizenship",
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
    $('#country_id').select2({
        placeholder: 'Поиск страны',
        ajax: {
            url: "{{url('/')}}/search/candidate/country",
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
    $('#type_doc_id').select2({
        placeholder: 'Поиск документа',
        ajax: {
            url: "{{url('/')}}/search/candidate/typedocs",
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
    $('#logist_place_arrive_id').select2({
        placeholder: 'Поиск места прибытия',
        ajax: {
            url: "{{url('/')}}/search/candidate/placearrive",
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
    $('#real_vacancy_id').select2({
        placeholder: 'Вакансия по факту',
        ajax: {
            url: "{{url('/')}}/search/candidate/vacancy",
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
    $('#recruiter_id').select2({
        placeholder: 'Рекрутер',
        ajax: {
            url: "{{url('/')}}/search/candidate/recruter",
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
    $('#real_status_work_id').select2({
        placeholder: 'трудоустройство',
        ajax: {
            url: "{{url('/')}}/search/candidate/realstatuswork",
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
    $('#transport_id').select2({
        placeholder: 'Транспортные расходы',
        ajax: {
            url: "{{url('/')}}/search/candidate/transport",
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

    @if(request()->has('id'))
    $('#id').val('{{request('id')}}');
    @endif



    @if($canddaite != null && $canddaite->Vacancy != null)
    $('#real_vacancy_id').append(new Option('{{ $canddaite->Vacancy->title }}', {{ $canddaite->Vacancy->id }}, true, true)).trigger('change');
    @endif


    @if($vacancy != null)
    $('#real_vacancy_id').append(new Option('{{ $vacancy->title }}', {{ $vacancy->id }}, true, true)).trigger('change');
    @endif

    @if($recruter != null)
    $('#recruiter_id').append(new Option('{{ $recruter->firstName }} {{ $recruter->lastName }}', {{ $recruter->id }}, true, true)).trigger('change');
    @endif




    @if($canddaite != null && $canddaite->Citizenship != null)
    $('#citizenship_id').append(new Option('{{ $canddaite->Citizenship->name }}', {{ $canddaite->Citizenship->id }}, true, true)).trigger('change');
    @endif
    @if($canddaite != null && $canddaite->Country != null)
    $('#country_id').append(new Option('{{ $canddaite->Country->name }}', {{ $canddaite->Country->id }}, true, true)).trigger('change');
    @endif
    @if($canddaite != null && $canddaite->Type_doc != null)
    $('#type_doc_id').append(new Option('{{ $canddaite->Type_doc->name }}', {{ $canddaite->Type_doc->id }}, true, true)).trigger('change');
    @endif
    @if($canddaite != null && $canddaite->Logist_place_arrive != null)
    $('#logist_place_arrive_id').append(new Option('{{ $canddaite->Logist_place_arrive->name }}', {{ $canddaite->Logist_place_arrive->id }}, true, true)).trigger('change');
    @endif
    @if($canddaite != null && $canddaite->Real_status_work != null)
    $('#real_status_work_id').append(new Option('{{ $canddaite->Real_status_work->name }}', {{ $canddaite->Real_status_work->id }}, true, true)).trigger('change');
    @endif
    @if($canddaite != null && $canddaite->Transport != null)
    $('#transport_id').append(new Option('{{ $canddaite->Transport->name }}', {{ $canddaite->Transport->id }}, true, true)).trigger('change');
    @endif

    var myDropzoneD = new Dropzone("#kt_file_ticket", {
        url: "{{url('/')}}/candidate/files/ticket/add", // Set the url for your upload script location
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        sending: function (file, xhr, formData) {
            formData.append('_token', $('input[name=_token]').val());
            formData.append('id', $('#id').val());
        },
        success: function (file, done) {
            $('#id').val(done.id);
        },
        accept: function (file, done) {
            done();
        }
    });

    var myDropzoneT = new Dropzone("#kt_file_doc", {
        url: "{{url('/')}}/candidate/files/doc/add", // Set the url for your upload script location
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        sending: function (file, xhr, formData) {
            formData.append('_token', $('input[name=_token]').val());
            formData.append('id', $('#id').val());
        },
        success: function (file, done) {
            $('#id').val(done.id);
        },
        accept: function (file, done) {
            done();
        }
    });

</script>
</body>
<!--end::Body-->
</html>
