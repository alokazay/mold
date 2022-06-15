<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>Настройка</title>

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

                                <li class="breadcrumb-item text-dark">Настройка</li>
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

                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <a onclick="addFirm();" href="javascript:;" class="btn btn-primary">Добавить</a>
                                </div>

                            </div>
                            <div class="card-body pt-15">

                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="users">

                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted fw-bolder fs-7 gs-0">
                                            <th class="max-w-55px sorting_disabled">Id</th>
                                            <th class="max-w-155px sorting_disabled">Nip</th>
                                            <th class="max-w-155px sorting_disabled">Name</th>
                                            <th class="min-w-100px sorting_disabled">

                                            </th>
                                        </tr>

                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                        @foreach($firms as $firm)
                                            <tr class="delete{{$firm->id}}">
                                                <td>
                                                    <a onclick="editFirm({{$firm->id}},'{{$firm->nip}}','{{$firm->name}}')"
                                                       href="javascript:;">{{$firm->id}}</a>
                                                </td>
                                                <td>{{$firm->nip}}</td>
                                                <td>{{$firm->name}}</td>
                                                <td><a onclick="deleteFirm({{$firm->id}})"
                                                       href="javascript:;">удалить</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

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


<div class="modal fade" tabindex="-1" id="modal_firm_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавления фирмы</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal body-->
            <div class="modal-body">
                <input type="hidden" id="modal_firm_add__id">

                <div class="row mb-5">
                    <div class="col-6">
                        <div class="d-flex flex-column mb-0 fv-row">
                            <label class="required fs-5 fw-bold mb-2">НИп</label>
                            <input value="" id="nip"
                                   class="form-control form-control-sm form-control-solid" type="text"/>
                        </div>
                    </div>

                </div>

                <div class="row mb-5">
                    <div class="col-6">
                        <div class="d-flex flex-column mb-0 fv-row">
                            <label class="required fs-5 fw-bold mb-2">Название</label>
                            <input value="" id="name1" class="form-control form-control-sm form-control-solid"
                                   type="text"/>
                        </div>
                    </div>
                </div>

                <button id="modal_users_add__save" type="button" class="btn btn-primary btn-sm">Сохранить
                </button>


            </div>

        </div>
    </div>
</div>


@include('includes.global_scripts')
<script>
    $('#modal_users_add__save').click(function (e) {
        e.preventDefault();
        let self = $(this);

        self.prop('disabled', true);

        var data = {
            nip: $('#nip').val(),
            name: $('#name1').val(),
            _token: $('input[name=_token]').val(),
        };

        let id = $('#modal_firm_add__id').val();
        if (id !== '') {
            data.id = id;
        }

        $.ajax({
            url: "{{route('accountant.profile.save')}}",
            method: 'post',
            data: data,
            success: function (response, status, xhr, $form) {
                if (response.error) {
                    toastr.error(response.error);
                } else {
                    toastr.success('Сохранено');
                }
                self.prop('disabled', false);
                $('#modal_firm_add').modal('hide');
                location.reload();
            }
        });
    });

    function addFirm() {
        $('#nip').val('');
        $('#name1').val('');
        $('#modal_firm_add__id').val('');
        $('#modal_firm_add').modal('show');
    }

    function editFirm(id, nip, name) {
        $('#nip').val(nip);
        $('#name1').val(name);
        $('#modal_firm_add__id').val(id);
        $('#modal_firm_add').modal('show');
    }

    function deleteFirm(id) {
        Swal.fire({
            html: `Вы уверены что хотите удалить?`,
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "да!",
            cancelButtonText: 'Нет, отмена',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: 'btn btn-danger'
            }
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.get('{{url('/')}}/accountant/firm/delete?id=' + id);
                $('.delete' + id).remove();
                Swal.fire('Deleted!', '', 'success');
            }
        });
    }

</script>
</body>
<!--end::Body-->
</html>
