<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cổng Thanh Toán | Quản Gia 5.0</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        body { background-color: #f1f5f9; font-family: 'Poppins', sans-serif; color: #1e293b; }

        .sandbox-ribbon {
            background: #ef4444; color: white; text-align: center; font-size: 0.85rem;
            font-weight: 700; padding: 10px; letter-spacing: 2px; text-transform: uppercase;
        }

        .payment-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            padding: 40px 0 100px 0;
            color: white;
            position: relative;
        }

        .brand-logo {
            font-size: 1.6rem; font-weight: 800; letter-spacing: -0.5px;
            display: flex; align-items: center;
        }

        .brand-logo i { color: #f59e0b; margin-right: 12px; font-size: 1.8rem; }

        .payment-wrapper {
            max-width: 1050px; margin: -60px auto 50px auto;
            background: #ffffff; border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
            overflow: hidden; border: 1px solid #e2e8f0;
            position: relative; z-index: 10;
        }

        .order-info-col {
            background: #f8fafc;
            padding: 45px 40px !important;
            border-right: 1px dashed #cbd5e1;
        }

        .col-title {
            font-weight: 800; color: #0f172a; margin-bottom: 30px;
            font-size: 1.25rem; display: flex; align-items: center;
        }

        .col-title i { color: #2563eb; margin-right: 10px; }

        .info-row {
            display: flex; justify-content: space-between; align-items: flex-start;
            margin-bottom: 18px; font-size: 0.95rem;
        }

        .info-label { color: #64748b; font-weight: 500; flex-shrink: 0; margin-right: 15px; }
        .info-value { font-weight: 700; color: #1e293b; text-align: right; word-break: break-word; }

        .amount-box {
            background: #eff6ff; border: 2px dashed #93c5fd;
            padding: 25px 20px; text-align: center; border-radius: 16px;
            margin-top: 35px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.05);
        }

        .amount-label {
            color: #3b82f6; font-size: 0.85rem; font-weight: 700;
            text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;
        }

        .amount-value {
            color: #1d4ed8; font-size: 2.2rem; font-weight: 800; line-height: 1;
        }

        .payment-method-col {
            padding: 45px 50px !important;
            background: #ffffff;
        }

        .custom-nav-pills {
            background: #f1f5f9; border-radius: 50px; padding: 6px;
            display: flex; margin-bottom: 35px; border: 1px solid #e2e8f0;
        }

        .custom-nav-pills .nav-item { flex: 1; text-align: center; }

        .custom-nav-pills .nav-link {
            border: none; color: #64748b; font-weight: 600;
            padding: 12px 20px; border-radius: 50px;
            transition: all 0.3s ease; font-size: 0.95rem;
        }

        .custom-nav-pills .nav-link.active {
            color: #ffffff; background: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .custom-nav-pills .nav-link:hover:not(.active) { color: #2563eb; }

        .bank-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .bank-logo {
            border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px;
            text-align: center; cursor: pointer; transition: all 0.3s ease;
            background: #ffffff; height: 65px; display: flex;
            align-items: center; justify-content: center;
        }

        .bank-logo img {
            max-width: 100%; max-height: 35px; object-fit: contain;
            filter: grayscale(100%); opacity: 0.7; transition: 0.3s;
        }

        .bank-logo:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.12);
            transform: translateY(-4px);
        }

        .bank-logo:hover img { filter: grayscale(0%); opacity: 1; }

        .card-form-wrapper {
            display: none; background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 20px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }

        .form-label-custom {
            font-size: 0.8rem; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;
        }

        .form-control-custom {
            border-radius: 12px; border: 1px solid #cbd5e1; padding: 14px 20px;
            font-size: 1rem; color: #1e293b; font-weight: 600; background: #f8fafc;
            transition: all 0.3s;
        }

        .form-control-custom:focus {
            border-color: #3b82f6; background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); outline: none;
        }

        .btn-back-banks {
            color: #64748b; cursor: pointer; font-weight: 600; font-size: 0.95rem;
            transition: 0.2s; margin-bottom: 25px; display: inline-flex; align-items: center;
        }

        .btn-back-banks:hover { color: #2563eb; transform: translateX(-3px); }

        .qr-wrapper { text-align: center; padding: 10px 0; }

        .qr-box {
            background: white; padding: 20px; border-radius: 20px; display: inline-block;
            border: 2px dashed #94a3b8; box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .qr-instruction { font-size: 1rem; color: #475569; margin-bottom: 25px; font-weight: 500; }

        .btn-pay-submit {
            background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
            color: white; font-weight: 700; padding: 16px; border-radius: 50px;
            border: none; width: 100%; font-size: 1.1rem; transition: 0.3s;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3); letter-spacing: 0.5px;
        }

        .btn-pay-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.45);
            color: white;
        }

        .btn-cancel {
            background: #ffffff; color: #ef4444; font-weight: 600; padding: 14px;
            border-radius: 50px; border: 1px solid #fecaca; width: 100%; transition: 0.3s;
            display: flex; align-items: center; justify-content: center; text-decoration: none !important;
            margin-top: 30px;
        }

        .btn-cancel:hover {
            background: #fef2f2; border-color: #ef4444; color: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
        }

        @media (max-width: 991px) {
            .order-info-col { padding: 35px 25px !important; border-right: none; border-bottom: 1px dashed #cbd5e1; }
            .payment-method-col { padding: 35px 25px !important; }
            .bank-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 576px) {
            .bank-grid { grid-template-columns: repeat(2, 1fr); }
            .custom-nav-pills { flex-direction: column; border-radius: 16px; }
            .custom-nav-pills .nav-link { border-radius: 12px; margin-bottom: 5px; }
        }
    </style>
</head>
<body>

<div class="sandbox-ribbon">
    <i class="fa fa-vial mr-2"></i> MÔI TRƯỜNG THANH TOÁN GIẢ LẬP (SANDBOX) - ĐỒ ÁN QUẢN GIA 5.0
</div>

<div class="payment-banner">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <i class="fa fa-laptop-house"></i> QUẢN GIA PAY
        </div>
        <div class="d-none d-md-flex align-items-center font-weight-medium" style="font-size: 0.95rem;">
            <i class="fa fa-shield-alt mr-2" style="color: #4ade80;"></i> Giao dịch bảo mật 256-bit
        </div>
    </div>
</div>

<div class="container">
    <div class="payment-wrapper row no-gutters">
        <div class="col-lg-4 order-info-col">
            <h5 class="col-title"><i class="fa fa-receipt"></i> Chi tiết giao dịch</h5>

            <div class="info-row">
                <span class="info-label">Mã tham chiếu:</span>
                <span class="info-value">#{{ $txn_ref }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Hợp đồng vay:</span>
                <span class="info-value">TG{{ $req_id }} (Kỳ {{ $period }})</span>
            </div>

            <div class="info-row">
                <span class="info-label">Nội dung CK:</span>
                <span class="info-value">{{ $info }}</span>
            </div>

            <div class="amount-box">
                <div class="amount-label">Số tiền thanh toán</div>
                <div class="amount-value">
                    {{ number_format($amount, 0, ',', '.') }}
                    <small style="font-size:1.1rem; font-weight: 600;">VND</small>
                </div>
            </div>

            <form action="{{ route('vnpay.return') }}" method="GET" class="mt-5 pt-3 border-top">
                <input type="hidden" name="vnp_ResponseCode" value="24">
                <input type="hidden" name="req_id" value="{{ $req_id }}">
                <button type="submit" class="btn-cancel">
                    <i class="fa fa-times-circle mr-2"></i> HỦY GIAO DỊCH
                </button>
            </form>
        </div>

        <div class="col-lg-8 payment-method-col">
            <h5 class="col-title"><i class="fa fa-wallet"></i> Chọn phương thức</h5>

            <ul class="nav custom-nav-pills" id="paymentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="qr-tab" data-toggle="tab" href="#qr" role="tab">
                        <i class="fa fa-qrcode mr-2"></i>Ứng dụng Ngân hàng (QR)
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="card-tab" data-toggle="tab" href="#card" role="tab">
                        <i class="fa fa-credit-card mr-2"></i>Thẻ ATM Nội địa
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="paymentTabsContent">
                <div class="tab-pane fade show active" id="qr" role="tabpanel">
                    <div class="qr-wrapper">
                        <div class="qr-instruction">
                            Mở ứng dụng <b>Mobile Banking</b> hoặc <b>Ví Điện Tử</b> bất kỳ để quét mã
                        </div>

                        <div class="qr-box">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($qr_data) }}&color=0f172a" alt="QG-PAY QR">
                        </div>

                        <p class="text-danger font-weight-bold small mb-4">
                            <i class="fa fa-spinner fa-spin mr-2"></i>Hệ thống đang chờ khách hàng quét mã...
                        </p>

                        <form action="{{ route('vnpay.return') }}" method="GET">
                            <input type="hidden" name="vnp_ResponseCode" value="00">
                            <input type="hidden" name="req_id" value="{{ $req_id }}">
                            <input type="hidden" name="period" value="{{ $period }}">
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="vnp_TxnRef" value="{{ $txn_ref }}">

                            <button type="submit" class="btn btn-outline-success font-weight-bold rounded-pill px-4 shadow-sm" style="border-width: 2px;">
                                <i class="fa fa-magic mr-2"></i>[Dev] Mô phỏng quét mã thành công
                            </button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="card" role="tabpanel">
                    <div id="bank-selection-grid">
                        <p class="text-muted small mb-3 font-weight-medium">
                            Vui lòng chọn ngân hàng phát hành thẻ của bạn:
                        </p>

                        <div class="bank-grid">
                            <div class="bank-logo" onclick="openCardForm('Vietcombank')"><img src="https://vnpay.vn/s1/banks/VIETCOMBANK.png" alt="VCB"></div>
                            <div class="bank-logo" onclick="openCardForm('VietinBank')"><img src="https://vnpay.vn/s1/banks/VIETINBANK.png" alt="CTG"></div>
                            <div class="bank-logo" onclick="openCardForm('BIDV')"><img src="https://vnpay.vn/s1/banks/BIDV.png" alt="BIDV"></div>
                            <div class="bank-logo" onclick="openCardForm('Agribank')"><img src="https://vnpay.vn/s1/banks/AGRIBANK.png" alt="AGR"></div>
                            <div class="bank-logo" onclick="openCardForm('Techcombank')"><img src="https://vnpay.vn/s1/banks/TECHCOMBANK.png" alt="TCB"></div>
                            <div class="bank-logo" onclick="openCardForm('MBBank')"><img src="https://vnpay.vn/s1/banks/MBBANK.png" alt="MB"></div>
                            <div class="bank-logo" onclick="openCardForm('ACB')"><img src="https://vnpay.vn/s1/banks/ACB.png" alt="ACB"></div>
                            <div class="bank-logo" onclick="openCardForm('VPBank')"><img src="https://vnpay.vn/s1/banks/VPBANK.png" alt="VPB"></div>
                            <div class="bank-logo" onclick="openCardForm('TPBank')"><img src="https://vnpay.vn/s1/banks/TPBANK.png" alt="TPB"></div>
                            <div class="bank-logo" onclick="openCardForm('Sacombank')"><img src="https://vnpay.vn/s1/banks/SACOMBANK.png" alt="STB"></div>
                            <div class="bank-logo" onclick="openCardForm('HDBank')"><img src="https://vnpay.vn/s1/banks/HDBANK.png" alt="HDB"></div>
                            <div class="bank-logo" onclick="openCardForm('NCB')"><img src="https://vnpay.vn/s1/banks/NCB.png" alt="NCB"></div>
                        </div>
                    </div>

                    <div class="card-form-wrapper" id="card-input-form">
                        <div class="btn-back-banks" onclick="showBankGrid()">
                            <i class="fa fa-arrow-left mr-2"></i> Chọn lại ngân hàng
                        </div>

                        <h6 class="font-weight-bold text-dark mb-4 pb-3 border-bottom" style="font-size: 1.1rem;">
                            Nhập thông tin thẻ <span id="selected-bank-name" class="text-primary"></span>
                        </h6>

                        <form action="{{ route('vnpay.return') }}" method="GET" id="vnpayMockForm">
                            <input type="hidden" name="vnp_ResponseCode" value="00">
                            <input type="hidden" name="req_id" value="{{ $req_id }}">
                            <input type="hidden" name="period" value="{{ $period }}">
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="vnp_TxnRef" value="{{ $txn_ref }}">

                            <div class="form-group mb-4">
                                <label class="form-label-custom">Số in trên thẻ</label>
                                <input type="text" class="form-control-custom w-100" value="9704 1985 2619 1432" readonly>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label-custom">Tên chủ thẻ (Không dấu)</label>
                                <input type="text" class="form-control-custom w-100" value="NGUYEN PHI HUNG" readonly>
                            </div>

                            <div class="form-group mb-5">
                                <label class="form-label-custom">Ngày phát hành (MM/YY)</label>
                                <input type="text" class="form-control-custom w-100" value="07/22" readonly>
                            </div>

                            <button type="submit" class="btn-pay-submit" id="btnConfirmPay">
                                THỰC HIỆN THANH TOÁN <i class="fa fa-shield-alt ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center text-muted small pb-4" style="font-weight: 500;">
    Bản quyền thuộc về Hệ sinh thái Bất động sản Quản Gia 5.0 © {{ date('Y') }}.<br>
    <i>*Giao diện cổng thanh toán mô phỏng phục vụ mục đích kiểm thử đồ án.*</i>
</div>

<script>
    function openCardForm(bankName) {
        $('#bank-selection-grid').hide();
        $('#selected-bank-name').text(bankName);
        $('#card-input-form').fadeIn(300);
    }

    function showBankGrid() {
        $('#card-input-form').hide();
        $('#bank-selection-grid').fadeIn(300);
    }

    $('#vnpayMockForm').submit(function(){
        $('#btnConfirmPay').html('<i class="fa fa-spinner fa-spin mr-2"></i>ĐANG XỬ LÝ GIAO DỊCH...').prop('disabled', true);
    });
</script>

</body>
</html>