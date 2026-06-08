@extends('admin.layouts.app')

@section('content')

<style>
.invoices-premium-wrapper{
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
.card-title{
    font-size:1.25rem;
    font-weight:700;
    color:#4e73df;
    margin:0;
}
.btn-gradient{
    background:linear-gradient(135deg,#4e73df 0%,#224abe 100%);
    color:#fff;
    border:none;
    padding:10px 24px;
    border-radius:50px;
    font-weight:600;
}
.table-custom thead th{
    background:#f8f9fa;
    padding:15px;
    font-size:.85rem;
}
.table-custom tbody td{
    padding:16px 15px;
    vertical-align:middle;
}
.invoice-code{
    font-family:'Courier New';
    font-weight:700;
    color:#1d4ed8;
}
.room-badge{
    background:#e6fffa;
    color:#0d9488;
    padding:6px 12px;
    border-radius:8px;
    font-weight:700;
}
.text-price{
    color:#10b981;
    font-weight:800;
}
.btn-action{
    width:36px;
    height:36px;
    border-radius:12px;
    border:none;
}
.btn-edit{
    background:#e3f2fd;
    color:#1976d2;
}
.btn-delete{
    background:#ffebee;
    color:#c62828;
}
</style>

<div class="invoices-premium-wrapper">

<div class="container-fluid p-4">

<div class="card card-custom">

<div class="card-header-custom">

<h4 class="card-title">
<i class="fa fa-file-invoice-dollar text-primary"></i>
Hệ thống Quản lý Hóa đơn & Tài chính
</h4>

<button class="btn btn-gradient btn-sm"
        id="new_invoice">

<i class="fa fa-plus-circle mr-1"></i>

Lập hóa đơn mới

</button>

</div>

<div class="card-body p-3">

<div class="table-responsive">

<table class="table table-custom table-hover mb-0"
       id="invoice_tbl">

<thead>

<tr>

<th class="text-center">#</th>

<th class="text-center">Mã Hóa đơn</th>

<th>Khách thuê</th>

<th class="text-center">Phòng</th>

<th class="text-right">Tiền điện</th>

<th class="text-right">Tiền nước</th>

<th class="text-right">Tổng số tiền</th>

<th class="text-center">Ngày lập</th>

<th class="text-center">Hành động</th>

</tr>

</thead>

<tbody>

@foreach($payments as $key => $row)

<tr>

<td class="text-center">
{{ $key + 1 }}
</td>

<td class="text-center">

<span class="invoice-code">
#{{ strtoupper($row->invoice) }}
</span>

</td>

<td>

<b>
{{ $row->tenant->firstname ?? '' }}
{{ $row->tenant->middlename ?? '' }}
{{ $row->tenant->lastname ?? '' }}
</b>

</td>

<td class="text-center">

<span class="room-badge">
P.{{ $row->tenant->house->house_no ?? '' }}
</span>

</td>

<td class="text-right">
{{ number_format($row->cost_electric,0,',','.') }} đ
</td>

<td class="text-right">
{{ number_format($row->cost_water,0,',','.') }} đ
</td>

<td class="text-right">

<span class="text-price">
{{ number_format($row->amount,0,',','.') }} VNĐ
</span>

</td>

<td class="text-center">

{{ date('d/m/Y H:i', strtotime($row->created_at)) }}

</td>

<td class="text-center">

<button class="btn-action btn-edit edit_invoice"
        data-id="{{ $row->id }}">

<i class="fa fa-pen"></i>

</button>

<button class="btn-action btn-delete delete_invoice"
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

    $('#invoice_tbl').DataTable({

        language: {

            sProcessing:"Đang xử lý...",
            sLengthMenu:"Hiển thị _MENU_ dòng",
            sZeroRecords:"Không tìm thấy hóa đơn",
            sInfo:"Hiện _START_ đến _END_ của _TOTAL_ hóa đơn",
            sSearch:"Tìm nhanh:",

            oPaginate:{
                sNext:'<i class="fa fa-chevron-right"></i>',
                sPrevious:'<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$('#new_invoice').click(function(){

    uni_modal(
        "Lập Hóa Đơn Thu Tiền Mới",
        "{{ route('admin.payments.manage') }}",
        "mid-large"
    )

});

$(document).on('click','.edit_invoice',function(){

    uni_modal(
        "Cập nhật Chi Tiết Hóa Đơn",
        "{{ url('/admin/payments/manage') }}/"+$(this).attr('data-id'),
        "mid-large"
    )

});

$(document).on('click','.delete_invoice',function(){

    _conf(
        "Bạn có chắc chắn muốn xóa hóa đơn này?",
        "delete_invoice",
        [$(this).attr('data-id')]
    )

});

function delete_invoice(id){

    start_load();

    $.ajax({

        url:"{{ url('/admin/payments/delete') }}/"+id,

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Xóa hóa đơn thành công",
                    'success'
                );

                setTimeout(function(){

                    location.reload();

                },1000);

            }else{

                alert_toast(
                    "Có lỗi xảy ra!",
                    'danger'
                );

                end_load();
            }
        },

        error:function(xhr){

            console.log(xhr.responseText);

            alert(xhr.responseText);

            end_load();
        }
    });

}

</script>

@endsection