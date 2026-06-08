@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { background-color: #f8f9fc; font-family: 'Poppins', sans-serif; }

    .installment-header-banner {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        padding: 70px 0 80px 0;
        color: white;
        text-align: center;
        margin-bottom: -50px;
        border-radius: 0 0 50px 50px;
        box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
    }

    .installment-header-banner h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .installment-header-banner p {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    .text-gold { color: #f4b619; }

    .premium-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .premium-card-header {
        background: #ffffff;
        padding: 25px 30px 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .premium-card-body {
        padding: 30px;
    }

    .custom-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .custom-select-premium,
    .custom-input-premium {
        height: 55px;
        border-radius: 15px;
        border: 2px solid #e2e8f0;
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
        padding: 10px 20px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .custom-select-premium:focus,
    .custom-input-premium:focus {
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    .btn-group-toggle .btn {
        border-radius: 15px !important;
        margin: 0 5px;
        border: 2px solid #e2e8f0;
        color: #64748b;
        background: #ffffff;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-group-toggle .btn.active {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #2563eb;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
    }

    .btn-gold-submit {
        background: #f4b619;
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.05rem;
        padding: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(244, 182, 25, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-gold-submit:hover {
        background: #dfa00b;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(244, 182, 25, 0.4);
        color: white;
    }

    .result-box-total {
        background: #f8f9fc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        height: 100%;
    }

    .result-box-monthly {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 16px;
        padding: 20px;
        color: white;
        height: 100%;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .res-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        opacity: 0.9;
    }

    .res-val {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .table-installment {
        margin-top: 20px;
    }

    .table-installment th {
        border-top: none;
        font-size: 0.85rem;
        color: #64748b;
        text-transform: uppercase;
    }

    .table-installment td {
        font-size: 0.95rem;
        vertical-align: middle;
        border-bottom: 1px dashed #e2e8f0;
        padding: 12px 10px;
    }

    .table-installment tr:last-child td {
        border-bottom: none;
    }
</style>
@endpush

@section('content')

<div class="installment-header-banner">
    <div class="container">
        <h2>Dự Toán <span class="text-gold">Tài Chính</span></h2>
        <p>Lên kế hoạch sở hữu không gian sống thông minh cùng Quản Gia 5.0</p>
    </div>
</div>

<div class="container mb-5" style="position: relative; z-index: 5; margin-top: 20px;">
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card premium-card">
                <div class="premium-card-header">
                    <h5 class="font-weight-bold text-dark mb-0">
                        <i class="fa fa-sliders-h text-primary mr-2"></i> Thiết lập gói vay
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form id="installmentForm">
                        @csrf

                        <div class="form-group mb-4">
                            <label class="custom-label">Chọn mã phòng:</label>

                            <select class="form-control custom-select-premium" id="roomSelect" onchange="updatePriceFromSelect()">
                                <option value="0" data-id="0" data-no="0">-- Mời chọn căn hộ --</option>

                                @foreach($rooms as $room)
                                    @php
                                        $realSalePrice = ($room->sale_price > 0) ? $room->sale_price : ($room->price * 100);
                                        $isSelected = request('id') == $room->id ? 'selected' : '';
                                    @endphp

                                    <option value="{{ $realSalePrice }}"
                                            data-id="{{ $room->id }}"
                                            data-no="Phòng {{ $room->house_no }}"
                                            {{ $isSelected }}>
                                        Phòng {{ $room->house_no }} ({{ number_format($realSalePrice, 0, ',', '.') }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="custom-label">Hoặc nhập số tiền (VNĐ):</label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control custom-input-premium"
                                       id="customPrice"
                                       placeholder="Ví dụ: 300000000"
                                       oninput="calculateInstallment()">
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <label class="custom-label">Kỳ hạn thanh toán:</label>

                            <div class="btn-group btn-group-toggle w-100 d-flex" data-toggle="buttons">
                                <label class="btn active flex-fill py-3">
                                    <input type="radio" name="months" value="3" checked onchange="calculateInstallment()"> 3 Tháng
                                </label>

                                <label class="btn flex-fill py-3">
                                    <input type="radio" name="months" value="6" onchange="calculateInstallment()"> 6 Tháng
                                </label>

                                <label class="btn flex-fill py-3">
                                    <input type="radio" name="months" value="12" onchange="calculateInstallment()"> 12 Tháng
                                </label>
                            </div>
                        </div>

                        <button type="button" class="btn btn-gold-submit btn-block" onclick="submitInstallment()">
                            ĐĂNG KÝ TƯ VẤN NGAY <i class="fa fa-arrow-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card premium-card" style="min-height: 100%;">
                <div class="premium-card-body d-flex flex-column">

                    <div id="resultArea" style="display: none;">
                        <h5 class="font-weight-bold text-dark mb-4">
                            <i class="fa fa-chart-pie text-success mr-2"></i> Bảng phân bổ dòng tiền
                        </h5>

                        <div class="row mb-4">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="result-box-total">
                                    <div class="res-label text-muted">Tổng giá trị căn hộ</div>
                                    <div class="res-val text-dark" id="resTotal">0 đ</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="result-box-monthly">
                                    <div class="res-label text-white-50">Thanh toán mỗi tháng</div>
                                    <div class="res-val text-white" id="resMonthly">0 đ</div>
                                </div>
                            </div>
                        </div>

                        <h6 class="font-weight-bold text-dark mb-3" style="font-size: 0.95rem;">Lịch trình chi tiết:</h6>

                        <div class="table-responsive pr-2" style="max-height: 280px; overflow-y: auto;">
                            <table class="table table-borderless table-installment w-100 m-0">
                                <thead>
                                    <tr>
                                        <th class="pl-2">Kỳ thanh toán</th>
                                        <th class="text-right pr-2">Số tiền</th>
                                        <th class="text-center" width="100">Trạng thái</th>
                                    </tr>
                                </thead>

                                <tbody id="paymentTable"></tbody>
                            </table>
                        </div>
                    </div>

                    <div id="emptyArea" class="text-center m-auto py-5">
                        <img src="{{ asset('assets/img/calc-illustration.svg') }}"
                             onerror="this.style.display='none'"
                             style="height: 140px; opacity: 0.5; margin-bottom: 20px;">

                        <i class="fa fa-calculator fa-4x text-light mb-3" style="display: block;"></i>

                        <h5 class="font-weight-bold text-secondary">Chưa có dữ liệu</h5>

                        <p class="text-muted small">
                            Vui lòng chọn mã phòng hoặc nhập số tiền để xem bảng tính chi tiết.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('roomSelect').value > 0) {
            updatePriceFromSelect();
        }
    });

    function updatePriceFromSelect() {
        const select = document.getElementById('roomSelect');
        const price = select.value;

        if (price > 0) {
            document.getElementById('customPrice').value = price;
            calculateInstallment();
        } else {
            document.getElementById('customPrice').value = '';
            calculateInstallment();
        }
    }

    function calculateInstallment() {
        const price = parseFloat(document.getElementById('customPrice').value) || 0;
        const months = document.querySelector('input[name="months"]:checked').value;

        if (price > 0) {
            document.getElementById('emptyArea').style.display = 'none';
            document.getElementById('resultArea').style.display = 'block';

            const monthly = Math.round(price / months);

            document.getElementById('resTotal').innerText = new Intl.NumberFormat('vi-VN').format(price) + ' đ';
            document.getElementById('resMonthly').innerText = new Intl.NumberFormat('vi-VN').format(monthly) + ' đ';

            let tableHTML = '';

            for (let i = 1; i <= months; i++) {
                tableHTML += `
                    <tr>
                        <td class="font-weight-bold text-secondary pl-2">
                            <i class="fa fa-calendar-check text-primary opacity-50 mr-2"></i> Tháng thứ ${i}
                        </td>
                        <td class="text-right font-weight-bold text-dark pr-2">
                            ${new Intl.NumberFormat('vi-VN').format(monthly)} đ
                        </td>
                        <td class="text-center">
                            <span class="badge badge-light text-muted border px-2 py-1">Chưa đóng</span>
                        </td>
                    </tr>
                `;
            }

            document.getElementById('paymentTable').innerHTML = tableHTML;
        } else {
            document.getElementById('emptyArea').style.display = 'block';
            document.getElementById('resultArea').style.display = 'none';
        }
    }

    function submitInstallment() {
        const price = parseFloat(document.getElementById('customPrice').value) || 0;
        const months = document.querySelector('input[name="months"]:checked').value;
        const select = document.getElementById('roomSelect');

        if (select.value == 0 || price <= 0) {
            alert('Vui lòng chọn phòng!');
            return;
        }

        const option = select.options[select.selectedIndex];
        const house_id = option.getAttribute('data-id');
        const room_info = option.getAttribute('data-no');
        const monthly_pay = document.getElementById('resMonthly').innerText.replace(/[^\d]/g, '');

        $.ajax({
            url: "{{ route('installment.store') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                house_id: house_id,
                room_info: room_info,
                total_price: price,
                months: months,
                monthly_pay: monthly_pay
            },
            success: function(resp) {
                if (String(resp).trim() == '1') {
                    alert("Đăng ký thành công! Hệ thống sẽ chuyển về trang chủ.");
                    window.location.href = "{{ route('home') }}";
                } else if (String(resp).trim() == '2') {
                    alert("Bạn đã gửi yêu cầu cho phòng này rồi, vui lòng chờ Quản Gia liên hệ!");
                } else if (String(resp).trim() == '3') {
                    alert("Vui lòng đăng nhập trước khi gửi yêu cầu!");
                } else {
                    alert("Lỗi hệ thống, vui lòng thử lại sau.");
                }
            },
            error: function() {
                alert("Không kết nối được server! Vui lòng kiểm tra lại mạng.");
            }
        });
    }
</script>
@endpush