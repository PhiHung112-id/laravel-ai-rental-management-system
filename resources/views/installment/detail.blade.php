@extends('layouts.app')

@push('styles')
<style>
    body { background-color: #f4f7fe; font-family: 'Poppins', sans-serif; }

    .installment-banner {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 50px 0 80px 0;
        color: white;
        border-radius: 0 0 40px 40px;
        position: relative;
    }

    .fintech-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.02);
        padding: 35px;
        position: relative;
        margin-top: -50px;
        z-index: 10;
        height: 100%;
    }

    .house-thumb {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .fin-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .fin-value {
        font-size: 1.15rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .fin-value.highlight {
        color: #f59e0b;
        font-size: 1.4rem;
    }

    .status-badge {
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
    }

    .status-0 { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .status-1 { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .status-2 { background: #e0e7ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    .timeline-schedule {
        position: relative;
        padding-left: 30px;
        margin-top: 20px;
        max-height: 550px;
        overflow-y: auto;
        padding-right: 15px;
    }

    .timeline-schedule::-webkit-scrollbar { width: 6px; }
    .timeline-schedule::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }

    .timeline-schedule::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 10px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .schedule-item {
        position: relative;
        margin-bottom: 25px;
        background: #f8fafc;
        border-radius: 16px;
        padding: 15px 20px;
        border: 1px solid #f1f5f9;
        transition: 0.3s;
    }

    .schedule-item:hover {
        background: #ffffff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: #cbd5e1;
    }

    .schedule-item::before {
        content: '';
        position: absolute;
        left: -28px;
        top: 20px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #cbd5e1;
        box-shadow: 0 0 0 3px #fff;
        z-index: 2;
    }

    .schedule-item.paid::before { border-color: #22c55e; background: #22c55e; }
    .schedule-item.paid { border-left: 4px solid #22c55e; }

    .schedule-item.current::before {
        border-color: #3b82f6;
        background: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
    }

    .schedule-item.current {
        border-left: 4px solid #3b82f6;
        background: #eff6ff;
    }

    .schedule-item.pending::before { border-color: #cbd5e1; }
    .schedule-item.pending { opacity: 0.7; }

    .sch-month {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
    }

    .sch-date {
        font-size: 0.8rem;
        color: #64748b;
    }

    .sch-amount {
        font-size: 1.1rem;
        font-weight: 800;
        color: #2563eb;
    }

    .btn-vnpay-custom {
        background: #005baa;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0, 91, 170, 0.3);
        display: inline-flex;
        align-items: center;
        text-decoration: none !important;
    }

    .btn-vnpay-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 91, 170, 0.4);
        color: white;
    }

    .btn-vnpay-custom img {
        background: white;
        border-radius: 2px;
        padding: 1px;
        margin-right: 6px;
    }
</style>
@endpush

@section('content')
@php
    $house = $req->house;
    $sale_price = $sale_price ?? (($house->sale_price > 0) ? $house->sale_price : ($house->price * 100));
    $months = $months ?? (($req->months > 0) ? $req->months : 12);
    $monthly_pay = $monthly_pay ?? round($sale_price / $months);
    $startDate = $req->created_at ?? now();

    $img = !empty($house->img_path)
        ? asset('assets/uploads/' . str_replace(' ', '%20', $house->img_path))
        : asset('assets/uploads/no-image.jpg');
@endphp

<div class="installment-banner">
    <div class="container text-center">
        <h2 class="font-weight-bold mb-2">Chi Tiết Hợp Đồng Trả Góp</h2>
        <p class="mb-0 opacity-75">Quản lý và theo dõi tiến trình thanh toán tài sản của bạn</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">

        <div class="col-lg-5 mb-4">
            <div class="fintech-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="font-weight-bold text-dark mb-0">Hợp đồng #TG{{ $req->id }}</h5>

                    <span class="status-badge status-{{ $req->status }}">
                        @if($req->status == 0)
                            Chờ xét duyệt
                        @elseif($req->status == 1)
                            <i class="fa fa-check-circle mr-1"></i> Đang hiệu lực
                        @elseif($req->status == 2)
                            Đã tất toán
                        @else
                            Từ chối
                        @endif
                    </span>
                </div>

                <img src="{{ $img }}" class="house-thumb" alt="Phòng {{ $house->house_no }}">

                <div class="fin-label">Tài sản đảm bảo</div>
                <div class="fin-value" style="font-size: 1.3rem;">
                    Phòng {{ $house->house_no }}
                    <span class="text-muted font-weight-medium" style="font-size: 0.9rem;">
                        ({{ $house->category->name ?? 'Chưa phân loại' }})
                    </span>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="fin-label">Tổng giá trị</div>
                        <div class="fin-value">{{ number_format($sale_price, 0, ',', '.') }} đ</div>
                    </div>

                    <div class="col-6">
                        <div class="fin-label">Kỳ hạn vay</div>
                        <div class="fin-value">{{ $months }} Tháng</div>
                    </div>
                </div>

                <div class="p-3 mt-2 mb-4" style="background: #fffdf5; border: 1px dashed #fcd34d; border-radius: 16px;">
                    <div class="fin-label text-warning">Thanh toán định kỳ mỗi tháng</div>
                    <div class="fin-value highlight mb-0">{{ number_format($monthly_pay, 0, ',', '.') }} đ</div>
                </div>

                <div class="fin-label">Ngày khởi tạo hợp đồng</div>
                <div class="fin-value" style="font-size: 1rem;">
                    <i class="fa fa-calendar-check text-primary mr-2"></i>
                    {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y - H:i') }}
                </div>

                <a href="{{ route('profile') }}"
                   class="btn btn-light btn-block font-weight-bold text-muted py-3 mt-4"
                   style="border-radius: 50px; border: 1px solid #e2e8f0;">
                    <i class="fa fa-arrow-left mr-2"></i> Quay lại Hồ sơ
                </a>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="fintech-card">
                <h4 class="font-weight-bold text-dark mb-1">Lịch Trình Thanh Toán</h4>
                <p class="text-muted small mb-4">Danh sách các kỳ hạn cần thanh toán theo hợp đồng số liệu mô phỏng.</p>

                @if($req->status == 0)
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/2928/2928846.png" width="120" class="mb-3 opacity-50" alt="Pending">
                        <h5 class="font-weight-bold text-secondary">Hồ sơ đang chờ thẩm định</h5>
                        <p class="text-muted small px-4">
                            Lịch trình thanh toán sẽ được tự động thiết lập ngay sau khi Ban quản lý phê duyệt yêu cầu trả góp của bạn.
                        </p>
                    </div>
                @else
                    <div class="timeline-schedule">
                        @php
                            $active_period_found = false;
                        @endphp

                        @for($i = 1; $i <= $months; $i++)
                            @php
                                $payDate = \Carbon\Carbon::parse($startDate)->addMonths($i)->format('d/m/Y');

                                if(isset($paid_data[$i])) {
                                    if($paid_data[$i] == 1) {
                                        $sch_class = 'paid';
                                        $sch_status = '<span class="badge badge-success px-2 py-1"><i class="fa fa-check mr-1"></i>Đã thu</span>';
                                    } else {
                                        $sch_class = 'current';
                                        $sch_status = '<span class="badge px-3 py-2 text-dark font-weight-bold shadow-sm" style="background: #fde047; border: 1px solid #facc15;"><i class="fa fa-spinner fa-spin mr-1"></i> Chờ xác nhận</span>';
                                    }
                                } else {
                                    if(!$active_period_found) {
                                        $sch_class = 'current';
                                        $content_transfer = 'Thanh toan tra gop HD ' . $req->id . ' ky ' . $i;

                                        $payUrl = route('mock.vnpay', [
                                            'req_id' => $req->id,
                                            'period' => $i,
                                            'amount' => $monthly_pay,
                                            'info' => $content_transfer,
                                        ]);

                                        $sch_status = '<a href="'.$payUrl.'" class="btn-vnpay-custom">
                                            <img src="https://vnpay.vn/s1/statics.vnpay.vn/2023/9/06ncktiwd6dc1694418189687.png" height="14" alt="VNPAY">
                                            Thanh toán VNPAY
                                        </a>';

                                        $active_period_found = true;
                                    } else {
                                        $sch_class = 'pending';
                                        $sch_status = '<span class="badge badge-light text-muted px-2 py-1 border">Chờ đến hạn</span>';
                                    }
                                }
                            @endphp

                            <div class="schedule-item {{ $sch_class }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="sch-month">Kỳ {{ $i }} / {{ $months }}</div>
                                        <div class="sch-date">
                                            <i class="fa fa-clock mr-1"></i>
                                            Hạn chót: {{ $payDate }}
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <div class="sch-amount">{{ number_format($monthly_pay, 0, ',', '.') }} đ</div>
                                        <div class="mt-1">{!! $sch_status !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection