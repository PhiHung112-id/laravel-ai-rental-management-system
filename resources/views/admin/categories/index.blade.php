@extends('admin.layouts.app')

@section('content')

<style>
    .categories-premium-wrapper {
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
        height: 100%;
    }

    .card-header-custom {
        background: #fff;
        padding: 20px 25px;
        border-bottom: 2px solid #f0f0f0;
        font-weight: 700;
        color: #4e73df;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control-custom {
        border-radius: 12px;
        border: 2px solid #d1d3e2;
        padding: 12px 15px;
        height: auto;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control-custom:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
        outline: none;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        transition: all 0.3s;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(78, 115, 223, 0.4);
        color: white;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #1f2937;
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
        font-size: 0.9rem;
    }

    .table-custom tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        color: #444;
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

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 15px !important;
    }




</style>

<div class="categories-premium-wrapper">

    <div class="container-fluid p-4">

        <div class="row">

            <div class="col-md-4 mb-4">

                <form id="manage-category">

                    @csrf

                    <div class="card card-custom">

                        <div class="card-header-custom">
                            <i class="fa fa-pen-square text-primary"></i>
                            Thông tin Danh mục
                        </div>

                        <div class="card-body">

                            <input type="hidden" name="id" id="cat_id">

                            <div class="form-group mb-2">

                                <label class="control-label">
                                    Tên Danh mục / Loại phòng
                                </label>

                                <input type="text"
                                       class="form-control form-control-custom"
                                       name="name"
                                       id="cat_name"
                                       placeholder="VD: Phòng VIP, Căn hộ..."
                                       required>

                            </div>

                        </div>

                        <div class="card-footer bg-white border-0 pt-0 pb-4 text-center">

                            <button class="btn btn-gradient mr-2">
                                Lưu lại
                            </button>

                            <button class="btn btn-cancel"
                                    type="button"
                                    onclick="cancel_edit()">
                                Hủy bỏ
                            </button>

                        </div>

                    </div>

                </form>

            </div>

            <div class="col-md-8 mb-4">

                <div class="card card-custom">

                    <div class="card-header-custom">
                        <i class="fa fa-list text-primary"></i>
                        Danh sách Danh mục
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive p-3">

                            <table class="table table-custom table-hover mb-0" id="category-list">

                                <thead>
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Tên Danh mục / Loại phòng</th>
                                    <th class="text-center" width="150">Hành động</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($categories as $key => $row)

                                    <tr>

                                        <td class="text-center text-muted align-middle">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="align-middle">
                                            <b style="color:#333;font-size:1rem;">
                                                {{ $row->name }}
                                            </b>
                                        </td>

                                        <td class="text-center align-middle">

                                            <button class="btn-action btn-edit edit_category"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    data-name="{{ $row->name }}"
                                                    title="Chỉnh sửa">
                                                <i class="fa fa-pen"></i>
                                            </button>

                                            <button class="btn-action btn-delete delete_category"
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

function cancel_edit()
{
    $('#manage-category').get(0).reset();
    $('#cat_id').val('');
}

$('#manage-category').submit(function(e){

    e.preventDefault();

    start_load();

    $.ajax({

        url: "{{ route('admin.categories.save') }}",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',

        success:function(resp){

            if(resp == 1){

                alert_toast("Thêm danh mục thành công",'success');

                setTimeout(function(){
                    location.reload();
                },1500);

            } else if(resp == 2){

                alert_toast("Cập nhật thành công",'success');

                setTimeout(function(){
                    location.reload();
                },1500);

            } else {

                alert_toast("Có lỗi xảy ra, vui lòng thử lại!",'danger');
                end_load();

            }

        }

    });

});

$('.edit_category').click(function(){

    $('html, body').animate({
        scrollTop: 0
    }, 'fast');

    var cat = $('#manage-category');

    cat.get(0).reset();

    $('#cat_id').val($(this).attr('data-id'));
    $('#cat_name').val($(this).attr('data-name'));

    $('#cat_name').focus();

});

$('.delete_category').click(function(){

    _conf(
        "Bạn có chắc chắn muốn xóa danh mục này?",
        "delete_category",
        [$(this).attr('data-id')]
    );

});

function delete_category(id)
{
    start_load();

    $.ajax({

        url: "{{ url('/admin/categories/delete') }}/" + id,
        method: 'POST',

        data: {
            _token: "{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                alert_toast("Đã xóa danh mục thành công",'success');

                setTimeout(function(){
                    location.reload();
                },1500);

            }

        }

    });
}

$(document).ready(function(){

    $('#category-list').DataTable({

        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 10,

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ mục",
            sZeroRecords: "Không tìm thấy kết quả phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ mục",
            sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }

        }

    });

});
</script>

@endsection