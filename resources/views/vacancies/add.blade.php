<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Вакансии</title>

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
                                    <a href="{{url('/')}}/vacancies" class="text-muted text-hover-primary">Вакансии</a>
                                </li>

                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                </li>


                                <li class="breadcrumb-item text-dark">Добавить вакансию</li>
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
                                                    <input id="title"
                                                           @if($vacancy != null) value="{{$vacancy->title}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Описание вакансии</label>
                                                    <div style="overflow: auto;height: 200px;"
                                                         id="description"
                                                         class="mb-2"> @if($vacancy != null){!! $vacancy->description !!}@endif</div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <label for="client_id" class="required form-label">Клиент</label>
                                                <select id="client_id" multiple="multiple"
                                                        class="form-select form-select-sm form-select-solid"></select>
                                            </div>
                                            <div class="col">
                                                <label for="industry_id" class="required form-label">Отрасль</label>
                                                <select id="industry_id" multiple="multiple"
                                                        class="form-select form-select-sm form-select-solid"></select>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <label for="nationality_id"
                                                       class="required form-label">Национальность</label>
                                                <select id="nationality_id" multiple="multiple"
                                                        class="form-select  form-select-sm form-select-solid"> </select>
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
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="deadline_from" class="required fs-5 fw-bold mb-2">Дедлайн,
                                                        от</label>
                                                    <input id="deadline_from"
                                                           @if($vacancy != null) value="{{\Carbon\Carbon::parse($vacancy->deadline_from)->format('d.m.Y')}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="deadline_to" class="required fs-5 fw-bold mb-2">Дедлайн,
                                                        до</label>
                                                    <input id="deadline_to"
                                                           @if($vacancy != null) value="{{\Carbon\Carbon::parse($vacancy->deadline_to)->format('d.m.Y')}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="count_men" class="required fs-5 fw-bold mb-2">Мужчины,
                                                        кол-во</label>
                                                    <input id="count_men"
                                                           @if($vacancy != null) value="{{$vacancy->count_men}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="count_women" class="required fs-5 fw-bold mb-2">Женщины,
                                                        кол-во</label>
                                                    <input id="count_women"
                                                           @if($vacancy != null) value="{{$vacancy->count_women}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="count_people" class="required fs-5 fw-bold mb-2">Не
                                                        важно, кол-во</label>
                                                    <input id="count_people"
                                                           @if($vacancy != null) value="{{$vacancy->count_people}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">


                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="salary" class="required fs-5 fw-bold mb-2">Ставка,
                                                        зл/ч</label>
                                                    <input id="salary"
                                                           @if($vacancy != null) value="{{$vacancy->salary}}" @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="salary_description" class="required fs-5 fw-bold mb-2">Описание
                                                        ставки</label>
                                                    <input id="salary_description"
                                                           @if($vacancy != null) value="{{$vacancy->salary_description}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="count_hours" class="required fs-5 fw-bold mb-2">Кол-во
                                                        часов</label>
                                                    <input id="count_hours"
                                                           @if($vacancy != null) value="{{$vacancy->count_hours}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="doc_id" class="required form-label">Тип договора</label>
                                                <select id="doc_id"
                                                        class="form-select  form-select-sm form-select-solid"></select>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="housing_cost" class="required fs-5 fw-bold mb-2">Жилье,
                                                        стоимость</label>
                                                    <input id="housing_cost"
                                                           @if($vacancy != null) value="{{$vacancy->housing_cost}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label for="housing_people" class="required fs-5 fw-bold mb-2">Кол-во
                                                        людей в комнате</label>
                                                    <input id="housing_people"
                                                           @if($vacancy != null) value="{{$vacancy->housing_people}}"
                                                           @endif
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <div class="d-flex flex-column mb-0 fv-row">
                                                    <label class="required fs-5 fw-bold mb-2">Описание жилья</label>
                                                    <div style="overflow: auto;height: 200px;"
                                                         id="housing_description"
                                                         class="mb-2"> @if($vacancy != null){!! $vacancy->housing_description !!}@endif</div>


                                                </div>
                                            </div>
                                        </div>
                                        @if(!Auth::user()->isRecruter())
                                            <div class="row mb-5">
                                                <div class="col">
                                                    <div class="d-flex flex-column mb-0 fv-row">
                                                        <label for="recruting_cost" class="required fs-5 fw-bold mb-2">Стоимость
                                                            рекрутирования, zł</label>
                                                        <input id="recruting_cost"
                                                               @if($vacancy != null) value="{{$vacancy->recruting_cost}}"
                                                               @endif
                                                               class="form-control form-control-sm form-control-solid"
                                                               type="text"/>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="d-flex flex-column mb-0 fv-row">
                                                        <label for="cost_pay_lead" class="required fs-5 fw-bold mb-2">Стоимость
                                                            лида, zł</label>
                                                        <input id="cost_pay_lead"
                                                               @if($vacancy != null) value="{{$vacancy->cost_pay_lead}}"
                                                               @endif
                                                               class="form-control form-control-sm form-control-solid"
                                                               type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(Auth::user()->isAdmin())
                                            <div class="row mb-5">
                                                <div class="col">
                                                    <button id="save_vacancies" type="button"
                                                            class="btn btn-warning btn-sm">Сохранить
                                                    </button>
                                                </div>
                                                <div class="col">
                                                </div>
                                            </div>
                                        @endif
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
<script src="{{url('/')}}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://unpkg.com/quill-image-uploader@1.2.1/dist/quill.imageUploader.min.js"></script>
<script>
    $('#vacancy__add_btn').click(function () {
        $('#modal_vacancies_add').modal('show');
    });
    Quill.register("modules/imageUploader", ImageUploader);
    let description = new Quill('#description', {

        modules: {


            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline'],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                ['link']
            ],

            imageUploader: {
                upload: file => {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append("file", file);
                        formData.append("vacancy_id", $('#id').val());
                        formData.append('_token', $('input[name=_token]').val());

                        fetch(
                            "{{url('/')}}/files/add",
                            {
                                method: "POST",
                                body: formData
                            }
                        )
                            .then(response => response.json())
                            .then((result) => {
                                $('#id').val(result.vacancy_id);
                                resolve(result.path);
                            })
                            .catch(error => {
                                reject("Upload failed");
                            });
                    });
                }
            }
        },
        placeholder: 'Описание',
        theme: 'snow' // or 'bubble'
    });
    let housing_description = new Quill('#housing_description', {

        modules: {


            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline'],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                ['link']
            ],

            imageUploader: {
                upload: file => {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append("file", file);
                        formData.append("vacancy_id", $('#id').val());
                        formData.append('_token', $('input[name=_token]').val());

                        fetch(
                            "{{url('/')}}/files/add",
                            {
                                method: "POST",
                                body: formData
                            }
                        )
                            .then(response => response.json())
                            .then((result) => {
                                $('#id').val(result.vacancy_id);
                                resolve(result.path);
                            })
                            .catch(error => {
                                reject("Upload failed");
                            });
                    });
                }
            }
        },
        placeholder: 'Описание',
        theme: 'snow' // or 'bubble'
    });


    $('#client_id').select2({
        placeholder: 'Поиск клиента',
        ajax: {
            url: "{{url('/')}}/search/vacancy/client",
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
    }).on('select2:select', function (e) {
        var data = e.params.data;
        $('#industry_id').val('').trigger('change');
    });
    $('#industry_id').select2({
        placeholder: 'Поиск отрасли',
        ajax: {
            url: "{{url('/')}}/search/vacancy/industry",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    client_id: $('#client_id').val().join(','),
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
        placeholder: 'Поиск национальности',
        ajax: {
            url: "{{url('/')}}/search/vacancy/nationality",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    client_id: $('#client_id').val().join(','),
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
            url: "{{url('/')}}/search/vacancy/workplace",
            dataType: 'json',
            // delay: 250,
            data: function (params) {
                return {
                    s: '{{request('s')}}',
                    client_id: $('#client_id').val().join(','),
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
    $('#doc_id').select2({
        placeholder: 'Тип договора',
        ajax: {
            url: "{{url('/')}}/search/vacancy/docs",
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


    $('#deadline_from').flatpickr({
        dateFormat: 'd.m.Y',
        locale: {
            firstDayOfWeek: 1
        },
    });
    $('#deadline_to').flatpickr({
        dateFormat: 'd.m.Y',
        locale: {
            firstDayOfWeek: 1
        },
    });

    $('#save_vacancies').click(function (e) {
        e.preventDefault();


        let self = $(this);
        self.prop('disabled', true);

        var data = {
            title: $('#title').val(),
            description: description.root.innerHTML,
            deadline_from: $('#deadline_from').val(),
            deadline_to: $('#deadline_to').val(),
            count_men: $('#count_men').val(),
            count_women: $('#count_women').val(),
            count_people: $('#count_people').val(),
            salary: $('#salary').val(),
            salary_description: $('#salary_description').val(),
            count_hours: $('#count_hours').val(),
            doc_id: $('#doc_id').val(),
            housing_cost: $('#housing_cost').val(),
            housing_people: $('#housing_people').val(),
            housing_description: housing_description.root.innerHTML,
            recruting_cost: $('#recruting_cost').val(),
            cost_pay_lead: $('#cost_pay_lead').val(),
            client_id: $('#client_id').val().join(','),
            industry_id: $('#industry_id').val().join(','),
            nationality_id: $('#nationality_id').val().join(','),
            work_place_id: $('#work_place_id').val().join(','),
            _token: $('input[name=_token]').val(),
        };

        if (data.count_men == '' && data.count_women == '' && data.count_people == '') {
            toastr.error('Кол-во мужчин или женщин пусто');
            self.prop('disabled', false);
            return '';
        }

        let id = $('#id').val();
        if (id !== '') {
            data.id = id;
        }

        $.ajax({
            url: "{{route('vacancy.add')}}",
            method: 'post',
            data: data,
            success: function (response, status, xhr, $form) {
                if (response.error) {
                    toastr.error(response.error);
                } else {
                    location.href = '{{url('/')}}/vacancies';
                }
                self.prop('disabled', false);
            }
        });
    });


</script>
<script>
    @if(request()->has('id'))
    $('#id').val('{{request('id')}}');
    @endif


    @if($Doc != null)
    $('#doc_id').append(new Option('{{$Doc[1]}}', {{$Doc[0]}}, true, true)).trigger('change');
    @endif


    @if($h_v_industry != null)
    @foreach($h_v_industry as $industry)
    $('#industry_id').append(new Option('{{$industry[1]}}', {{$industry[0]}}, true, true)).trigger('change');
    @endforeach
    @endif

    @if($h_v_nacionality != null)
    @foreach($h_v_nacionality as $industry)
    $('#nationality_id').append(new Option('{{$industry[1]}}', {{$industry[0]}}, true, true)).trigger('change');
    @endforeach
    @endif

    @if($h_v_city != null)
    @foreach($h_v_city as $industry)
    $('#work_place_id').append(new Option('{{$industry[1]}}', {{$industry[0]}}, true, true)).trigger('change');
    @endforeach
    @endif

    @if($Clients != null)
    @foreach($Clients as $industry)
    $('#client_id').append(new Option('{{$industry[1]}}', {{$industry[0]}}, true, true)).trigger('change');
    @endforeach
    @endif


</script>


</body>
<!--end::Body-->
</html>
