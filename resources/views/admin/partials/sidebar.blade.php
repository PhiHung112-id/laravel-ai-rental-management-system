<style>
    nav#sidebar {
        background: #ffffff;
        height: 100vh;
        overflow-y: auto;
        width: 260px;
        padding-top: 5.5rem;
        padding-bottom: 40px;
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-right: 1px solid #f3f4f6;
    }

    nav#sidebar::-webkit-scrollbar { width: 4px; }
    nav#sidebar::-webkit-scrollbar-track { background: transparent; }
    nav#sidebar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    nav#sidebar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }

    .menu-header {
        color: #9ca3af;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 25px 0 10px 25px;
        opacity: 0.8;
    }

    .sidebar-list a.nav-item {
        position: relative;
        display: flex;
        align-items: center;
        padding: 11px 18px;
        margin: 4px 16px;
        border-radius: 12px;
        color: #4b5563;
        text-decoration: none;
        font-size: 14px;
        font-weight: 550;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: none !important;
        box-shadow: none !important;
    }

    .icon-field {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 32px;
        height: 32px;
        margin-right: 12px;
        background: #f3f4f6;
        border-radius: 10px;
        transition: all 0.25s ease;
        color: #6b7280;
        font-size: 14px;
    }

    .sidebar-list a.nav-item:hover {
        background-color: #f8fafc;
        color: #111827;
        transform: translateX(4px);
        border: none !important;
    }

    .sidebar-list a.nav-item.active {
        color: #ffffff !important;
        font-weight: 600;
        border: none !important;
    }

    .sidebar-list a.nav-item.active .icon-field {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }

    .nav-home:hover { color: #4e73df; }
    .nav-home:hover .icon-field { color: #4e73df; background: #eff6ff; }
    .nav-home.active { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); box-shadow: 0 8px 20px -6px rgba(78, 115, 223, 0.5) !important; }

    .nav-houses:hover { color: #06b6d4; }
    .nav-houses:hover .icon-field { color: #06b6d4; background: #ecfeff; }
    .nav-houses.active { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); box-shadow: 0 8px 20px -6px rgba(6, 182, 212, 0.5) !important; }

    .nav-tenants:hover { color: #10b981; }
    .nav-tenants:hover .icon-field { color: #10b981; background: #ecfdf5; }
    .nav-tenants.active { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.5) !important; }

    .nav-maintenance:hover { color: #ef4444; }
    .nav-maintenance:hover .icon-field { color: #ef4444; background: #fef2f2; }
    .nav-maintenance.active { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 8px 20px -6px rgba(239, 68, 68, 0.5) !important; }

    .nav-categories:hover { color: #8b5cf6; }
    .nav-categories:hover .icon-field { color: #8b5cf6; background: #f5f3ff; }
    .nav-categories.active { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); box-shadow: 0 8px 20px -6px rgba(139, 92, 246, 0.5) !important; }

    .nav-bookings:hover { color: #f59e0b; }
    .nav-bookings:hover .icon-field { color: #f59e0b; background: #fffbec; }
    .nav-bookings.active { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 8px 20px -6px rgba(245, 158, 11, 0.5) !important; }

    .nav-invoices:hover { color: #10b981; }
    .nav-invoices:hover .icon-field { color: #10b981; background: #ecfdf5; }
    .nav-invoices.active { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.5) !important; }

    .nav-reports:hover { color: #ec4899; }
    .nav-reports:hover .icon-field { color: #ec4899; background: #fdf2f8; }
    .nav-reports.active { background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); box-shadow: 0 8px 20px -6px rgba(236, 72, 153, 0.5) !important; }

    .nav-utility_readings:hover { color: #f97316; }
    .nav-utility_readings:hover .icon-field { color: #f97316; background: #fff7ed; }
    .nav-utility_readings.active { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); box-shadow: 0 8px 20px -6px rgba(249, 115, 22, 0.5) !important; }

    .nav-users:hover { color: #4b5563; }
    .nav-users:hover .icon-field { color: #4b5563; background: #f3f4f6; }
    .nav-users.active { background: linear-gradient(135deg, #4b5563 0%, #374151 100%); box-shadow: 0 8px 20px -6px rgba(75, 85, 99, 0.5) !important; }

    .nav-locations:hover { color: #b45309; }
    .nav-locations:hover .icon-field { color: #b45309; background: #fef3c7; }
    .nav-locations.active { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); box-shadow: 0 8px 20px -6px rgba(217, 119, 6, 0.5) !important; }

    .nav-installment_requests:hover { color: #f43f5e; }
    .nav-installment_requests:hover .icon-field { color: #f43f5e; background: #fff1f2; }
    .nav-installment_requests.active { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); box-shadow: 0 8px 20px -6px rgba(244, 63, 94, 0.5) !important; }

    .nav-notifications:hover { color: #3b82f6; }
    .nav-notifications:hover .icon-field { color: #3b82f6; background: #eff6ff; }
    .nav-notifications.active { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); box-shadow: 0 8px 20px -6px rgba(59, 130, 246, 0.5) !important; }

    .nav-reviews:hover { color: #6d28d9; }
    .nav-reviews:hover .icon-field { color: #6d28d9; background: #f5f3ff; }
    .nav-reviews.active { background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%); box-shadow: 0 8px 20px -6px rgba(109, 40, 217, 0.5) !important; }

    .nav-messages:hover { color: #6d28d9; }
    .nav-messages:hover .icon-field { color: #6d28d9; background: #f5f3ff; }
    .nav-messages.active { background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%); box-shadow: 0 8px 20px -6px rgba(109, 40, 217, 0.5) !important; }

    .nav-manage_installments:hover { color: #10b981; }
    .nav-manage_installments:hover .icon-field { color: #10b981; background: #ecfdf5; }
    .nav-manage_installments.active { background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.5) !important; }

    main#view-panel {
        margin-left: 260px;
    }
</style>

@php
    $adminPage = request()->segment(2) ?? 'home';
@endphp

<nav id="sidebar">
    <div class="sidebar-list">

        <div class="menu-header">Quản lý</div>

        <a href="{{ route('admin.dashboard') }}" class="nav-item ajax-link nav-home {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-th-large"></i></span>
            Tổng quan
        </a>

        <a href="{{ url('/admin/categories') }}" class="nav-item ajax-link nav-categories {{ request()->is('admin/categories*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-layer-group"></i></span>
            Loại phòng
        </a>

        <a href="{{ url('/admin/locations') }}" class="nav-item ajax-link nav-locations {{ request()->is('admin/locations*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-map-marked-alt"></i></span>
            Quản lý Khu vực
        </a>

        <a href="{{ url('/admin/houses') }}" class="nav-item ajax-link nav-houses {{ request()->is('admin/houses*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-door-open"></i></span>
            Danh sách phòng
        </a>

        <a href="{{ url('/admin/tenants') }}" class="nav-item ajax-link nav-tenants {{ request()->is('admin/tenants*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-user-friends"></i></span>
            Khách thuê
        </a>

        <a href="{{ url('/admin/complaints') }}"
        class="nav-item ajax-link nav-maintenance {{ request()->is('admin/complaints*') ? 'active' : '' }}">

            <span class="icon-field">
                <i class="fa fa-tools"></i>
            </span>

            Sự cố & Sửa chữa
        </a>

        <a href="{{ url('/admin/bookings') }}" class="nav-item ajax-link nav-bookings {{ request()->is('admin/bookings*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-calendar-check"></i></span>
            Danh sách đặt phòng
        </a>

        <a href="{{ url('/admin/installment-requests') }}" class="nav-item ajax-link nav-installment_requests {{ request()->is('admin/installment-requests*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-hand-holding-usd"></i></span>
            Yêu cầu Trả góp
        </a>

        <a href="{{ url('/admin/notifications') }}" class="nav-item ajax-link nav-notifications {{ request()->is('admin/notifications*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-bell"></i></span>
            Thông báo hệ thống
        </a>

        <a href="{{ url('/admin/reviews') }}" class="nav-item ajax-link nav-reviews {{ request()->is('admin/reviews*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-comments"></i></span>
            Đánh giá & Phản hồi
        </a>

        <a href="{{ url('/admin/messages') }}" class="nav-item ajax-link nav-messages {{ request()->is('admin/messages*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-envelope-open-text"></i></span>
            Tin nhắn liên hệ
        </a>

        <div class="menu-header">Tài chính & Báo cáo</div>

        <a href="{{ url('/admin/payments') }}" class="nav-item ajax-link nav-invoices {{ request()->is('admin/payments*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-file-invoice-dollar"></i></span>
            Hoá đơn & Thu tiền
        </a>

        <a href="{{ url('/admin/installment-receipts') }}"
        class="nav-item ajax-link nav-manage_installments {{ request()->is('admin/installment-receipts*') ? 'active' : '' }}">
            <span class="icon-field"><i class="fa fa-money-check-alt"></i></span>
            Duyệt đóng tiền góp
        </a>

        <a href="{{ url('/admin/utilities') }}"
        class="nav-item ajax-link nav-utility_readings {{ request()->is('admin/utilities*') ? 'active' : '' }}">
            <span class="icon-field">
                <i class="fa fa-tachometer-alt"></i>
            </span>
            Ghi Điện / Nước
        </a>

        <a href="{{ route('admin.reports') }}"
        class="nav-item ajax-link nav-reports {{ request()->is('admin/reports*') ? 'active' : '' }}">
            <span class="icon-field">
                <i class="fa fa-chart-pie"></i>
            </span>
            Thống kê & Báo cáo
        </a>

        @if(session('login_type') == 1)
            <div class="menu-header">Hệ thống</div>

            <a href="{{ url('/admin/users') }}" class="nav-item ajax-link nav-users {{ request()->is('admin/users*') ? 'active' : '' }}">
                <span class="icon-field"><i class="fa fa-user-shield"></i></span>
                Tài khoản Admin
            </a>
        @endif

        <div style="height: 50px;"></div>
    </div>
</nav>

<script>
    $(document).on('click', '.ajax-link', function(e){
    let url = $(this).attr('href');

    // Dashboard load full trang để không mất CSS/Chart
    if (url.includes('/admin') && !url.includes('/admin/')) {
        return true;
    }

    e.preventDefault();

    $('.sidebar-list .nav-item').removeClass('active');
    $(this).addClass('active');

    $('#view-panel').css('opacity', '.45');

    $.ajax({
        url: url,
        method: 'GET',
        success: function(resp){
            let html = $('<div>').html(resp);
            let content = html.find('#view-panel').html();

            if(content){
                $('#view-panel').html(content);
                window.history.pushState({}, '', url);
            }else{
                window.location.href = url;
            }

            $('#view-panel').css('opacity', '1');
        },
        error:function(){
            window.location.href = url;
        }
    });
});
</script>