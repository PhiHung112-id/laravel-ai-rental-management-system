@extends('admin.layouts.app')

@section('content')

<style>
    .reports-premium-wrapper {
        min-height: calc(100vh - 60px);
        padding-top: 20px;
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .page-header-custom {
        margin-bottom: 30px;
        border-bottom: 2px solid #eec;
        padding-bottom: 15px;
    }

    .page-header-custom h4 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .report-card {
        border: none;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        position: relative;
        height: 100%;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 35px 30px;
    }

    .report-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(78, 115, 223, 0.08);
    }

    .icon-container {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .report-card:hover .icon-container {
        transform: scale(1.1) rotate(8deg);
    }

    .style-payment .icon-container {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1976d2;
    }

    .style-payment .btn-view {
        color: #1976d2;
    }

    .style-balance .icon-container {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: #f57c00;
    }

    .style-balance .btn-view {
        color: #f57c00;
    }

    .card-title-custom {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .card-desc-custom {
        font-size: 0.95rem;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .btn-view {
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .report-card:hover .btn-view i {
        transform: translateX(6px);
    }

    body.dark-mode .page-header-custom {
        border-bottom-color: #222d4a !important;
    }

    body.dark-mode .report-card {
        background: #1a233a !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    body.dark-mode .report-card:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25) !important;
        background: #1f2a45 !important;
    }

    body.dark-mode .style-payment .icon-container {
        background: rgba(30, 41, 66, 0.8) !important;
        color: #60a5fa !important;
        border: 1px solid rgba(96, 165, 250, 0.2);
    }

    body.dark-mode .style-payment .btn-view {
        color: #60a5fa !important;
    }

    body.dark-mode .style-balance .icon-container {
        background: rgba(30, 41, 66, 0.8) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    body.dark-mode .style-balance .btn-view {
        color: #fbbf24 !important;
    }
</style>

<div class="reports-premium-wrapper">
    <div class="container-fluid p-4">

        <div class="page-header-custom">
            <h4 class="text-dark">
                <i class="fa fa-chart-pie text-primary mr-2"></i>
                Trung tâm Tổng hợp Báo cáo
            </h4>

            <small class="text-muted">
                Lựa chọn phân mục biểu mẫu báo cáo dữ liệu muốn rà soát chi tiết
            </small>
        </div>

        <div class="row">

            <div class="col-md-6 mb-4">
                <div class="card report-card style-payment"
                     onclick="window.location='{{ url('/admin/payment-report') }}'">

                    <div class="d-flex align-items-center">

                        <div class="icon-container mr-4">
                            <i class="fa fa-file-invoice-dollar"></i>
                        </div>

                        <div>
                            <h5 class="card-title-custom text-dark">
                                Báo cáo Doanh thu
                            </h5>

                            <p class="card-desc-custom text-muted">
                                Thống kê chi tiết các khoản thu, hóa đơn thanh toán và doanh thu theo tháng.
                            </p>

                            <span class="btn-view">
                                Xem báo cáo thống kê
                                <i class="fa fa-arrow-right ml-2"
                                   style="transition: transform 0.2s;"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card report-card style-balance"
                     onclick="window.location='{{ url('/admin/balance-report') }}'">

                    <div class="d-flex align-items-center">

                        <div class="icon-container mr-4">
                            <i class="fa fa-balance-scale"></i>
                        </div>

                        <div>
                            <h5 class="card-title-custom text-dark">
                                Báo cáo Dư nợ
                            </h5>

                            <p class="card-desc-custom text-muted">
                                Theo dõi công nợ, số dư cư dân và quản lý tiền cọc phòng.
                            </p>

                            <span class="btn-view">
                                Xem báo cáo công nợ
                                <i class="fa fa-arrow-right ml-2"
                                   style="transition: transform 0.2s;"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection