<style>
    body{font-family:'Poppins',sans-serif;}
    main{min-height:60vh;}

    .navbar-custom{
        background-color:rgba(255,255,255,0.92)!important;
        backdrop-filter:blur(12px);
        -webkit-backdrop-filter:blur(12px);
        box-shadow:0 4px 30px rgba(0,0,0,0.02),0 1px 0 rgba(0,0,0,0.04);
        padding:14px 0;
        transition:all .3s ease;
        z-index:1050;
    }

    .navbar-custom *{box-sizing:border-box;}
    .navbar-custom a{text-decoration:none!important;}

    .brand-icon{
        font-size:1.7rem;
        color:#2563eb;
        margin-right:10px;
        transition:transform .3s ease;
    }

    .navbar-brand:hover .brand-icon{
        transform:scale(1.08) rotate(-5deg);
    }

    .brand-svg{
        height:32px;
        width:210px;
    }

    .text-draw{
        font-family:'Poppins',sans-serif;
        font-weight:900;
        fill:transparent;
        stroke-dasharray:400;
        stroke-dashoffset:400;
    }

    .text-main{
        font-size:1.55rem;
        stroke:#1e3a8a;
        stroke-width:2px;
        animation:drawMainText 4s ease-in-out infinite alternate;
    }

    .text-sub{
        font-size:1.55rem;
        stroke:#f59e0b;
        stroke-width:2px;
        animation:drawSubText 4s ease-in-out infinite alternate;
    }

    @keyframes drawMainText{
        0%{stroke-dashoffset:400;fill:transparent;}
        35%{stroke-dashoffset:0;fill:transparent;}
        55%,100%{stroke-dashoffset:0;fill:#1e3a8a;}
    }

    @keyframes drawSubText{
        0%,20%{stroke-dashoffset:400;fill:transparent;}
        65%{stroke-dashoffset:0;fill:transparent;}
        100%{stroke-dashoffset:0;fill:#f59e0b;}
    }

    .nav-link-custom{
        color:#475569!important;
        font-weight:600;
        font-size:.92rem;
        padding:8px 18px!important;
        position:relative;
        transition:all .25s ease;
    }

    .nav-link-custom::after{
        content:'';
        position:absolute;
        bottom:0;
        left:18px;
        right:18px;
        height:3px;
        background:#2563eb;
        border-radius:10px;
        transform:scaleX(0);
        transition:transform .25s ease;
    }

    .nav-link-custom:hover{
        color:#2563eb!important;
    }

    .nav-link-custom:hover::after{
        transform:scaleX(1);
    }

    .active-nav{
        color:#2563eb!important;
    }

    .active-nav::after{
        transform:scaleX(1)!important;
    }

    .active-nav-special{
        color:#2563eb!important;
        background-color:#eff6ff;
        border-radius:50px;
        padding-left:20px!important;
        padding-right:20px!important;
    }

    .active-nav-special::after{
        display:none!important;
    }

    .btn-header-action{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        border:none;
        color:white!important;
        font-weight:700;
        font-size:.88rem;
        border-radius:50px;
        padding:11px 26px;
        transition:all .3s ease;
        box-shadow:0 4px 14px rgba(37,99,235,.25);
    }

    .btn-header-action:hover{
        transform:translateY(-2px);
        box-shadow:0 6px 20px rgba(37,99,235,.4);
    }

    .user-dropdown-btn{
        background:#f8fafc;
        border:1px solid #e2e8f0;
        color:#334155;
        font-weight:600;
        border-radius:50px;
        padding:5px 16px 5px 6px;
    }

    .avatar-header{
        width:34px;
        height:34px;
        border-radius:50%;
        object-fit:cover;
        border:2px solid #fff;
    }

    .premium-dropdown-menu,
    .notif-dropdown-menu{
        border-radius:16px!important;
        border:1px solid #e2e8f0!important;
        box-shadow:0 15px 35px rgba(0,0,0,.1)!important;
        z-index:3000;
    }

    .premium-dropdown-item{
        padding:10px 20px!important;
        font-size:.9rem;
        font-weight:500;
        color:#475569!important;
        transition:.2s;
    }

    .premium-dropdown-item:hover{
        background-color:#f8fafc;
        color:#2563eb!important;
        padding-left:24px!important;
    }

    .notif-bell-btn{
        background:#f8fafc;
        border:1px solid #e2e8f0;
        color:#64748b;
        width:44px;
        height:44px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        position:relative;
        transition:.25s;
    }

    .notif-bell-btn:hover{
        color:#2563eb;
        transform:translateY(-2px);
    }

    .notif-bell-btn::after{
        display:none!important;
    }

    .notif-badge-counter{
        position:absolute;
        top:-2px;
        right:-2px;
        background-color:#ef4444;
        color:white;
        font-size:.68rem;
        font-weight:700;
        min-width:18px;
        height:18px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        border:2px solid white;
    }

    .notif-dropdown-menu{
        width:360px;
        max-height:430px;
        overflow-y:auto;
        padding:0!important;
    }

    .notif-item-title{
        font-size:.88rem;
        font-weight:700;
        color:#1e293b;
        white-space:normal;
    }

    .notif-item-content{
        font-size:.78rem;
        color:#64748b;
        white-space:normal;
        margin-top:3px;
    }

    .notif-pin{
        color:#f59e0b;
    }
</style>

@php
    $isLoggedIn = session()->has('login_customer_id');
    $displayName = session('login_customer_name', 'Khách hàng');
    $customer = null;

    if($isLoggedIn){
        $customer = \App\Models\Customer::find(session('login_customer_id'));
    }

    $avatarSrc = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=2563eb&color=fff';

    if($customer && !empty($customer->avatar)){
        if(\Illuminate\Support\Str::startsWith($customer->avatar, ['http://', 'https://'])){
            $avatarSrc = $customer->avatar;
        }else{
            $avatarSrc = asset('assets/uploads/' . str_replace(' ','%20',$customer->avatar));
        }
    }elseif(session()->has('login_avatar')){
        if(\Illuminate\Support\Str::startsWith(session('login_avatar'), ['http://', 'https://'])){
            $avatarSrc = session('login_avatar');
        }else{
            $avatarSrc = asset('assets/uploads/' . str_replace(' ','%20',session('login_avatar')));
        }
    }

    $notifications = \App\Models\Notification::orderByDesc('is_pinned')
        ->orderByDesc('id')
        ->limit(5)
        ->get();

    $notificationCount = $notifications->count();
@endphp

<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="fa fa-laptop-house brand-icon"></i>

            <svg class="brand-svg" viewBox="0 0 240 40">
                <text x="0" y="32" class="text-draw text-main">QUẢN GIA</text>
                <text x="155" y="32" class="text-draw text-sub">5.0</text>
            </svg>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarContent">
            <i class="fa fa-bars text-primary"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->is('/') ? 'active-nav' : '' }}"
                       href="{{ url('/') }}">
                        Trang chủ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->is('rooms*') || request()->is('view/*') ? 'active-nav' : '' }}"
                       href="{{ url('/rooms') }}">
                        Danh sách phòng
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('predict_price') ? 'active-nav-special' : '' }}"
                       href="{{ route('predict_price') }}">
                        <i class="fa fa-robot mr-1"></i>
                        Dự đoán giá
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->is('contact') ? 'active-nav' : '' }}"
                       href="{{ url('/contact') }}">
                        Liên hệ
                    </a>
                </li>

            </ul>

            <div class="ml-auto mt-3 mt-lg-0 d-flex align-items-center"
                 style="gap:15px;">

                {{-- CHUÔNG THÔNG BÁO --}}
                <div class="dropdown">

                    <button class="btn notif-bell-btn"
                            type="button"
                            data-toggle="dropdown">

                        <i class="fa fa-bell"></i>

                        @if($notificationCount > 0)
                            <span class="notif-badge-counter">
                                {{ $notificationCount }}
                            </span>
                        @endif

                    </button>

                    <div class="dropdown-menu dropdown-menu-right notif-dropdown-menu border-0 mt-3">

                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">

                            <h6 class="mb-0 font-weight-bold text-dark">
                                <i class="fa fa-bell text-primary mr-1"></i>
                                Thông báo
                            </h6>

                            <small class="text-muted">
                                {{ $notificationCount }} tin
                            </small>

                        </div>

                        @forelse($notifications as $noti)

                            <a href="{{ route('notifications.index') }}"
                               class="dropdown-item premium-dropdown-item py-3">

                                <div class="d-flex">

                                    <div class="mr-3 {{ $noti->is_pinned ? 'notif-pin' : 'text-primary' }}">
                                        <i class="fa {{ $noti->is_pinned ? 'fa-thumbtack' : 'fa-info-circle' }} fa-lg"></i>
                                    </div>

                                    <div>

                                        <div class="notif-item-title">
                                            {{ $noti->title }}
                                        </div>

                                        <div class="notif-item-content">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($noti->content), 75) }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $noti->created_at ? $noti->created_at->format('d/m/Y H:i') : '' }}
                                        </small>

                                    </div>

                                </div>

                            </a>

                        @empty

                            <div class="text-center p-4 text-muted">

                                <i class="fa fa-bell-slash fa-2x mb-2"></i>

                                <div>
                                    Chưa có thông báo
                                </div>

                            </div>

                        @endforelse

                        <div class="border-top text-center p-2">

                            <a href="{{ route('notifications.index') }}"
                               class="small text-primary font-weight-bold">

                                Xem tất cả thông báo

                            </a>

                        </div>

                    </div>

                </div>

                {{-- USER --}}
                @if($isLoggedIn)

                    <div class="dropdown">

                        <button class="btn user-dropdown-btn d-flex align-items-center"
                                type="button"
                                data-toggle="dropdown">

                            <img src="{{ $avatarSrc }}"
                                 class="avatar-header mr-2">

                            <span class="font-weight-bold"
                                  style="font-size:.88rem;">
                                {{ $displayName }}
                            </span>

                        </button>

                        <div class="dropdown-menu dropdown-menu-right premium-dropdown-menu border-0 mt-3">

                            <a class="dropdown-item premium-dropdown-item"
                               href="{{ url('/profile') }}">

                                <i class="fa fa-id-card text-primary mr-2"></i>
                                Hồ sơ

                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="{{ url('/logout') }}"
                               class="dropdown-item premium-dropdown-item text-danger font-weight-bold">

                                <i class="fa fa-sign-out-alt mr-2"></i>
                                Đăng xuất

                            </a>

                        </div>

                    </div>

                @else

                    <a href="{{ url('/login') }}"
                       class="btn btn-header-action shadow-sm">

                        <i class="fa fa-sign-in-alt mr-1"></i>
                        Đăng nhập / Đăng ký

                    </a>

                @endif

            </div>

        </div>

    </div>
</nav>