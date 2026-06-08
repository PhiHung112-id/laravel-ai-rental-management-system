@extends('admin.layouts.app')

@section('content')

<style>
.installments-premium-wrapper{
    min-height:calc(100vh - 60px);
    padding-top:20px;
}
.container-fluid{
    font-family:'Poppins',sans-serif;
}
.card-custom{
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
.card-title-custom{
    font-size:1.2rem;
    font-weight:700;
    color:#4e73df;
    margin:0;
    display:flex;
    align-items:center;
    gap:10px;
}
.table-custom thead th{
    background-color:#f8f9fa;
    color:#555;
    font-weight:600;
    border-top:none;
    border-bottom:2px solid #eee;
    padding:15px;
    font-size:0.9rem;
}
.table-custom tbody td{
    padding:15px;
    vertical-align:middle;
    border-top:1px solid #f0f0f0;
}
.text-price{
    color:#2e7d32;
    font-weight:700;
}
.badge-house{
    background:#e3f2fd;
    color:#1565c0;
    padding:6px 12px;
    border-radius:8px;
    font-weight:700;
}
.badge-status{
    padding:6px 16px;
    border-radius:30px;
    font-size:.82rem;
    font-weight:600;
}
.status-0{
    background:#fff8e1;
    color:#b45309;
}
.status-1{
    background:#e8f5e9;
    color:#2e7d32;
}
.status-2{
    background:#ffebee;
    color:#c62828;
}
.btn-action{
    width:36px;
    height:36px;
    border-radius:12px;
    border:none;
}
.btn-check{
    background:#e8f5e9;
    color:#2e7d32;
}
.btn-cancel{
    background:#fff3e0;
    color:#ef6c00;
}
.btn-delete{
    background:#ffebee;
    color:#c62828;
}
</style>

<div class="installments-premium-wrapper">

<div class="container-fluid p-4">

<div class="card card-custom">

<div class="card-header-custom">

<h4 class="card-title-custom">
<i class="fa fa-clipboard-check text-primary"></i>
Phê duyệt Minh chứng đóng tiền góp
</h4>

</div>

<div class="card-body p-3">

<div class="table-responsive">

<table class="table table-custom table-hover mb-0"
       id="installment-receipts-table">

<thead>

<tr>

<th class="text-center">#</th>
<th>Ngày nộp</th>
<th>Khách hàng mua trả góp</th>
<th class="text-center">Thông tin phòng</th>
<th class="text-center">Kỳ số</th>
<th class="text-right">Số tiền thực nộp</th>
<th class="text-center">Trạng thái</th>
<th class="text-center">Thao tác nhanh</th>

</tr>

</thead>

<tbody>

@foreach($receipts as $key => $row)

<tr>

<td class="text-center">
{{ $key + 1 }}
</td>

<td class="align-middle text-muted small">
{{ date('d/m/Y H:i', strtotime($row->created_at)) }}
</td>

<td class="align-middle">
<b>
{{ ucwords($row->request->customer->name ?? '') }}
</b>
</td>

<td class="text-center align-middle">
<span class="badge-house">
P.{{ $row->request->house->house_no ?? 'Căn hộ' }}
</span>
</td>

<td class="text-center align-middle font-weight-bold text-secondary">
Tháng {{ $row->month_no }}
</td>

<td class="text-right align-middle">
<span class="text-price">
{{ number_format($row->amount,0,',','.') }} đ
</span>
</td>

<td class="text-center align-middle">

@if($row->status == 0)

<span class="badge-status status-0">
<i class="fa fa-clock"></i>
Chờ duyệt
</span>

@elseif($row->status == 1)

<span class="badge-status status-1">
<i class="fa fa-check-circle"></i>
Đã duyệt
</span>

@else

<span class="badge-status status-2">
<i class="fa fa-times-circle"></i>
Từ chối
</span>

@endif

</td>

<td class="text-center align-middle">

@if($row->status == 0)

<button class="btn-action btn-check approve_receipt"
        data-id="{{ $row->id }}">

<i class="fa fa-check"></i>

</button>

<button class="btn-action btn-cancel reject_receipt"
        data-id="{{ $row->id }}">

<i class="fa fa-times"></i>

</button>

@endif

<button class="btn-action btn-delete delete_receipt"
        data-id="{{ $row->id }}">

<i class="fa fa-trash"></i>

</button>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<script>

$(document).ready(function(){

    $('#installment-receipts-table').DataTable({

        language:{
            sProcessing:"Đang xử lý...",
            sLengthMenu:"Hiển thị _MENU_ dòng",
            sZeroRecords:"Không tìm thấy minh chứng giao dịch",
            sInfo:"Hiện _START_ đến _END_ của _TOTAL_ biên lai",
            sSearch:"Tìm nhanh:",

            oPaginate:{
                sNext:'<i class="fa fa-chevron-right"></i>',
                sPrevious:'<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$(document).on('click','.approve_receipt',function(){

    _conf(
        "Xác nhận khách đã thanh toán đủ?",
        "update_receipt_status",
        [$(this).attr('data-id'),1]
    )

});

$(document).on('click','.reject_receipt',function(){

    _conf(
        "Từ chối minh chứng thanh toán này?",
        "update_receipt_status",
        [$(this).attr('data-id'),2]
    )

});

$(document).on('click','.delete_receipt',function(){

    _conf(
        "Xóa lịch sử giao dịch này?",
        "delete_receipt",
        [$(this).attr('data-id')]
    )

});

function update_receipt_status(id,status){

    start_load();

    $.ajax({

        url:"{{ route('admin.installment_receipts.update') }}",

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}",
            id:id,
            status:status
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Cập nhật trạng thái thành công",
                    'success'
                );

                setTimeout(function(){

                    location.reload();

                },1000);

            }else{

                alert_toast(
                    "Có lỗi xảy ra",
                    'danger'
                );

                end_load();
            }
        }
    });
}

function delete_receipt(id){

    start_load();

    $.ajax({

        url:"{{ url('/admin/installment-receipts/delete') }}/"+id,

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã xóa biên lai",
                    'success'
                );

                setTimeout(function(){

                    location.reload();

                },1000);

            }else{

                alert_toast(
                    "Lỗi hệ thống",
                    'danger'
                );

                end_load();
            }
        }
    });
}

</script>

@endsection