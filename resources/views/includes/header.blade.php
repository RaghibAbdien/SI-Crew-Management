<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="/dashboard" class="logo logo-light">
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="assets/images/logo-light.png" alt="" height="18">
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
            <i class="mdi mdi-menu"></i>
        </button>

        
    </div>

    <div class="d-flex">

        <div class="dropdown d-none d-lg-inline-block">
            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                <i class="mdi mdi-fullscreen"></i>
            </button>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i>
                @if ( $NotifNotReadNum )
                <span class="badge bg-danger rounded-pill">{{ $NotifNotReadNum }}</span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 pb-3" aria-labelledby="page-header-notifications-dropdown">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="m-0 pb-1 font-size-16 border-bottom">
                                 Notifications @if ($NotifNotReadNum)
                                     ({{ $NotifNotReadNum }})
                                     @else 
                                 @endif
                            </h5>
                        </div>
                    </div>
                </div>
                <div data-simplebar style="max-height: 230px;">
                    @forelse ( $notifs as $notif )
                    <div class="text-reset notification-item cursor-pointer mb-1 {{ $notif->is_read ? 'bg-secondary' : '' }}" data-bs-toggle="modal" data-bs-target="#myNotif{{ $notif->id }}">
                        <div class="w-100 d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-xs">
                                    <span class="avatar-title bg-warning rounded-circle font-size-16">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $notif->title }}</h6>
                                <div class="font-size-12 text-muted">
                                    <span class="mb-1">Crew : {{ $notif->nama_crew }}</span>
                                    <p class="mb-1">{{ $notif->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="w-100 d-flex align-items-center">
                            <p class="mx-auto">Tidak ada pemberitahuan saat ini</p>
                        </div>
                    @endforelse 
                </div>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="assets/images/users/user-4.jpg"
                    alt="Header Avatar">
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <span class="dropdown-item"><i class="mdi mdi-account-circle font-size-17 align-middle me-1"></i>Halo, {{ auth()->user()->nama }}</span>
                <div class="dropdown-divider"></div>
                <form id="formToExclude" action="/logout" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger"><i class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</button>
                </form>
            </div>
        </div>

    </div>
</div>