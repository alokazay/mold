<!--begin::Navbar-->
<div class="d-flex align-items-stretch" id="kt_header_nav">
    <!--begin::Menu wrapper-->
    <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
         data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend"
         data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
        <!--begin::Menu-->
        <div
            class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
            id="#kt_header_menu" data-kt-menu="true">

            @if(Auth::user()->group_id == 1)
                <div data-kt-menu-placement="bottom-start" class="menu-item   me-lg-1">
                    <a href="{{url('/')}}/users" class="menu-link py-3">
                        <span class="menu-title">Сотрудники</span>
                        <span class="menu-arrow d-lg-none"></span>
                    </a>
                </div>
                <div data-kt-menu-placement="bottom-start" class="menu-item   me-lg-1">
                    <a  href="{{url('/')}}/freelancers" class="menu-link py-3">
                        <span class="menu-title">Фрилансеры</span>
                        <span class="menu-arrow d-lg-none"></span>
                    </a>
                </div>
                <div data-kt-menu-placement="bottom-start" class="menu-item   me-lg-1">
                    <a href="{{url('/')}}/clients" class="menu-link py-3">
                        <span class="menu-title">Клиенты</span>
                        <span class="menu-arrow d-lg-none"></span>
                    </a>
                </div>
                <div data-kt-menu-placement="bottom-start" class="menu-item   me-lg-1">
                    <a  href="{{url('/')}}/vacancies" class="menu-link py-3">
                        <span class="menu-title">Вакансии</span>
                        <span class="menu-arrow d-lg-none"></span>
                    </a>
                </div>
                <div data-kt-menu-placement="bottom-start" class="menu-item   me-lg-1">
                    <a href="{{url('/')}}/statistics" class="menu-link py-3">
                        <span class="menu-title">Статистика</span>
                        <span class="menu-arrow d-lg-none"></span>
                    </a>
                </div>
            @endif
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::Navbar-->
