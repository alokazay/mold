<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Задачи</title>

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

                                <li class="breadcrumb-item text-dark">Задачи</li>
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
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                              height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                              fill="currentColor"></rect>
														<path
                                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                            fill="currentColor"></path>
													</svg>
												</span>
                                        <!--end::Svg Icon-->
                                        <input type="text"
                                               class="form-control form-control-solid w-250px ps-14"
                                               id="f__search"
                                               placeholder="Поиск ">
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                                    <div class="w-200px">
                                        <select id="filter__period" class="form-select form-select form-select-solid">
                                            <option value=""></option>
                                            <option value="today" selected>Сегодня</option>
                                            <option value="yesterday">Вчера</option>
                                            <option value="lastWeek">7 дней</option>
                                            <option value="lastMonth">30 дней</option>
                                        </select>
                                    </div>

                                    <div class="w-100 mw-150px">
                                        <!--begin::Select2-->
                                        <select id="filter__status" class="form-select form-select-solid">
                                            <option value="">Статус</option>
                                            <option value="1">К выполнению</option>
                                            <option value="2">Выполнено</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>

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
                                            <th class="max-w-55px sorting_disabled">Id</th>
                                            <th class="max-w-85px">Дата</th>
                                            <th class="max-w-85px sorting_disabled">Заголовок</th>
                                            <th class="min-w-125px sorting_disabled">Автор</th>
                                            <th class="max-w-65px sorting_disabled">Кандидат</th>
                                            <th class="min-w-100px sorting_disabled">Статус</th>
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

<div class="modal fade" tabindex="-1" id="modal_users_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Задача</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal body-->
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-3" >`
                        <tbody class="text-gray-600 fw-bold">
                        <tr>
                            <td>Кандидат</td>
                            <td id="modal_users_add__Candidate"></td>
                        </tr>
                        <tr>
                            <td>Автор</td>
                            <td id="modal_users_add__Autor"></td>
                        </tr>
                        <tr>
                            <td>Статус</td>
                            <td id="modal_users_add__status"></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="modal_users_add__title"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.global_scripts')

<script src="{{url('/')}}/assets/plugins/custom/datatables/datatables.bundle.js"></script>

<script>



    var groupColumn = 0;
    oTable = $('#users').DataTable({
        dom: 'rt<"bottom"p>',
        paginate: true,
        searching: false,
        pagingType: "numbers",
        serverSide: true,
        pageLength: 20,
        order: [[1, 'desc']],
        language: {
            "emptyTable": "нет данных",
            "zeroRecords": "нет данных",
            'sSearch': "Поиск"
        },
        aoColumnDefs: [{
            'bSortable': false,
            'aTargets': ['sorting_disabled']
        }],
        ajax: function (data, callback, settings) {
            data._token = $('input[name=_token]').val();
            data.search = $('#f__search').val().trim();
            data.status = $('#filter__status').val().trim();
            data.period = $('#filter__period').val();

            $.ajax({
                url: '{{ route('tasks.json') }}',
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

    });

    $('#f__search').keyup(function () {
        oTable.draw();
    });
    $('#filter__status').change(function () {
        oTable.draw();
    });
    $('#filter__group').change(function () {
        oTable.draw();
    });
    
    $('#filter__period').select2({
        placeholder: 'Период',
        allowClear: true,
        minimumResultsForSearch: -1
    }).on('select2:select', function (e) {
        oTable.draw();
    }).on('select2:clear', function (e) {
        oTable.draw();
    });


    function editTask(id) {

        $.get('{{url('/')}}/tasks/ajax/id/' + id, function (res) {
            $('#modal_users_add__id').val(id);
            $('#modal_users_add__Candidate').html(res.task.Candidate);
            $('#modal_users_add__Autor').html(res.task.Autor);
            $('#modal_users_add__title').html(res.task.title);
            $('#modal_users_add__status').html(res.task.status);


            $('#modal_users_add').modal('show');
        });
    }

    function changeActivation(id) {
        var changeActivation = $('.changeActivation' + id).val();
        $.get('{{url('/')}}/tasks/activation?s=' + changeActivation + '&id=' + id, function (res) {
            if (res.error) {
                toastr.error(res.error);
            } else {
                toastr.success('Успешно');
            }
        });
    }

</script>

</body>
<!--end::Body-->
</html>
