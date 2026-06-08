@extends('admin.layouts.app')

@section('content')

<style>
    .reviews-premium-wrapper {
        min-height: calc(100vh - 60px);
        padding-top: 20px;
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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
        padding: 20px 15px;
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

    .user-comment {
        background: #f4f6f9;
        padding: 14px 16px;
        border-radius: 12px;
        border-left: 4px solid #4e73df;
        margin-bottom: 12px;
        font-style: italic;
        color: #4b5563;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .admin-reply-box {
        background: #eafaf1;
        padding: 14px 16px;
        border-radius: 12px;
        border-left: 4px solid #10b981;
        margin-left: 25px;
        position: relative;
        color: #1e293b;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .admin-reply-box::before {
        content: '\f3e5';
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: -22px;
        top: 14px;
        color: #cbd5e1;
        transform: scaleX(-1);
        font-size: 0.9rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s ease;
        margin: 0 3px;
        cursor: pointer;
    }

    .btn-reply {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-reply:hover {
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

    body.dark-mode .user-comment {
        background: #222d4a !important;
        color: #cbd5e1 !important;
        border-left-color: #4e73df !important;
    }

    body.dark-mode .admin-reply-box {
        background: #1c3d30 !important;
        color: #e2e8f0 !important;
        border-left-color: #10b981 !important;
    }

    body.dark-mode .admin-reply-box::before {
        color: #475569 !important;
    }
</style>

<div class="reviews-premium-wrapper">

    <div class="container-fluid p-4">

        <div class="col-lg-12">

            <div class="card card-custom">

                <div class="card-header-custom">

                    <h4 class="m-0 font-weight-bold text-dark">

                        <i class="fa fa-comments text-primary mr-2"></i>

                        Hệ thống Quản lý & Phản hồi Đánh giá

                    </h4>

                </div>

                <div class="card-body p-3">

                    <div class="table-responsive">

                        <table class="table table-custom table-hover mb-0"
                               id="review_tbl">

                            <thead>

                                <tr>

                                    <th class="text-center" width="6%">
                                        #
                                    </th>

                                    <th width="24%">
                                        Thông tin khách thuê
                                    </th>

                                    <th width="58%">
                                        Nội dung trao đổi / Phản hồi hòm thư
                                    </th>

                                    <th class="text-center" width="12%">
                                        Hành động
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($reviews as $key => $row)

                                <tr>

                                    <td class="text-center text-muted align-middle">
                                        {{ $key + 1 }}
                                    </td>

                                    <td class="align-middle">

                                        <b class="text-dark d-block mb-1"
                                           style="font-size: 1rem;">

                                            {{ ucwords($row->customer->name ?? '') }}

                                        </b>

                                        <span class="badge badge-primary px-2 py-1"
                                              style="border-radius: 6px; font-weight: 600;">

                                            Phòng {{ $row->house->house_no ?? '' }}

                                        </span>

                                        <div class="small text-muted mt-2">

                                            <i class="fa fa-clock mr-1"></i>

                                            {{ date('d/m/Y H:i', strtotime($row->created_at)) }}

                                        </div>

                                        <div class="text-warning mt-1"
                                             style="font-size: 0.85rem; letter-spacing: 2px;">

                                            @for($k = 1; $k <= 5; $k++)

                                                <i class="{{ $k <= $row->rating ? 'fas' : 'far' }} fa-star"></i>

                                            @endfor

                                        </div>

                                    </td>

                                    <td class="align-middle">

                                        <div class="user-comment shadow-sm">

                                            "{{ $row->comment }}"

                                        </div>

                                        @if(!empty($row->admin_reply))

                                            <div class="admin-reply-box shadow-sm">

                                                <small class="font-weight-bold text-success d-inline-block mb-1">

                                                    <i class="fa fa-user-shield mr-1"></i>

                                                    Ban Quản Lý trả lời:

                                                </small>

                                                <br>

                                                <span>

                                                    {!! nl2br(e($row->admin_reply)) !!}

                                                </span>

                                            </div>

                                        @endif

                                    </td>

                                    <td class="text-center align-middle">

                                        <button class="btn-action btn-reply reply_review"
                                                type="button"
                                                data-id="{{ $row->id }}"
                                                title="Trả lời / Sửa phản hồi">

                                            <i class="fa fa-reply"></i>

                                        </button>

                                        <button class="btn-action btn-delete delete_review"
                                                type="button"
                                                data-id="{{ $row->id }}"
                                                title="Xóa đánh giá vĩnh viễn">

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

    $('#review_tbl').DataTable({

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy dữ liệu đánh giá nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ đánh giá",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$(document).on('click', '.reply_review', function(){

    uni_modal(
        "Phản hồi đánh giá của khách hàng",
        "{{ url('/admin/reviews/manage') }}/" + $(this).attr('data-id')
    )

});

$(document).on('click', '.delete_review', function(){

    _conf(
        "Bạn có chắc chắn muốn xóa đánh giá này kèm câu trả lời (nếu có)?",
        "delete_review",
        [$(this).attr('data-id')]
    )

});

function delete_review(id){

    start_load();

    $.ajax({

        url: "{{ url('/admin/reviews/delete') }}/" + id,

        method: 'POST',

        data: {
            _token: "{{ csrf_token() }}"
        },

        success: function(resp){

            if(resp == 1){

                alert_toast(
                    "Xóa đánh giá khỏi hệ thống thành công",
                    'success'
                );

                setTimeout(function(){

                    location.reload();

                }, 1500);

            } else {

                alert_toast(
                    "Có lỗi xảy ra khi thực thi xóa bản ghi!",
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