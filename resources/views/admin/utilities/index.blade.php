@extends('admin.layouts.app')

@section('content')

<style>
.utility-premium-wrapper{
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
.btn-gradient{
    background:linear-gradient(135deg,#f6c23e 0%,#dda20a 100%);
    color:white;
    border:none;
    padding:10px 24px;
    border-radius:50px;
    font-weight:600;
}
.table-custom thead th{
    background-color:#f8f9fa;
    padding:15px;
    font-size:.85rem;
}
.table-custom tbody td{
    padding:18px 15px;
    vertical-align:middle;
}
.room-badge{
    background:#e3f2fd;
    color:#1976d2;
    padding:6px 14px;
    border-radius:8px;
    font-weight:700;
}
.date-badge{
    background:#f1f5f9;
    padding:6px 12px;
    border-radius:6px;
    font-weight:600;
}
.val-electric{
    color:#d97706;
    font-weight:700;
}
.val-water{
    color:#0891b2;
    font-weight:700;
}
.btn-action{
    width:36px;
    height:36px;
    border-radius:12px;
    border:none;
}
.btn-edit{
    background:#e0fcfc;
    color:#36b9cc;
}
.btn-delete{
    background:#fceceb;
    color:#e74a3b;
}
</style>

<div class="utility-premium-wrapper">

<div class="container-fluid p-4">

<div class="card card-custom">

<div class="card-header-custom">

<h4 class="card-title m-0">

<span style="background:#fff3cd;padding:8px;border-radius:50%;width:40px;height:40px;display:flex;justify-content:center;align-items:center;margin-right:10px;">

<i class="fa fa-tachometer-alt text-warning"></i>

</span>

Hệ thống Ghi chỉ số Điện / Nước Định Kỳ

</h4>

<button class="btn btn-gradient btn-sm"
        id="new_reading">

<i class="fa fa-plus-circle mr-1"></i>

Ghi chỉ số mới

</button>

</div>

<div class="card-body p-3">

<div class="table-responsive">

<table class="table table-custom table-hover mb-0"
       id="utility_tbl">

<thead>

<tr>

<th class="text-center">#</th>
<th>Kỳ hóa đơn</th>
<th>Mã số phòng</th>
<th>Khách thuê</th>
<th class="text-right">Điện</th>
<th class="text-right">Nước</th>
<th class="text-center">Thao tác</th>

</tr>

</thead>

<tbody>

@foreach($readings as $key => $row)

@php
$tenant = optional($row->house)->tenants->where('status',1)->first();
@endphp

<tr>

<td class="text-center">
{{ $key + 1 }}
</td>

<td>

<span class="date-badge">
{{ date('m/Y', strtotime($row->reading_date)) }}
</span>

</td>

<td>

<span class="room-badge">
P.{{ $row->house->house_no ?? '' }}
</span>

</td>

<td>

@if($tenant)

<b>
{{ ucwords(($tenant->lastname ?? '').' '.($tenant->firstname ?? '')) }}
</b>

@else

<span class="badge badge-secondary">
Phòng trống
</span>

@endif

</td>

<td class="text-right">

<span class="val-electric">
{{ number_format($row->electric) }}
</span>

<small class="text-muted d-block">
kWh
</small>

</td>

<td class="text-right">

<span class="val-water">
{{ number_format($row->water) }}
</span>

<small class="text-muted d-block">
m³
</small>

</td>

<td class="text-center">

<button class="btn-action btn-edit edit_reading"
        data-id="{{ $row->id }}">

<i class="fa fa-pen"></i>

</button>

<button class="btn-action btn-delete delete_reading"
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

    $('#utility_tbl').DataTable({

        language:{
            sProcessing:"Đang xử lý...",
            sLengthMenu:"Hiển thị _MENU_ dòng",
            sZeroRecords:"Không tìm thấy dữ liệu",
            sInfo:"Hiện _START_ đến _END_ của _TOTAL_ bản ghi",
            sSearch:"Tìm nhanh:",

            oPaginate:{
                sNext:'<i class="fa fa-chevron-right"></i>',
                sPrevious:'<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$('#new_reading').click(function(){

    uni_modal(
        "Ghi chỉ số điện nước mới",
        "{{ route('admin.utilities.manage') }}"
    )

});

$(document).on('click','.edit_reading',function(){

    uni_modal(
        "Cập nhật Chỉ số",
        "{{ url('/admin/utilities/manage') }}/"+$(this).attr('data-id')
    )

});

$(document).on('click','.delete_reading',function(){

    _conf(
        "Bạn có chắc muốn xóa?",
        "delete_reading",
        [$(this).attr('data-id')]
    )

});

function delete_reading(id){

    start_load();

    $.ajax({

        url:"{{ url('/admin/utilities/delete') }}/"+id,

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Xóa thành công",
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

</script>

@endsection