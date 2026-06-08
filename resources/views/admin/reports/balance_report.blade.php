@extends('admin.layouts.app')

@section('content')

<style>
.balance-report-premium-wrapper{
    min-height:calc(100vh - 60px);
    background:#f8f9fc;
    padding-top:20px;
}

.container-fluid{
    font-family:'Poppins',sans-serif;
}

.card-report{
    border:none;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
    background:#fff;
    overflow:hidden;
}

.card-header-custom{
    background:#fff;
    padding:20px 30px;
    border-bottom:2px solid #f0f0f0;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.report-title{
    font-size:1.3rem;
    font-weight:700;
    color:#4e73df;
    margin:0;
}

.report-subtitle{
    font-size:0.9rem;
    color:#64748b;
    margin-top:5px;
    font-weight:500;
}

.btn-print{
    border:2px solid #10b981;
    color:#10b981;
    background:white;
    padding:8px 24px;
    border-radius:50px;
    font-weight:600;
}

.table-custom{
    width:100%;
    margin-bottom:0;
}

.table-custom thead th{
    background-color:#f8f9fa;
    color:#555;
    font-weight:700;
    border-bottom:2px solid #eee;
    padding:15px 10px;
    font-size:0.85rem;
}

.table-custom tbody td{
    padding:18px 10px;
    vertical-align:middle;
}

.debt-text{
    color:#ef4444;
    font-weight:700;
}

.paid-text{
    color:#10b981;
    font-weight:600;
}

.price-text{
    color:#4b5563;
    font-weight:600;
}

.room-badge{
    background:#e6fffa;
    color:#0d9488;
    padding:6px 14px;
    border-radius:8px;
    font-weight:700;
    font-size:0.85rem;
}

.on-print{
    display:none;
}
</style>

<noscript>
<style>
.text-center{text-align:center}
.text-right{text-align:right}
table{
width:100%;
border-collapse:collapse;
font-family:sans-serif;
}
tr,td,th{
border:1px solid black;
padding:5px;
font-size:12px;
}
</style>
</noscript>

<div class="balance-report-premium-wrapper">

<div class="container-fluid p-4">

<div class="card card-report">

<div class="card-header-custom">

<div>

<h4 class="report-title">
<i class="fa fa-file-invoice-dollar text-warning mr-2"></i>
Biểu mẫu Báo cáo Dư nợ & Công nợ
</h4>

<div class="report-subtitle">
Dữ liệu tổng hợp đến tháng {{ date('m/Y') }}
</div>

</div>

<button class="btn btn-print btn-sm"
        type="button"
        id="print">

<i class="fa fa-print mr-1"></i>
In Báo Cáo

</button>

</div>

<div class="card-body p-0">

<div class="col-md-12 p-3">

<div id="report">

<div class="on-print text-center mt-3 mb-4">

<h2 class="font-weight-bold">
BÁO CÁO CÔNG NỢ CHI TIẾT CƯ DÂN
</h2>

<p>
Thời điểm xuất báo cáo:
<b>{{ date('d/m/Y') }}</b>
</p>

</div>

<div class="table-responsive">

<table class="table table-custom table-hover mb-0">

<thead>

<tr>

<th class="text-center" width="50">#</th>
<th>Khách thuê</th>
<th class="text-center" width="130">Phòng</th>
<th class="text-right" width="140">Giá thuê</th>
<th class="text-center" width="130">Chu kỳ ở</th>
<th class="text-right" width="150">Tổng phải thu</th>
<th class="text-right" width="150">Đã thu</th>
<th class="text-right" width="150">Dư nợ</th>
<th class="text-center" width="150">Lần đóng cuối</th>

</tr>

</thead>

<tbody>

@forelse($tenants as $key => $row)

@php

$months = floor(
abs(
strtotime(now()) -
strtotime($row->date_in)
) / (30*60*60*24)
);

$payable = ($row->house->price ?? 0) * $months;

$paid = $row->payments->sum('amount');

$lastPayment = $row->payments
->sortByDesc('created_at')
->first();

$outstanding = $payable - $paid;

@endphp

<tr>

<td class="text-center align-middle">
{{ $key + 1 }}
</td>

<td class="align-middle">

<b class="text-dark">

{{ ucwords(
($row->lastname ?? '') .' '.
($row->firstname ?? '')
) }}

</b>

</td>

<td class="text-center align-middle">

<span class="room-badge">
P.{{ $row->house->house_no ?? '' }}
</span>

</td>

<td class="text-right align-middle price-text">

{{ number_format($row->house->price ?? 0,0,',','.') }} đ

</td>

<td class="text-center align-middle">

{{ $months }} tháng

</td>

<td class="text-right align-middle font-weight-bold">

{{ number_format($payable,0,',','.') }} đ

</td>

<td class="text-right align-middle paid-text">

{{ number_format($paid,0,',','.') }} đ

</td>

<td class="text-right align-middle
{{ $outstanding > 0 ? 'debt-text' : 'text-muted' }}">

{{ number_format($outstanding,0,',','.') }} đ

</td>

<td class="text-center align-middle small text-muted">

@if($lastPayment)

{{ date('d/m/Y', strtotime($lastPayment->created_at)) }}

@else

Chưa nộp tiền

@endif

</td>

</tr>

@empty

<tr>

<th colspan="9">

<center class="py-5 text-muted">

Chưa có dữ liệu công nợ

</center>

</th>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

$('#print').click(function(){

    var _style = $('noscript').clone();

    var _content = $('#report').clone();

    _content.find('.on-print').show();

    var nw = window.open(
        "",
        "_blank",
        "width=1000,height=800"
    );

    nw.document.write(
        '<html><head><title>In Báo Cáo Công Nợ</title>'
    );

    nw.document.write(_style.html());

    nw.document.write('</head><body>');

    nw.document.write(_content.html());

    nw.document.write('</body></html>');

    nw.document.close();

    nw.print();

    setTimeout(function(){
        nw.close()
    },500);

});

</script>

@endsection