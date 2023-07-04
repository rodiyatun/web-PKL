<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav ">
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ url('/') }}" class="menu-link "><i class="menu-icon flaticon-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            @role('student')
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
            <a href="{{ route('present.index') }}" class="menu-link "><i class="menu-icon flaticon-clock"></i>
                    <span class="menu-text">Presensi</span>
                </a>
            </li>

            <li class="menu-item menu-item-submenu @yield('du_di')" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-icon flaticon2-pen"></i> {{-- https://preview.keenthemes.com/metronic/demo1/features/icons/flaticon.html --}}
                    <span class="menu-text">Jurnals</span>
                    <i class="menu-arrow"></i>
                </a>
            <div class="menu-submenu" kt-hidden-height="120"">
                <i class="menu-arrow"></i>
                <ul class="menu-subnav">
                    <li class="menu-item @yield('list_du_di')" aria-haspopup="true">
                        <a href="{{ route('student.jurnal.list') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">List Jurnal</span>
                        </a>
                    </li>
                    <li class="menu-item @yield('create_du_di')" aria-haspopup="true">
                        <a href="{{ route('student.jurnal.create') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text">Create Jurnal</span>

                        </a>
                    </li>

                </ul>
            </div>
        </li>

                @if(session('sertifikat'))
                <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('student.certificate.download') }}" target="_blank" class="menu-link "><i class="menu-icon flaticon2-document"></i>
                        <span class="menu-text">Sertifikat</span>
                    </a>
                </li>
                @endif
            @endrole
            @role('teacher')

            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('company.index') }}" class="menu-link "><i class="menu-icon flaticon-user-settings"></i>
                    <span class="menu-text">DU/DI</span>
                </a>
            </li>
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('student.index') }}" class="menu-link "><i class="menu-icon flaticon-technology-1"></i>
                    <span class="menu-text">Student</span>
                </a>
            </li>
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('teacher.jurnal.list') }}" class="menu-link "><i class="menu-icon flaticon-book"></i>
                    <span class="menu-text">Jurnal</span>
                </a>
            </li>
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('present.index') }}" class="menu-link "><i class="menu-icon
                    flaticon2-placeholder"></i>
                    <span class="menu-text">Presensi</span>
                </a>
            </li>
            @endrole
            @role('company')
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('student.index') }}" class="menu-link "><i class="menu-icon flaticon-technology-1"></i>
                    <span class="menu-text">Student</span>
                </a>
            </li>
            <li class="menu-item @yield('dashboard_side')" aria-haspopup="true">
                <a href="{{ route('present.index') }}" class="menu-link "><i class="menu-icon
                    flaticon2-placeholder"></i>
                    <span class="menu-text">Presensi</span>
                </a>
            </li>
            @endrole
            {{-- Paste Menunya disini --}}

            @role('Admin')
            <li class="menu-item menu-item-submenu @yield('du_di')" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-icon flaticon-user-settings"></i> {{-- https://preview.keenthemes.com/metronic/demo1/features/icons/flaticon.html --}}
                    <span class="menu-text">DU/DI</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu" kt-hidden-height="120"">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item @yield('list_du_di')" aria-haspopup="true">
                            <a href="{{ route('company.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">List DU/DI</span>
                            </a>
                        </li>
                        <li class="menu-item @yield('create_du_di')" aria-haspopup="true">
                            <a href="{{ route('company.create') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Create DU/DI</span>

                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-icon flaticon-technology-1"></i> {{-- https://preview.keenthemes.com/metronic/demo1/features/icons/flaticon.html --}}
                    <span class="menu-text">Students</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu" kt-hidden-height="120">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('student.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">List Student</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('student.create') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Create Student</span>

                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-icon flaticon-users"></i> {{-- https://preview.keenthemes.com/metronic/demo1/features/icons/flaticon.html --}}
                    <span class="menu-text">Teacher</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu" kt-hidden-height="120">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('teacher.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">List Teacher</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('teacher.create') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Create Teacher</span>

                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            @endrole

        </ul>
    </div>
</div>
