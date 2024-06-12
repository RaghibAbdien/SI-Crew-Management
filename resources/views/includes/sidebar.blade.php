<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('project') }}" class="waves-effect">
                        <i class="fa-solid fa-helmet-safety"></i>
                        <span>Project</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('crew') }}" class="waves-effect">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Crew</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('absensi-crew') }}" class="waves-effect">
                        <i class="fa-solid fa-calendar-day"></i>
                        <span>Absensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengajuan-cuti') }}" class="waves-effect">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>Pengajuan Cuti</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>