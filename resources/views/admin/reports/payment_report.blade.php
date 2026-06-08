@extends('admin.layouts.app')

@section('content')

<style>
.report-premium-wrapper{
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

.filter-group{
    display:flex;
    align-items:center;
    background:#f1f5f9;
    padding:6px 20px;
    border-radius:50px;
    border:1px solid #e2e8f0;
}

.filter-group label{
    margin:0 10px 0 0;
    font-weight:600;
    color:#4b5563;
    font-size:0.9rem;
}

.filter-input{
    border:none;
    background:transparent;
    font-weight:700;
    color:#4e73df;
    outline:none;
}

.btn-gradient{
    background:linear-gradient(135deg,#4e73df 0%,#224abe 100%);
    color:white;
    border:none;
    padding:10px 24px;
    border-radius:50px;
    font-weight:600;
    margin-left:10px;
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
    padding:15px;
    font-size:0.85rem;
}

.table-custom tbody td{
    padding:18px 15px;
    vertical-align:middle;
}

.table-custom tfoot th{
    background-color:#eafaf1;
    color:#065f46;
    padding:18px 15px;
    font-weight:700;
    font-size:1.1rem;
}

.room-badge{
    background:#e6fffa;
    color:#0d9488;
    padding:6px 12px;
    border-radius:8px;
    font-weight:600;
    font-size:0.85rem;
}

.invoice-code{
    font-family:'Courier New', monospace;
    font-weight:700;
    color:#1d4ed8;
    background:#eff6ff;
    padding:4px 10px;
    border-radius:6px;
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
padding:8px;
font-size:12px;
}
</style>
</noscript>

<div class="report-premium-wrapper">

<div class="container-fluid p-4">

<div class="card card-report">

<div class="card-header-custom">

<h4 class="text-dark m-0 font-weight-bold">
<i class="fa fa-file-invoice text-primary mr-2"></i>
Biểu mẫu Báo cáo Doanh thu
</h4>

<form method="GET"
      class="d-flex align-items-center">

<div class="filter-group">

<label>Chọn tháng:</label>

<input type="month"
       name="month_of"
       class="filter-input"
       value="{{ $month_of }}">

</div>

<button class="btn btn-sm btn-gradient">
<i class="fa fa-filter mr-1"></i>
Lọc dữ liệu
</button>

<button class="btn btn-sm btn-print ml-2"
        type="button"
        id="print">

<i class="fa fa-print mr-1"></i>
In Báo cáo

</button>

</form>

</div>

<div class="card-body p-0">

<div class="col-md-12 p-3">

<div id="report">

<div class="on-print text-center mt-3 mb-4">

<h2 class="font-weight-bold">
BÁO CÁO DOANH THU THUÊ PHÒNG
</h2>

<p>
Chu kỳ tháng báo cáo:
<b>
{{ date('m/Y', strtotime($month_of.'-01')) }}
</b>
</p>

</div>

<div class="table-responsive">

<table class="table table-custom table-hover">

<thead>

<tr>

<th class="text-center" width="60">#</th>
<th width="150">Ngày thu</th>
<th>Khách thuê</th>
<th class="text-center" width="140">Phòng</th>
<th width="160">Mã hóa đơn</th>
<th class="text-right" width="180">Số tiền</th>

</tr>

</thead>

<tbody>

@forelse($payments as $key => $row)

<tr>

<td class="text-center align-middle">
{{ $key + 1 }}
</td>

<td class="align-middle text-muted small">
{{ date('d/m/Y', strtotime($row->created_at)) }}
</td>

<td class="align-middle">

<b class="text-dark">

{{ ucwords(
($row->tenant->lastname ?? '') .' '.
($row->tenant->firstname ?? '')
) }}

</b>

</td>

<td class="text-center align-middle">

<span class="room-badge">
P.{{ $row->tenant->house->house_no ?? 'N/A' }}
</span>

</td>

<td class="align-middle">

<span class="invoice-code">
{{ strtoupper($row->invoice ?? '') }}
</span>

</td>

<td class="text-right align-middle font-weight-bold">

{{ number_format($row->amount,0,',','.') }} đ

</td>

</tr>

@empty

<tr>

<th colspan="6">

<center class="py-5 text-muted">

Không có dữ liệu thanh toán tháng
{{ date('m/Y', strtotime($month_of.'-01')) }}

</center>

</th>

</tr>

@endforelse

</tbody>

<tfoot>

<tr>

<th colspan="5"
    class="text-right">

TỔNG DOANH THU:

</th>

<th class="text-right">

{{ number_format($tamount,0,',','.') }} VNĐ

</th>

</tr>

</tfoot>

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
        '<html><head><title>In Báo Cáo</title>'
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