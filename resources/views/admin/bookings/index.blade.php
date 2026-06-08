@extends('admin.layouts.app')

@section('content')

<style>
    .bookings-premium-wrapper {
        min-height: calc(100vh - 60px);
        padding-top: 20px;
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,.05);
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

    .table-custom thead th {
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        border-top: none;
        border-bottom: 2px solid #eee;
        padding: 15px;
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

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        outline: none;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .customer-meta-nav {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 3px;
    }

    .badge-price-custom {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 4px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }

    .badge-status {
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-pending {
        background: #fff8e1;
        color: #b45309;
    }

    .status-confirmed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
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

    .btn-check {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn-check:hover {
        background: #2e7d32;
        color: white;
    }

    .btn-cancel-action {
        background: #fff3e0;
        color: #ef6c00;
    }

    .btn-cancel-action:hover {
        background: #ef6c00;
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

<div class="bookings-premium-wrapper">

    <div class="container-fluid p-4">

        <div class="col-lg-12">

            <div class="card card-custom">

                <div class="card-header-custom">

                    <h4 class="card-title-custom">
                        <i class="fa fa-calendar-check text-primary"></i>
                        Hệ thống Quản lý Đặt phòng Cư dân
                    </h4>

                </div>

                <div class="card-body p-3">

                    <div class="table-responsive">

                        <table class="table table-custom table-hover mb-0"
                               id="booking_tbl">

                            <thead>

                                <tr>
                                    <th class="text-center" width="60">
                                        STT
                                    </th>

                                    <th>
                                        Thông tin Khách hàng đặt phòng
                                    </th>

                                    <th>
                                        Thông tin không gian Phòng
                                    </th>

                                    <th class="text-center" width="150">
                                        Trạng thái đơn
                                    </th>

                                    <th class="text-center" width="160">
                                        Thao tác nhanh
                                    </th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($bookings as $key => $row)

                                <tr>

                                    <td class="text-center text-muted align-middle">
                                        {{ $key + 1 }}
                                    </td>

                                    <td class="align-middle">

                                        <b class="text-dark"
                                           style="font-size:1rem;">

                                            {{ ucwords($row->customer->name ?? '') }}

                                        </b>

                                        <div class="customer-meta-nav text-muted small">

                                            <span>
                                                <i class="fa fa-phone mr-1"></i>

                                                {{ $row->customer->phone ?? '' }}
                                            </span>

                                            <span class="ml-2">
                                                <i class="fa fa-envelope mr-1"></i>

                                                {{ $row->customer->email ?? '' }}
                                            </span>

                                        </div>

                                    </td>

                                    <td class="align-middle">

                                        <span class="text-primary font-weight-bold d-block mb-1"
                                              style="font-size:.95rem;">

                                            <i class="fa fa-door-open mr-1"></i>

                                            Phòng:
                                            {{ $row->house->house_no ?? '' }}

                                        </span>

                                        <small class="text-muted d-block mb-1">

                                            Phân khúc:
                                            {{ $row->house->category->name ?? '' }}

                                        </small>

                                        <span class="badge-price-custom">

                                            <i class="fa fa-tag mr-1"></i>

                                            {{ number_format($row->house->price ?? 0,0,',','.') }} đ

                                        </span>

                                    </td>

                                    <td class="text-center align-middle">

                                        @if($row->status == 0)

                                            <span class="badge-status status-pending">

                                                <i class="fa fa-clock mr-1"></i>

                                                Chờ duyệt

                                            </span>

                                        @elseif($row->status == 1)

                                            <span class="badge-status status-confirmed">

                                                <i class="fa fa-check-circle mr-1"></i>

                                                Đã duyệt

                                            </span>

                                        @else

                                            <span class="badge-status status-cancelled">

                                                <i class="fa fa-times-circle mr-1"></i>

                                                Đã hủy

                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center align-middle">

                                        @if($row->status == 0)

                                            <button class="btn-action btn-check confirm_booking"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Duyệt đơn này">

                                                <i class="fa fa-check"></i>

                                            </button>

                                            <button class="btn-action btn-cancel-action cancel_booking"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Hủy đơn này">

                                                <i class="fa fa-times"></i>

                                            </button>

                                        @endif

                                        <button class="btn-action btn-delete delete_booking"
                                                type="button"
                                                data-id="{{ $row->id }}"
                                                title="Xóa dữ liệu">

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

<script>

$(document).ready(function(){

    $('#booking_tbl').DataTable({

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy yêu cầu đặt phòng nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ mục đặt phòng",
            sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    });
});

$(document).on('click','.confirm_booking',function(){

    _conf(
        "Bạn có chắc chắn muốn DUYỆT yêu cầu đặt phòng này không?",
        "update_booking_status",
        [$(this).attr('data-id'),1]
    )

});

$(document).on('click','.cancel_booking',function(){

    _conf(
        "Bạn có chắc chắn muốn HỦY yêu cầu đặt phòng này?",
        "update_booking_status",
        [$(this).attr('data-id'),2]
    )

});

$(document).on('click','.delete_booking',function(){

    _conf(
        "Bạn có chắc chắn muốn XÓA vĩnh viễn phiếu đặt phòng này?",
        "delete_booking",
        [$(this).attr('data-id')]
    )

});

function update_booking_status($id,$status){

    start_load()

    $.ajax({

        url:"{{ route('admin.bookings.update-status') }}",

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}",
            id:$id,
            status:$status
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Cập nhật trạng thái đơn đặt phòng thành công",
                    'success'
                )

                setTimeout(function(){
                    location.reload()
                },1500)

            }else{

                alert_toast(
                    "Có lỗi xảy ra, vui lòng kiểm tra lại!",
                    'danger'
                );

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

function delete_booking($id){

    start_load()

    $.ajax({

        url:"{{ url('/admin/bookings/delete') }}/"+$id,

        method:'POST',

        data:{
            _token:"{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã xóa dữ liệu đơn đặt phòng thành công",
                    'success'
                )

                setTimeout(function(){
                    location.reload()
                },1500)

            }else{

                alert_toast(
                    "Quá trình xử lý xóa dữ liệu dính lỗi!",
                    'danger'
                );

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