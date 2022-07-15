<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Просмотр кандидата {{$canddaite->lastName}} {{$canddaite->firstName}}</title>

    @include('includes.global_styles')


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
                    <div id="kt_content_container" class="container-xxl">
                        <!--begin::Navbar-->
                        <div class="card mb-5 mb-xxl-8">
                            <div class="card-body pt-9 pb-0">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap flex-sm-nowrap">

                                    <!--begin::Info-->
                                    <div class="flex-grow-1">
                                        <!--begin::Title-->
                                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                            <!--begin::User-->
                                            <div class="d-flex flex-column">
                                                <!--begin::Name-->
                                                <div class="d-flex align-items-center ">
                                                    <span href="#"
                                                          class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1 text-uppercase">
                                                        {{$canddaite->lastName}} {{$canddaite->firstName}}</span>
                                                </div>
                                                <div class=" mb-2">
                                                    {{$canddaite->getStatus()}}
                                                </div>
                                                <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                                    <a href="#"
                                                       class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-phone-alt"></i></span>телефон: {{$canddaite->phone}}
                                                    </a>
                                                    @if($canddaite->viber != '')
                                                        <a href="#"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-phone-alt"></i></span> viber: {{$canddaite->viber}}
                                                        </a>
                                                    @endif
                                                    @if($canddaite->phone_parent != '')
                                                        <a href="#"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fas fa-phone-alt"></i></span>доп телефон {{$canddaite->phone_parent}}
                                                        </a>
                                                    @endif

                                                </div>
                                                <!--end::Info-->

                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2 view_doc">

                                                    @if($canddaite->getPasportLink() != '')
                                                        <a href="#" data-href="{{$canddaite->getPasportLink()}}"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-passport"></i></span> Паспорт(ID card)
                                                        </a>
                                                    @endif

                                                    @if($canddaite->getKartapobytu() != '')
                                                        <a  href="#" data-href="{{$canddaite->getKartapobytu()}}"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-file-contract"></i></span> Карта по
                                                            быту(вместе с
                                                            децизией)
                                                        </a>
                                                    @endif
                                                    @if($canddaite->getDriverLicense() != '')
                                                        <a  href="#" data-href="{{$canddaite->getDriverLicense()}}"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-id-card"></i></span> Водительское
                                                            удостоверение
                                                        </a>
                                                    @endif

                                                    @if($canddaite->getDiplom() != '')
                                                        <a  href="#" data-href="{{$canddaite->getDiplom()}}"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-certificate"></i></span> Диплом(сертификаты)
                                                        </a>
                                                    @endif

                                                    @if($canddaite->getLegitim() != '')
                                                        <a  href="#" data-href="{{$canddaite->getLegitim()}}"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-scroll"></i></span> Легитимация из Универа
                                                        </a>
                                                    @endif

                                                    @if($canddaite->getElsefile() != '')
                                                        <a  href="#" data-href="{{$canddaite->getElsefile()}}"
                                                           class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                        <span class="svg-icon svg-icon-4 me-1">
                                                            <i class="fa fa-file"></i></span> Прочий документ
                                                        </a>
                                                    @endif


                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Title-->

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Общее</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">История</a>
                                    </li>

                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

                                            <div class="card-header cursor-pointer">

                                                <div class="card-title m-0">
                                                    <h3 class="fw-bolder m-0">Детали</h3>
                                                </div>

                                                <a href="{{url('/')}}/candidate/add?id={{$canddaite->id}}"
                                                   class="btn btn-primary btn-sm align-self-center">Edit Profile</a>

                                            </div>

                                            <div class="card-body p-9 pb-0">

                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Дата рождения</label>
                                                    <div class="col-lg-8">
                                                        <span
                                                            class="fw-bolder fs-6 text-gray-800">{{\Carbon\Carbon::parse($canddaite->dateOfBirth)->format('d.m.Y')}}</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Гражданство</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Citizenship != null)
                                                                {{ $canddaite->Citizenship->name }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Национальность</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Nacionality != null)
                                                                {{ $canddaite->Nacionality->name }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Страна прибывания</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Country != null)
                                                                {{ $canddaite->Country->name }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Планируемая дата
                                                        приезда</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->date_arrive != null)
                                                            {{\Carbon\Carbon::parse($canddaite->date_arrive)->format('d.m.Y')}}
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Документ</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Type_doc != null)
                                                                {{ $canddaite->Type_doc->name }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                @if(Auth::user()->isAdmin() )

                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 fw-bold text-muted">Рекрутер</label>
                                                        <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($recruter != null)
                                                                {{ $recruter->firstName }} {{ $recruter->lastName }}
                                                            @endif
                                                        </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">ИНН</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                      {{$canddaite->inn}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Вакансия</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Vacancy != null)
                                                                {{ $canddaite->Vacancy->title }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-lg-4 fw-bold text-muted">Комментарий</label>
                                                    <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                      {{$canddaite->comment}}
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>


                                            @if(Auth::user()->isLogist() || Auth::user()->isAdmin())
                                                <div class="card-header cursor-pointer">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bolder m-0">Логист</h3>
                                                    </div>
                                                </div>

                                                <div class="card-body p-9 pb-0">
                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-3"
                                                               id="users">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-muted fw-bolder fs-7 gs-0">

                                                                <th class="max-w-55px sorting_disabled">Id</th>
                                                                <th class="max-w-85px sorting_disabled">Комментарий</th>
                                                                <th class="max-w-85px sorting_disabled">Место приезда
                                                                </th>
                                                                <th class="max-w-85px sorting_disabled">Планируемая дата
                                                                    приезда
                                                                </th>
                                                                <th class="max-w-85px sorting_disabled">Время приезда
                                                                </th>
                                                                <th class="max-w-85px sorting_disabled">Вид транспорта
                                                                </th>
                                                                <th class="min-w-100px sorting_disabled">Билет</th>
                                                                <th class="min-w-100px sorting_disabled">Статус</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="text-gray-600 fw-bold">

                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                    </div>

                                                </div>
                                            @endif

                                            @if(Auth::user()->group_id == 5 || Auth::user()->group_id == 1)
                                                <div class="card-header cursor-pointer">
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bolder m-0">Трудоустройство</h3>
                                                    </div>
                                                </div>

                                                <div class="card-body p-9 pb-0">

                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 fw-bold text-muted">Статус
                                                            трудоустройства</label>
                                                        <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Real_status_work != null)
                                                                {{ $canddaite->Real_status_work->name }}
                                                            @endif
                                                        </span>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-lg-4 fw-bold text-muted">Клиент</label>
                                                        <div class="col-lg-8">
                                                        <span class="fw-bolder fs-6 text-gray-800">
                                                        @if($canddaite->Client != null)
                                                                {{ $canddaite->Client->name }}
                                                            @endif
                                                        </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                        histor
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            @include('includes.Footer')
        </div>
    </div>
</div>


<div class="modal fade " tabindex="-1" id="modal_view_doc">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Просмотр</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                  <span class="svg-icon svg-icon-2x">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
																			<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
																		</svg>
																	</span>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal body-->
            <div class="modal-body">
                <iframe id="modal_view_doc_iframe" style="width:100%; height:500px;" frameborder="0"></iframe>

            </div>

        </div>
    </div>
</div>



@include('includes.global_scripts')
<script src="{{url('/')}}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
@if(Auth::user()->isAdmin() || Auth::user()->isLogist() )
    <script>
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

                @if($canddaite != null)
                    data.canddaite_id = '{{$canddaite->id}}';
                @endif

                $.ajax({
                    url: '{{ route('candidates.arrivals.json') }}',
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

            }

        });
    </script>
@endif

<script>
    $('.view_doc a').click(function (){
        let href = $(this).data('href');
        $('#modal_view_doc_iframe').attr('src',href);
        $('#modal_view_doc').modal('show');
    })
</script>
</body>
</html>
