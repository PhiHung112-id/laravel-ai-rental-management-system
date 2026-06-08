@extends('admin.layouts.app')

@section('content')

<style>
    .messages-premium-wrapper {
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
        font-weight: 700;
        color: #4e73df;
        font-size: 1.2rem;
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

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
    }

    .msg-content {
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .email-link {
        color: #4e73df;
        font-weight: 500;
        text-decoration: none !important;
    }

    .email-link:hover {
        color: #224abe;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        outline: none;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 5px 10px;
    }
</style>

<div class="messages-premium-wrapper">

    <div class="container-fluid">

        <div class="card card-custom">

            <div class="card-header-custom">

                <i class="fa fa-envelope-open-text text-primary"></i>

                Hòm thư Góp ý & Liên hệ từ Khách hàng

            </div>

            <div class="card-body p-3">

                <div class="table-responsive">

                    <table class="table table-custom table-hover mb-0"
                           id="message-list">

                        <thead>

                            <tr>

                                <th class="text-center" width="50">#</th>

                                <th>Khách hàng</th>

                                <th>Email</th>

                                <th>Tiêu đề</th>

                                <th>Nội dung</th>

                                <th class="text-center" width="150">
                                    Ngày gửi
                                </th>

                                <th class="text-center" width="100">
                                    Hành động
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($messages as $key => $row)

                            <tr>

                                <td class="text-center align-middle">
                                    {{ $key + 1 }}
                                </td>

                                <td class="align-middle">
                                    <b>{{ $row->name }}</b>
                                </td>

                                <td class="align-middle">

                                    <a href="mailto:{{ $row->email }}"
                                       class="email-link">

                                        <i class="fa fa-envelope mr-1"></i>

                                        {{ $row->email }}

                                    </a>

                                </td>

                                <td class="align-middle font-weight-bold">
                                    {{ $row->subject }}
                                </td>

                                <td class="align-middle">

                                    <div class="msg-content"
                                         title="{{ $row->message }}">

                                        {{ $row->message }}

                                    </div>

                                </td>

                                <td class="text-center align-middle">

                                    {{ date('d/m/Y H:i', strtotime($row->created_at)) }}

                                </td>

                                <td class="text-center align-middle">

                                    <button class="btn-action btn-delete delete_message"
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

    $('#message-list').DataTable({

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy thư liên hệ",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ tin nhắn",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    });

});

$(document).on('click','.delete_message',function(){

    _conf(
        "Bạn có chắc chắn muốn xóa thư liên hệ này?",
        "delete_message",
        [$(this).attr('data-id')]
    )

});

function delete_message(id){

    start_load();

    $.ajax({

        url: "{{ url('/admin/messages/delete') }}/" + id,

        method: 'POST',

        data: {
            _token: "{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã xóa thư liên hệ thành công!",
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