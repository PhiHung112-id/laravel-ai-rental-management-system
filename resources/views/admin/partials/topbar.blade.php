<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        --accent-color: #f6c23e;
        --text-shimmer-gradient: linear-gradient(to right, #ffffff 0%, #f6c23e 45%, #ffffff 90%);
    }

    .navbar-custom {
        background: var(--primary-gradient);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        padding: 0.5rem 1.5rem;
        min-height: 5rem;
        font-family: 'Poppins', sans-serif;
        z-index: 1001;
        border: none !important;
    }

    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 130px;
        height: 65px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        margin-right: 20px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        padding-left: 5px;
    }

    .logo-container:hover {
        background: rgba(255, 255, 255, 0.95);
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(78, 115, 223, 0.3);
        border-color: #fff;
    }

    .logo-svg-combined { width: 100%; height: 100%; }

    .drawn-path {
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: transparent;
        stroke-dasharray: 400;
        stroke-dashoffset: 400;
        animation: drawAndFill 5s ease-in-out infinite;
    }

    .path-main { stroke: white; stroke-width: 3px; }
    .path-accent { stroke: var(--accent-color); stroke-width: 2px; animation-delay: 0.5s; }

    @keyframes drawAndFill {
        0% { stroke-dashoffset: 400; fill: transparent; }
        40% { stroke-dashoffset: 0; fill: transparent; }
        60% { stroke-dashoffset: 0; fill: var(--fill-color); }
        80% { stroke-dashoffset: 0; fill: var(--fill-color); opacity: 1; }
        100% { stroke-dashoffset: 0; fill: var(--fill-color); opacity: 0; }
    }

    .logo-container:hover .path-main { stroke: #4e73df; --fill-color: #4e73df; }
    .logo-container:hover .path-accent { stroke: #4e73df; --fill-color: #4e73df; }
    .path-main { --fill-color: white; }
    .path-accent { --fill-color: var(--accent-color); }

    .brand-text-animated {
        font-weight: 800;
        font-size: 1.5rem;
        text-transform: uppercase;
        text-decoration: none !important;
        line-height: 1;
        letter-spacing: 1px;
        background: var(--text-shimmer-gradient);
        background-size: 200% auto;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        animation: textShimmer 6s linear infinite reverse;
    }

    @keyframes textShimmer { to { background-position: 200% center; } }

    .brand-subtitle {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        letter-spacing: 2px;
        display: block;
        margin-top: 2px;
    }

    .theme-switch-wrapper { display: flex; align-items: center; margin-left: 20px; }

    .theme-switch {
        display: inline-block;
        height: 32px;
        position: relative;
        width: 60px;
        margin-bottom: 0;
    }

    .theme-switch input { display: none; }

    .slider-round {
        background-color: rgba(255, 255, 255, 0.2);
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
        border-radius: 34px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 6px;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
    }

    .slider-round:before {
        background-color: #fff;
        bottom: 3px;
        content: "";
        height: 24px;
        left: 4px;
        position: absolute;
        transition: .4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        width: 24px;
        border-radius: 50%;
        z-index: 2;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    input:checked + .slider-round { background-color: rgba(0, 0, 0, 0.4); }
    input:checked + .slider-round:before { transform: translateX(26px); }

    .sun-icon { color: #f6c23e; font-size: 13px; z-index: 1; }
    .moon-icon { color: #f1f2f6; font-size: 13px; z-index: 1; }

    .user-profile {
        color: #ffffff !important;
        font-weight: 600;
        padding: 6px 18px 6px 8px;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        text-decoration: none !important;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .user-profile:hover,
    .user-profile[aria-expanded="true"] {
        background: rgba(255, 255, 255, 0.28);
        border-color: rgba(255, 255, 255, 0.7);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .user-profile.dropdown-toggle::after {
        margin-left: 12px;
        vertical-align: middle;
        transition: transform 0.3s ease;
    }

    .user-profile[aria-expanded="true"].dropdown-toggle::after {
        transform: rotate(180deg);
    }

    .dropdown-menu-custom {
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0,0,0,0.05);
        margin-top: 15px !important;
        padding: 10px;
        min-width: 260px;
        background: #ffffff;
        animation: dropFade 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        transform-origin: top right;
    }

    @keyframes dropFade {
        0% { opacity: 0; transform: translateY(15px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .dropdown-header {
        font-size: 0.75rem;
        font-weight: 800;
        color: #858796;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 10px 16px;
        margin-bottom: 5px;
        border-bottom: 1px dashed #eaecf4;
    }

    .dropdown-item {
        padding: 12px 16px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #5a5c69;
        border-radius: 10px;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        margin-bottom: 4px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fc;
        color: #4e73df;
        transform: translateX(5px);
    }

    .dropdown-item.text-danger:hover {
        background-color: #fef2f2;
        color: #e74a3b !important;
    }

    .dropdown-divider {
        margin: 8px 0;
        border-top: 1px solid #eaecf4;
    }

    .icon-box {
        width: 36px;
        height: 36px;
        background: #f8f9fc;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 12px;
        transition: all 0.3s;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.02);
    }
</style>

<script src="https://cdn.lordicon.com/lordicon.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">

        <div class="d-flex align-items-center">
            <div class="logo-container">
                <svg class="logo-svg-combined" viewBox="0 0 150 70">
                    <path class="drawn-path path-main" d="M35,15 A20,20 0 1,0 35,55 A20,20 0 1,0 35,15 M45,45 L57,60"/>
                    <path class="drawn-path path-main" d="M95,25 A18,18 0 1,0 95,50 L95,35 L80,35" transform="translate(-10, 0)"/>
                    <path class="drawn-path path-accent" d="M85,35 Q 95,55 130,55" fill="none"/>
                    <text x="98" y="50" font-family="'Poppins', sans-serif" font-weight="800" font-size="16" class="drawn-path path-accent">5.0</text>
                </svg>
            </div>

            <div class="d-flex flex-column justify-content-center">
                <a class="brand-text-animated" href="{{ route('admin.dashboard') }}">
                    {{ session('system.name', 'QUẢN GIA') }}
                </a>
                <span class="brand-subtitle">Hệ thống quản lý 5.0</span>
            </div>
        </div>

        <div class="theme-switch-wrapper">
            <label class="theme-switch" for="dark-mode-toggle">
                <input type="checkbox" id="dark-mode-toggle"/>
                <div class="slider-round">
                    <i class="fas fa-sun sun-icon"></i>
                    <i class="fas fa-moon moon-icon"></i>
                </div>
            </label>
        </div>

        <div class="ml-auto">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle user-profile" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div style="margin-right: 12px; display: flex; align-items: center;">
                        <lord-icon
                            src="https://cdn.lordicon.com/kthelypq.json"
                            trigger="loop"
                            delay="2000"
                            colors="primary:#ffffff,secondary:#f6c23e"
                            style="width:34px;height:34px">
                        </lord-icon>
                    </div>
                    {{ session('login_name', 'Admin') }}
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-custom" aria-labelledby="account_settings">
                    <div class="dropdown-header">TÀI KHOẢN CỦA TÔI</div>

                    <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account">
                        <div class="icon-box">
                            <lord-icon src="https://cdn.lordicon.com/hwuyodym.json" trigger="morph" state="morph-spin"
                                colors="primary:#4e73df,secondary:#f6c23e" style="width:20px;height:20px"></lord-icon>
                        </div>
                        Cài đặt tài khoản
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                        <div class="icon-box" style="background: #fef2f2;">
                            <lord-icon src="https://cdn.lordicon.com/moscwhoj.json" trigger="hover"
                                colors="primary:#e74a3b,secondary:#e74a3b" style="width:20px;height:20px"></lord-icon>
                        </div>
                        Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    $('#manage_my_account').click(function () {
        uni_modal("Quản lý tài khoản", "{{ url('/admin/users/manage-own') }}")
    });

    $('#dark-mode-toggle').on('change', function(){
        if($(this).is(':checked')){
            localStorage.setItem('admin-theme', 'dark');
            $('body').addClass('dark-mode');
        } else {
            localStorage.setItem('admin-theme', 'light');
            $('body').removeClass('dark-mode');
        }
    });

    if(localStorage.getItem('admin-theme') === 'dark'){
        $('#dark-mode-toggle').prop('checked', true);
    }
</script>