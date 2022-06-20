<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>История запросов</title>

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

                                <li class="breadcrumb-item text-dark">История запросов</li>
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
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                                @if(Auth::user()->isFreelancer())
                                    <h3>Доступно <span id="current_balance">{{Auth::user()->balance}}</span></h3>
                                @endif
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                                    <div class="w-100 mw-150px">
                                        <select id="filter__status" class="form-select form-select-solid">
                                            <option value="">Все</option>
                                            <option value="1">В ожидании</option>
                                            <option value="2">Оплачен</option>
                                        </select>
                                    </div>
                                    <!--begin::Add product-->
                                    <a id="users__add_btn" href="javascript:;" class="btn btn-primary">Добавить</a>
                                    <!--end::Add product-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="users">
                                        <!--begin::Table head-->
                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted fw-bolder fs-7 gs-0">
                                            @if(Auth::user()->isFreelancer())
                                                <th class="max-w-55px sorting_disabled">Id</th>
                                                <th class="max-w-85px sorting_disabled">Дата запроса</th>
                                                <th class="max-w-85px sorting_disabled">Сумма</th>
                                                <th class="max-w-85px sorting_disabled">Дата оплаты</th>
                                                <th class="max-w-45px sorting_disabled">Статус</th>
                                                <th class=" sorting_disabled">Подтверждение</th>
                                            @else
                                                <th class="max-w-55px sorting_disabled">Id</th>
                                                <th class="max-w-85px sorting_disabled">Имя</th>
                                                <th class="max-w-85px sorting_disabled">Фамилия</th>
                                                <th class="max-w-85px sorting_disabled">Телефон</th>
                                                <th class="max-w-85px sorting_disabled">Счет-фактура</th>
                                                <th class="max-w-85px sorting_disabled">Дата запроса</th>
                                                <th class="max-w-85px sorting_disabled">Сумма</th>
                                                <th class="max-w-85px sorting_disabled">Фирма</th>
                                                <th class="max-w-45px sorting_disabled">Статус</th>
                                                <th class=" sorting_disabled">Документ</th>
                                            @endif
                                        </tr>
                                        <!--end::Table row-->
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold"></tbody>
                                        <!--end::Table body-->
                                    </table>
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


@include('includes.global_scripts')
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{url('/')}}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->

<div class="modal fade" tabindex="-1" id="modal_users_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Запрос</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal body-->
            <div class="modal-body">


                <div class="row mb-5">
                    <div class="col-6">
                        <div class="d-flex flex-column mb-0 fv-row">
                            <label class="required fs-5 fw-bold mb-2">Вариант вывода</label>
                            <select class="form-control form-control-sm form-control-solid"
                                    id="modal_users_add__type_request_id">
                                <option value="{{Auth::user()->account_type}}">{{Auth::user()->getPaymentFl()}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column   fv-row">
                            <label class="required fs-5 fw-bold mb-2">Сумма</label>
                            <input id="modal_users_add__amount"
                                   class="form-control form-control-sm form-control-solid" type="text"/>
                        </div>
                    </div>
                    @if(Auth::user()->isAccountant())
                        <div class="col-6 mt-5">
                            <div class="d-flex flex-column mb-0 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Фрилансер</label>
                                <input id="modal_users_add__user_id"
                                       class="form-control form-control-sm form-control-solid" type="text"/>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
            <!--end::Modal body-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Отмена</button>
                <button id="modal_users_add__save" type="button" class="btn btn-primary btn-sm">Сохранить
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    @if(Auth::user()->isAccountant())
    $('#modal_users_add__user_id').select2({
        placeholder: 'Поиск фрилансера',
        dropdownParent: $('#modal_users_add'),
        ajax: {
             url: "{{url('/')}}/search/requests/freelacnsers",
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
    @endif
    function changeStatus(id) {
        var changeActivation = $('.changeStatus' + id).val();
        $.get('{{url('/')}}/requests/change/status?s=' + changeActivation + '&id=' + id, function (res) {
            if (res.error) {
                toastr.error(res.error);
            } else {
                toastr.success('Успешно');
            }
            oTable.draw();
        });
    }

    function changeFirm(id) {
        var changeActivation = $('.changeFirm' + id).val();
        $.get('{{url('/')}}/requests/change/firm?s=' + changeActivation + '&id=' + id, function (res) {
            if (res.error) {
                toastr.error(res.error);
            } else {
                toastr.success('Успешно');
            }
            oTable.draw();
        });
    }

    var groupColumn = 0;
    oTable = $('#users').DataTable({
        "dom": 'rt<"bottom"p>',
        paginate: true,
        "sor": false,
        "searching": false,
        "pagingType": "numbers",
        "serverSide": true,
        pageLength: 20,
        "language": {
            "emptyTable": "нет данных",
            "zeroRecords": "нет данных",
            'sSearch': "Поиск"
        },
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['sorting_disabled']
        }],
        ajax: function (data, callback, settings) {
            data._token = $('input[name=_token]').val();
            data.status = $('#filter__status').val().trim();
            $.ajax({
                url: '{{ route('finance.json') }}',
                type: 'POST',
                data: data,
                success: function (data) {
                    if (data.error) {
                        toastr.error(data.error);
                    } else {
                        callback(data);
                    }
                }
            });
        },
        drawCallback: function () {
            reInitDropzone();
        }
    });

    $('#f__search').keyup(function () {
        oTable.draw();
    });
    $('#filter__status').change(function () {
        oTable.draw();
    });


    $('#users__add_btn').click(function () {
        $('#modal_users_add__amount').val('');
        $('#modal_users_add').modal('show');
    });

    $('#modal_users_add__save').click(function (e) {
        e.preventDefault();
        let self = $(this);

        self.prop('disabled', true);

        var data = {
            amount: $('#modal_users_add__amount').val(),
            type_request_id: $('#modal_users_add__type_request_id').val(),
            user_id: $('#modal_users_add__user_id').val(), // only buh
            _token: $('input[name=_token]').val(),
        };


        $.ajax({
            url: "{{route('finance.add')}}",
            method: 'post',
            data: data,
            success: function (response) {
                if (response.error) {
                    toastr.error(response.error);
                } else {
                    $('#modal_users_add').modal('hide');
                    $('#current_balance').html(response.amount);
                    oTable.draw();
                }
                self.prop('disabled', false);
            }
        });
    });


    function reInitDropzone() {
        $('.add_file').each(function () {

            let id = $(this).data('id');
            new Dropzone('#' + $(this).attr('id'), {
                url: "{{url('/')}}/requests/file/add", // Set the url for your upload script location
                paramName: "file",
                maxFiles: 1,
                maxFilesize: 10, // MB
                addRemoveLinks: true,
                sending: function (file, xhr, formData) {
                    formData.append('_token', $('input[name=_token]').val());
                    formData.append('id', id);
                },
                success: function (file, done) {
                    oTable.draw();
                },
                accept: function (file, done) {
                    done();
                }
            });
        });
    }


</script>

</body>
<!--end::Body-->
</html>
