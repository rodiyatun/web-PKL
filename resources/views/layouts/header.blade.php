<div id="kt_header" class="header  header-fixed ">
    <!--begin::Container-->
    <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-mobile  header-menu-layout-default ">
                {{-- @yield('breadcrumb') --}}
                {{-- <ul class="menu-nav ">
                    <li class="menu-item  menu-item-submenu menu-item-rel"><h5 class="mb-0">Dashboard</h5></li>
                    <li class="menu-item  menu-item-submenu menu-item-rel"><i class="fa fa-arrow-right"></i></li>
                    <li class="menu-item  menu-item-submenu menu-item-rel"><p class="mb-0 mt-1 text-muted">ca</p></li>
                </ul> --}}
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->

        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::User-->
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                    id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1"
                        style="color: #acaaaa">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"
                        style="color: #acaaaa">{{ explode(' ', trim(\Auth::user()->name ))[0] ?? 'Admin' }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span
                            class="symbol-label font-size-h5 font-weight-bold">{{ ucfirst(substr(\Auth::user()->name ?? 'Admin', 0, 1)) }}</span>
                    </span>
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
