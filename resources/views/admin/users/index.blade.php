@extends('admin.layouts.app')

@section('content')

<style>
.users-premium-wrapper{
    min-height:calc(100vh - 60px);
    padding-top:20px;
}

.container-fluid{
    font-family:'Poppins',sans-serif;
}

.card-users{
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

.btn-add-new{
    background:linear-gradient(135deg,#4e73df 0%,#224abe 100%);
    color:white;
    border:none;
    padding:10px 24px;
    border-radius:50px;
    font-weight:600;
}

.table-custom{
    width:100%;
    border-collapse:separate;
    border-spacing:0 8px;
}

.table-custom thead th{
    color:#555;
    font-weight:700;
    border-bottom:2px solid #eee;
    padding:15px 10px;
    font-size:0.85rem;
}

.table-custom tbody td{
    padding:18px 15px;
    vertical-align:middle;
    border-top:1px solid #f1f5f9;
    border-bottom:1px solid #f1f5f9;
}

.badge-role{
    padding:6px 14px;
    border-radius:30px;
    font-size:0.82rem;
    font-weight:600;
}

.badge-admin{
    background:#e3f2fd;
    color:#1565c0;
}

.badge-staff{
    background:#e8f5e9;
    color:#2e7d32;
}

.badge-user{
    background:#fff3e0;
    color:#ef6c00;
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

<div class="users-premium-wrapper">

<div class="container-fluid p-4">

<div class="card card-users">

<div class="card-header-custom">

<div class="d-flex align-items-center">

<div style="width:5px;height:25px;background:#4e73df;margin-right:15px;border-radius:5px;"></div>

<h4 class="card-title">
Hệ thống Quản lý Tài khoản
</h4>

</div>

<button class="btn btn-add-new btn-sm"
        id="new_user">

<i class="fa fa-plus mr-1"></i>
Thêm người dùng

</button>

</div>

<div class="card-body p-3">

<div class="table-responsive">

<table class="table table-custom"
       id="user_tbl">

<thead>

<tr>

<th class="text-center" width="60">#</th>
<th>Họ tên</th>
<th>Username</th>
<th class="text-center">Vai trò</th>
<th class="text-center">Hành động</th>

</tr>

</thead>

<tbody>

@foreach($users as $key => $row)

<tr>

<td class="text-center">
{{ $key + 1 }}
</td>

<td>
<b>{{ ucwords($row->name) }}</b>
</td>

<td>
{{ $row->email }}</td>

<td class="text-center">

@if($row->type == 1)

<span class="badge-role badge-admin">
Admin
</span>

@elseif($row->type == 2)

<span class="badge-role badge-staff">
Nhân viên
</span>

@else

<span class="badge-role badge-user">
Người dùng
</span>

@endif

</td>

<td class="text-center">

<button class="btn-action btn-edit edit_user"
        data-id="{{ $row->id }}">

<i class="fa fa-pen"></i>

</button>

<button class="btn-action btn-delete delete_user"
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

    $('#user_tbl').DataTable({

        language:{
            sProcessing:"Đang xử lý...",
            sLengthMenu:"Hiển thị _MENU_ dòng",
            sZeroRecords:"Không tìm thấy dữ liệu",
            sInfo:"Tổng số: _TOTAL_ tài khoản",
            sSearch:"Tìm nhanh:",

            oPaginate:{
                sNext:'<i class="fa fa-chevron-right"></i>',
                sPrevious:'<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$('#new_user').click(function(){

    uni_modal(
        "Thêm người dùng",
        "{{ route('admin.users.manage') }}"
    )

});

$(document).on('click','.edit_user',function(){

    uni_modal(
        "Cập nhật tài khoản",
        "{{ url('/admin/users/manage') }}/"+$(this).attr('data-id')
    )

});

$(document).on('click','.delete_user',function(){

    _conf(
        "Bạn chắc chắn muốn xóa?",
        "delete_user",
        [$(this).attr('data-id')]
    )

});

function delete_user(id){

    start_load();

    $.ajax({

        url:"{{ url('/admin/users/delete') }}/"+id,

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã xóa thành công",
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