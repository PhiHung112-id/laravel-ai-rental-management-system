@extends('admin.layouts.app')

@section('content')

<style>
    .installment-premium-wrapper {
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
        padding: 20px 30px;
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
        padding: 18px 15px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        color: #444;
        font-size: 0.95rem;
    }

    .table-custom tbody tr:hover {
        background-color: #fcfcfc;
    }

    .badge-house {
        background: #e3f2fd;
        color: #1565c0;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .text-debt {
        color: #c62828;
        font-weight: 700;
    }

    .badge-status {
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.82rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all .2s;
        margin: 0 2px;
        cursor: pointer;
    }

    .btn-view {
        background: #e0f2f1;
        color: #00897b;
    }

    .btn-view:hover {
        background: #00897b;
        color: white;
    }

    .btn-edit {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn-edit:hover {
        background: #2e7d32;
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

<div class="installment-premium-wrapper">

    <div class="container-fluid p-4">

        <div class="row">

            <div class="col-md-12">

                <div class="card card-custom">

                    <div class="card-header-custom">

                        <h4 class="card-title-custom">

                            <i class="fa fa-hand-holding-usd text-primary"></i>

                            Hệ thống Quản lý Yêu cầu Trả góp

                        </h4>

                    </div>

                    <div class="card-body p-3">

                        <div class="table-responsive">

                            <table class="table table-custom table-hover mb-0"
                                   id="installment-list">

                                <thead>

                                    <tr>

                                        <th class="text-center" width="50">
                                            #
                                        </th>

                                        <th class="text-center" width="120">
                                            Mã Đơn
                                        </th>

                                        <th>
                                            Họ và tên khách hàng
                                        </th>

                                        <th>
                                            Thông tin bất động sản phòng
                                        </th>

                                        <th class="text-right" width="160">
                                            Tổng tiền góp
                                        </th>

                                        <th class="text-center" width="120">
                                            Kỳ hạn
                                        </th>

                                        <th class="text-center" width="150">
                                            Trạng thái
                                        </th>

                                        <th class="text-center" width="150">
                                            Hành động
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($requests as $key => $row)

                                    <tr>

                                        <td class="text-center text-muted align-middle">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="text-center align-middle">

                                            <span class="badge-house">
                                                TG-{{ $row->id }}
                                            </span>

                                        </td>

                                        <td class="align-middle">

                                            <b class="text-dark"
                                               style="font-size:1rem;">

                                                {{ ucwords($row->customer->name ?? '') }}

                                            </b>

                                        </td>

                                        <td class="align-middle text-muted small">

                                            {{ trim($row->room_info) }}

                                        </td>

                                        <td class="text-right align-middle">

                                            <span class="text-debt">

                                                {{ number_format($row->total_price,0,',','.') }} VNĐ

                                            </span>

                                        </td>

                                        <td class="text-center align-middle">

                                            <b class="text-secondary">

                                                {{ $row->months }} tháng

                                            </b>

                                        </td>

                                        <td class="text-center align-middle">

                                            @if($row->status == 1)

                                                <span class="badge badge-success badge-status">

                                                    <i class="fa fa-check-circle mr-1"></i>

                                                    Đã liên hệ

                                                </span>

                                            @else

                                                <span class="badge badge-warning badge-status text-dark">

                                                    <i class="fa fa-clock mr-1"></i>

                                                    Chờ tư vấn

                                                </span>

                                            @endif

                                        </td>

                                        <td class="text-center align-middle">

                                            <button class="btn-action btn-view view_request"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Xem chi tiết">

                                                <i class="fa fa-eye"></i>

                                            </button>

                                            @if($row->status == 0)

                                            <button class="btn-action btn-edit approve_request"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Xác nhận liên hệ">

                                                <i class="fa fa-check"></i>

                                            </button>

                                            <button class="btn-action btn-delete delete_request"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Xóa yêu cầu">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                            @endif

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

    $('#installment-list').DataTable({

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy dữ liệu phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ yêu cầu",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    });

    $(document).on('click','.view_request',function(){

        uni_modal(
            "Chi tiết yêu cầu trả góp",
            "{{ url('/admin/installment-requests/view') }}/"+$(this).attr('data-id'),
            "mid-large"
        )

    });

    $(document).on('click','.approve_request',function(){

        var id = $(this).attr('data-id');

        _conf(
            "Bạn có chắc chắn muốn xác nhận ĐÃ LIÊN HỆ cho yêu cầu trả góp này?",
            "update_status",
            [id,1]
        );

    });

    $(document).on('click','.delete_request',function(){

        var id = $(this).attr('data-id');

        _conf(
            "Bạn có chắc chắn muốn xóa yêu cầu trả góp này?",
            "delete_request",
            [id]
        );

    });

});

function update_status(id,status){

    start_load();

    $.ajax({

        url:"{{ route('admin.installments.update-status') }}",

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}",
            id:id,
            status:status
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã cập nhật trạng thái!",
                    'success'
                );

                var target_btn = $('.approve_request[data-id="'+id+'"]');

                target_btn.closest('tr')
                    .find('.badge-status')
                    .replaceWith(
                        '<span class="badge badge-success badge-status"><i class="fa fa-check-circle mr-1"></i>Đã liên hệ</span>'
                    );

                target_btn.hide();

                $('.modal').modal('hide');

                end_load();

            }else{

                alert_toast(
                    "Lỗi hệ thống!",
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

function delete_request(id){

    start_load();

    $.ajax({

        url:"{{ url('/admin/installment-requests/delete') }}/"+id,

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã xóa yêu cầu!",
                    'success'
                );

                var target_btn = $('.delete_request[data-id="'+id+'"]');

                var table = $('#installment-list').DataTable();

                table.row(
                    target_btn.closest('tr')
                ).remove().draw(false);

                $('.modal').modal('hide');

                end_load();

            }else{

                alert_toast(
                    "Không thể thực thi xóa!",
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