<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Kết quả giao dịch</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <style>
        body{
            background:#f1f5f9;
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:100vh;
            font-family:'Poppins',sans-serif;
        }

        .result-card{
            background:white;
            border-radius:24px;
            padding:50px 40px;
            width:100%;
            max-width:480px;
            text-align:center;
            box-shadow:0 20px 50px rgba(0,0,0,.08);
        }

        .icon-circle{
            width:90px;
            height:90px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 25px;
            font-size:40px;
            color:white;
        }

        .bg-success-custom{
            background:#22c55e;
        }

        .bg-danger-custom{
            background:#ef4444;
        }

        .bill-details{
            background:#f8fafc;
            border-radius:16px;
            padding:25px;
            text-align:left;
            margin:30px 0;
        }

        .bill-row{
            display:flex;
            justify-content:space-between;
            margin-bottom:12px;
        }

        .btn-return{
            background:linear-gradient(135deg,#2563eb 0%,#1e3a8a 100%);
            color:white;
            border-radius:50px;
            padding:14px 30px;
            display:block;
            text-decoration:none!important;
            font-weight:700;
        }
    </style>
</head>
<body>

<div class="result-card">

@if($is_success)

    <div class="icon-circle bg-success-custom">
        <i class="fa fa-check"></i>
    </div>

    <h4 class="font-weight-bold mb-2">
        Thanh toán thành công!
    </h4>

    <p class="text-muted">
        Giao dịch đã được ghi nhận.
    </p>

    <div class="bill-details">

        <div class="bill-row">
            <span>Mã giao dịch:</span>
            <strong>#{{ $txn_ref }}</strong>
        </div>

        <div class="bill-row">
            <span>Số tiền:</span>

            <strong class="text-primary">
                {{ number_format($amount,0,',','.') }} đ
            </strong>
        </div>

        <div class="bill-row">
            <span>Hợp đồng:</span>
            <strong>TG{{ $req_id }} (Kỳ {{ $period }})</strong>
        </div>

        <div class="bill-row">
            <span>Thời gian:</span>
            <strong>{{ now()->format('d/m/Y H:i') }}</strong>
        </div>

    </div>

    <a href="{{ route('installment.detail',$req_id) }}"
       class="btn-return">
        <i class="fa fa-file-invoice-dollar mr-2"></i>
        Xem tiến độ trả góp
    </a>

@else

    <div class="icon-circle bg-danger-custom">
        <i class="fa fa-times"></i>
    </div>

    <h4 class="font-weight-bold mb-2">
        Giao dịch thất bại!
    </h4>

    <p class="text-muted">
        Khách hàng đã hủy giao dịch.
    </p>

    <a href="{{ route('installment.detail',$req_id) }}"
       class="btn-return"
       style="background:#64748b;">
        Quay lại hợp đồng
    </a>

@endif

</div>

</body>
</html>