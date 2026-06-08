@php
    $name = trim(($tenant->lastname ?? '') . ', ' . ($tenant->firstname ?? '') . ' ' . ($tenant->middlename ?? ''));
    $houseNo = $tenant->house->house_no ?? '';
    $price = $tenant->house->price ?? 0;
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hợp đồng thuê nhà - {{ ucwords($name) }}</title>

    <style>
        body { font-family: 'Times New Roman', serif; font-size: 13pt; line-height: 1.5; background: #555; }
        .page {
            background: white; width: 210mm; min-height: 297mm; display: block;
            margin: 20px auto; padding: 25mm 25mm 20mm 25mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        h3 { text-align: center; text-transform: uppercase; margin-bottom: 5px; }
        h4 { text-align: center; margin-top: 0; font-weight: bold; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .section-title { font-weight: bold; margin-top: 15px; text-decoration: underline; }
        p { margin: 5px 0; text-align: justify; }
        .row { display: flex; margin-top: 30px; }
        .col-6 { width: 50%; float: left; text-align: center; }

        @media print {
            body { background: white; }
            .page { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }

        .btn-print {
            position: fixed; top: 20px; right: 20px;
            padding: 10px 20px; background: #007bff; color: white;
            border: none; cursor: pointer; font-weight: bold; border-radius: 5px;
            text-decoration: none; font-family: sans-serif;
        }
    </style>
</head>

<body>

<a href="javascript:window.print()" class="btn-print no-print">🖨️ In Hợp Đồng</a>

<div class="page">
    <h3>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h3>
    <h4>Độc lập - Tự do - Hạnh phúc</h4>
    <hr style="width: 40%; border: 1px solid black;">

    <br>
    <h3>HỢP ĐỒNG THUÊ PHÒNG TRỌ</h3>

    <p>Hôm nay, ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}, tại địa chỉ nhà trọ.</p>
    <p>Chúng tôi gồm có:</p>

    <div class="section-title">BÊN A (BÊN CHO THUÊ):</div>
    <p>Ông/Bà: <span class="bold">NGUYỄN VĂN CHỦ TRỌ</span> (Chủ cơ sở)</p>
    <p>Số điện thoại: 0999.888.777</p>
    <p>Địa chỉ: Số 123, Đường ABC, TP. Thủ Dầu Một, Bình Dương.</p>

    <div class="section-title">BÊN B (BÊN THUÊ):</div>
    <p>Ông/Bà: <span class="bold" style="text-transform: uppercase;">{{ $name }}</span></p>
    <p>Email: {{ $tenant->email }}</p>
    <p>Số điện thoại: {{ $tenant->contact }}</p>

    <div class="section-title">NỘI DUNG HỢP ĐỒNG:</div>
    <p>Hai bên thỏa thuận việc thuê phòng trọ với các điều khoản sau:</p>

    <p><span class="bold">Điều 1:</span> Bên A đồng ý cho bên B thuê phòng trọ số <span class="bold">{{ $houseNo }}</span> tại địa chỉ nêu trên để ở.</p>

    <p><span class="bold">Điều 2:</span> Giá thuê phòng là: <span class="bold">{{ number_format($price, 0, ',', '.') }} VNĐ/tháng</span>.</p>
    <p>- Tiền điện: Theo giá nhà nước (hoặc 3.500đ/kwh).</p>
    <p>- Tiền nước: 15.000đ/khối (hoặc theo đầu người).</p>

    <p><span class="bold">Điều 3:</span> Thời hạn thuê bắt đầu từ ngày: <span class="bold">{{ date('d/m/Y', strtotime($tenant->date_in)) }}</span>.</p>

    <p><span class="bold">Điều 4: TRÁCH NHIỆM CỦA CÁC BÊN</span></p>
    <p>- Bên B phải giữ gìn vệ sinh chung, không gây ồn ào ảnh hưởng đến các phòng xung quanh.</p>
    <p>- Thanh toán tiền thuê và tiền dịch vụ đúng hạn (từ ngày 01 đến ngày 05 hàng tháng).</p>
    <p>- Nếu bên B muốn chấm dứt hợp đồng phải báo trước cho bên A ít nhất 15 ngày.</p>

    <p>Hợp đồng này được lập thành 02 bản có giá trị pháp lý như nhau, mỗi bên giữ 01 bản.</p>

    <div class="row">
        <div class="col-6">
            <p class="bold">ĐẠI DIỆN BÊN A</p>
            <p>(Ký và ghi rõ họ tên)</p>
            <br><br><br><br>
            <p>Nguyễn Văn Chủ Trọ</p>
        </div>

        <div class="col-6">
            <p class="bold">ĐẠI DIỆN BÊN B</p>
            <p>(Ký và ghi rõ họ tên)</p>
            <br><br><br><br>
            <p>{{ ucwords($name) }}</p>
        </div>
    </div>
</div>

</body>
</html>