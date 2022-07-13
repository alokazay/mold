<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>История изменения полей кандидатов</title>

    @include('includes.global_styles')
    <style>

        .sorting_disabled.sorting_asc:after {
            display: none !important;
        }

        .sorting_disabled.sorting_desc:after {
            display: none !important;
        }
        .table.gy-3 td, .table.gy-3 th {
            padding-top: 0.7rem;
            padding-bottom: 0.7rem;
        }
        td {
            line-height: 1;
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

                                <li class="breadcrumb-item text-dark">История изменения полей кандидатов</li>
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
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <div class="w-200px">
                                        <select id="filter__roles" class="form-select form-select form-select-solid">
                                            <option value=""></option>
                                            @foreach ($roles_ids as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body pt-0">


                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="mutated-fields">
                                        <!--begin::Table head-->
                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted fw-bolder fs-7 gs-0">
                                            <th class="max-w-55px sorting_disabled">Дата</th>
                                            <th class="max-w-85px sorting_disabled">Автор</th>
                                            <th class="max-w-55px sorting_disabled">Кандидат</th>
                                            {{-- <th class="max-w-55px sorting_disabled">Model Name</th>
                                            <th class="max-w-55px sorting_disabled">Model Id</th> --}}
                                            <th class="max-w-85px sorting_disabled">Поле</th>
                                            <th class="max-w-85px sorting_disabled">Изменения</th>
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
<script>


    var groupColumn = 0;
    oTable = $('#mutated-fields').DataTable({
        dom: 'rt<"bottom"p>',
        paginate: false,
        sor: false,
        searching: false,
        pagingType: "numbers",
        serverSide: true,
        pageLength: 20,
        language: {
            emptyTable: "нет данных",
            zeroRecords: "нет данных",
            sSearch: "Поиск"
        },
        aoColumnDefs: [{
            bSortable: false,
            aTargets: ['sorting_disabled']
        }],
        ajax: function (data, callback, settings) {
            data._token = $('input[name="_token"]').val();
            data.roles = $('#filter__roles').val();
            
            $.ajax({
                url: '{{ route("fields-mutation.json") }}',
                type: 'POST',
                data: data,
                success: function (res) {
                    if (res.error) {
                        toastr.error(res.error);
                    } else {
                        const data = !!res.data && res.data.map(item => {
                            return [
                                item.date_time,
                                item.author_data.firstName +' '+ item.author_data.lastName +', '+ item.author_role,
                                '<a href="/candidate/add?id='+ item.model_data.id +'">' + item.model_data.firstName +' '+ item.model_data.lastName + '</a>',
                                // item.model_name,
                                // item.model_obj_id,
                                (item.model_name == 'CandidateArrival' ? 'Логистика, ' : '') + item.field || item.field_name,
                                (item.prev_value ? item.prev_value : '') + ' -> ' + item.current_value,
                            ];
                        });

                        callback({
                            data,
                            recordsFiltered: data.length,
                            recordsTotal: data.length
                        });
                    }
                }
            });
        },
    });

    $('#filter__roles').select2({
        placeholder: 'Роли авторов',
        allowClear: true,
    }).on('select2:select', function (e) {
        oTable.draw();
    }).on('select2:clear', function (e) {
        oTable.draw();
    });
</script>

</body>
<!--end::Body-->
</html>
