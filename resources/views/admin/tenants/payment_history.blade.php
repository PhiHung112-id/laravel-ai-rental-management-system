@php
    $tenantName = trim(
        ($tenant->lastname ?? '') . ', ' .
        ($tenant->firstname ?? '') . ' ' .
        ($tenant->middlename ?? '')
    );

    $house = $tenant->house;

    $payments = $tenant->payments->sortByDesc(function ($p) {
        return $p->date_created ?? $p->created_at;
    });

    $latest = $payments->first();
@endphp

<style>
    .receipt-container {
        font-family: 'Poppins', sans-serif;
        color: #444;
    }

    .receipt-header {
        border-bottom: 2px dashed #e3e6f0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .invoice-badge {
        background: #e3f2fd;
        color: #1565c0;
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .info-box {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 18px;
        border: 1px solid #eaecf4;
    }

    .table-history thead th {
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 12px;
        border-bottom: 2px solid #eee;
    }

    .table-history tbody td {
        padding: 12px;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .text-success-custom {
        color: #2e7d32;
        font-weight: 700;
    }

    .text-primary-custom {
        color: #4e73df;
        font-weight: 600;
    }
</style>

<div class="container-fluid receipt-container py-2">

    <div class="receipt-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="text-primary font-weight-bold mb-1">
                <i class="fa fa-receipt mr-2"></i>
                BIÊN LAI THU TIỀN VÀ DỊCH VỤ
            </h4>

            <small class="text-muted">
                Ngày lập hóa đơn:
                @if($latest)
                    {{ date('d/m/Y H:i', strtotime($latest->date_created ?? $latest->created_at)) }}
                @else
                    Chưa cập nhật
                @endif
            </small>
        </div>

        <div>
            <span class="invoice-badge">
                Mã Số: #{{ $latest->invoice ?? 'Chưa có' }}
            </span>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="info-box shadow-sm">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <span class="text-muted small d-block">
                            Khách hàng thuê phòng:
                        </span>

                        <strong class="text-dark" style="font-size: 1.05rem;">
                            {{ $tenantName ? ucwords($tenantName) : 'Không rõ danh tính' }}
                        </strong>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <span class="text-muted small d-block">
                            Phòng đang lưu trú:
                        </span>

                        <strong class="text-primary-custom">
                            Phòng {{ $house->house_no ?? 'N/A' }}
                        </strong>

                        <span class="text-muted small">
                            (Giá cứng:
                            {{ number_format($house->price ?? 0, 0, ',', '.') }}đ / tháng)
                        </span>
                    </div>
                </div>

                <hr class="my-3" style="border-top: 1px solid #eaecf4;">

                <div class="row mt-2">
                    <div class="col-sm-4 mb-2">
                        <span class="text-muted small d-block">
                            <i class="fa fa-bolt text-warning mr-1"></i>
                            Tiền điện kỳ gần nhất:
                        </span>

                        <span class="font-weight-bold text-dark">
                            {{ number_format($latest->cost_electric ?? 0, 0, ',', '.') }} đ
                        </span>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <span class="text-muted small d-block">
                            <i class="fa fa-tint text-info mr-1"></i>
                            Tiền nước kỳ gần nhất:
                        </span>

                        <span class="font-weight-bold text-dark">
                            {{ number_format($latest->cost_water ?? 0, 0, ',', '.') }} đ
                        </span>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <span class="text-muted small d-block">
                            <i class="fa fa-money-check-alt text-success mr-1"></i>
                            Tổng thực thu gần nhất:
                        </span>

                        <span class="text-success-custom" style="font-size: 1.15rem;">
                            {{ number_format($latest->amount ?? 0, 0, ',', '.') }} VNĐ
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h6 class="font-weight-bold text-secondary mb-3">
        <i class="fa fa-history mr-2"></i>
        Lịch sử đóng tiền chi tiết của khách này
    </h6>

    <div class="table-responsive">
        <table class="table table-bordered table-history mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" width="8%">#</th>
                    <th>Mã Hóa Đơn</th>
                    <th class="text-right">Tiền điện</th>
                    <th class="text-right">Tiền nước</th>
                    <th class="text-right">Số tiền đóng</th>
                    <th class="text-center">Ngày đóng</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $key => $p)
                    <tr class="{{ $latest && $p->id == $latest->id ? 'table-primary font-weight-bold' : '' }}">
                        <td class="text-center text-muted">
                            {{ $key + 1 }}
                        </td>

                        <td>
                            #{{ $p->invoice }}
                        </td>

                        <td class="text-right text-muted">
                            {{ number_format($p->cost_electric ?? 0, 0, ',', '.') }}đ
                        </td>

                        <td class="text-right text-muted">
                            {{ number_format($p->cost_water ?? 0, 0, ',', '.') }}đ
                        </td>

                        <td class="text-right text-success-custom">
                            {{ number_format($p->amount ?? 0, 0, ',', '.') }}đ
                        </td>

                        <td class="text-center text-muted small">
                            {{ date('d/m/Y', strtotime($p->date_created ?? $p->created_at)) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            Không tìm thấy lịch sử thanh toán liên quan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>