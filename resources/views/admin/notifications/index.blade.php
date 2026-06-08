@extends('admin.layouts.app')

@section('content')

<style>
    .notifications-premium-wrapper {
        min-height: calc(100vh - 60px);
        padding-top: 20px;
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        background: #fff;
        overflow: hidden;
    }

    .card-header-custom {
        background: #fff;
        padding: 20px 25px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title-custom {
        font-size: 1.2rem;
        font-weight: 700;
        color: #4e73df;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(78, 115, 223, 0.4);
        color: white;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        outline: none;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .table-custom thead th {
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        border-top: none;
        border-bottom: 2px solid #eee;
        padding: 15px;
        white-space: nowrap;
        font-size: 0.9rem;
    }

    .table-custom tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        color: #444;
        font-size: 0.95rem;
    }

    .table-custom tbody tr:hover {
        background-color: #fcfcfc;
    }

    .truncate-custom {
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .badge-pinned {
        background-color: #ffebee;
        color: #c62828;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-normal {
        background-color: #f1f5f9;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        margin: 0 3px;
        cursor: pointer;
    }

    .btn-edit {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-edit:hover {
        background: #1976d2;
        color: white;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
    }
</style>

<div class="notifications-premium-wrapper">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card card-custom">

                    <div class="card-header-custom">

                        <h4 class="card-title-custom">
                            <i class="fa fa-bell text-primary"></i>
                            Hệ thống Thông báo Ban Quản Lý
                        </h4>

                        <button class="btn btn-gradient btn-sm"
                                id="new_notify">

                            <i class="fa fa-plus-circle mr-1"></i>

                            Tạo thông báo

                        </button>

                    </div>

                    <div class="card-body p-3">

                        <div class="table-responsive">

                            <table class="table table-custom table-hover mb-0"
                                   id="notification-list">

                                <thead>

                                    <tr>

                                        <th class="text-center" width="50">
                                            #
                                        </th>

                                        <th class="text-center" width="150">
                                            Ngày tạo
                                        </th>

                                        <th>
                                            Tiêu đề thông báo
                                        </th>

                                        <th>
                                            Nội dung tóm tắt
                                        </th>

                                        <th class="text-center" width="130">
                                            Chế độ
                                        </th>

                                        <th class="text-center" width="130">
                                            Hành động
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($notifications as $key => $row)

                                    <tr>

                                        <td class="text-center text-muted align-middle">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="text-center align-middle small text-muted">

                                            {{ date('d/m/Y H:i', strtotime($row->created_at)) }}

                                        </td>

                                        <td class="align-middle">

                                            <b style="color:#333;font-size:.95rem;">

                                                {{ $row->title }}

                                            </b>

                                        </td>

                                        <td class="align-middle text-muted">

                                            <p class="truncate-custom"
                                               title="{{ strip_tags($row->content) }}">

                                                {{ strip_tags($row->content) }}

                                            </p>

                                        </td>

                                        <td class="text-center align-middle">

                                            @if($row->is_pinned == 1)

                                                <span class="badge-pinned">

                                                    <i class="fa fa-thumbtack mr-1"></i>

                                                    Đã Ghim

                                                </span>

                                            @else

                                                <span class="badge-normal">

                                                    Thường

                                                </span>

                                            @endif

                                        </td>

                                        <td class="text-center align-middle">

                                            <button class="btn-action btn-edit edit_notify"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Chỉnh sửa">

                                                <i class="fa fa-pen"></i>

                                            </button>

                                            <button class="btn-action btn-delete delete_notify"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Xóa bỏ">

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

    </div>

</div>

<script>

$(document).ready(function(){

    $('#notification-list').DataTable({

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy thông báo nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ thông báo",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$('#new_notify').click(function(){

    uni_modal(
        "Tạo thông báo mới",
        "{{ route('admin.notifications.manage') }}"
    )

});

$(document).on('click','.edit_notify',function(){

    uni_modal(
        "Chỉnh sửa thông báo",
        "{{ url('/admin/notifications/manage') }}/"+$(this).attr('data-id')
    )

});

$(document).on('click','.delete_notify',function(){

    _conf(
        "Bạn có chắc chắn muốn xóa thông báo này?",
        "delete_notify",
        [$(this).attr('data-id')]
    )

});

function delete_notify(id){

    start_load()

    $.ajax({

        url: "{{ url('/admin/notifications/delete') }}/"+id,

        method: 'POST',

        data: {
            _token: "{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Dữ liệu đã được xóa thành công",
                    'success'
                )

                setTimeout(function(){

                    location.reload()

                },1500)

            }else{

                alert_toast(
                    "Có lỗi xảy ra trong quá trình xử lý!",
                    'danger'
                )

                end_load();
            }
        },

        error:function(xhr){

            console.log(xhr.responseText)

            alert(xhr.responseText)

            end_load()
        }
    })
}

</script>

@endsection