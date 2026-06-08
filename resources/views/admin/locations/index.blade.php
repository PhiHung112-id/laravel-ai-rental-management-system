@extends('admin.layouts.app')

@section('content')

<style>
    .locations-premium-wrapper {
        min-height: calc(100vh - 60px);
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .card-custom {
        border: none;
        background: #fff;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
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

    .upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 15px;
        padding: 15px;
        transition: 0.2s;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        padding: 12px 30px;
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

    .btn-cancel-custom {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-cancel-custom:hover {
        background: #e2e8f0;
        color: #1f2937;
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

    .img-preview-table {
        width: 90px;
        height: 55px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
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
        margin: 0 4px;
        cursor: pointer;
    }

    .btn-edit { background: #e3f2fd; color: #1976d2; }
    .btn-edit:hover { background: #1976d2; color: white; }

    .btn-delete { background: #ffebee; color: #c62828; }
    .btn-delete:hover { background: #c62828; color: white; }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        outline: none;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 5px 10px;
    }

    @media (max-width: 768px) {
        .locations-premium-wrapper {
            margin-left: 0;
            margin-top: 50px;
            padding: 10px;
        }
    }
</style>

<div class="locations-premium-wrapper">
    <div class="container-fluid p-4">
        <div class="row">

            <div class="col-md-4 mb-4">
                <form id="manage-location" enctype="multipart/form-data">
                    @csrf

                    <div class="card card-custom">
                        <div class="card-header-custom">
                            <i class="fa fa-map-marked-alt text-primary"></i>
                            Thông tin Khu vực
                        </div>

                        <div class="card-body">
                            <input type="hidden" name="id" id="location_id">

                            <div class="form-group mb-4">
                                <label class="control-label">Tên địa danh / Khu vực</label>
                                <input type="text"
                                       class="form-control form-control-custom"
                                       name="location_name"
                                       id="location_name"
                                       placeholder="VD: Dĩ An, Thủ Dầu Một..."
                                       required>
                            </div>

                            <div class="form-group mb-2">
                                <label class="control-label">Ảnh bìa khu vực</label>

                                <div class="upload-box text-center">
                                    <input type="file"
                                           class="form-control-file mb-3"
                                           name="img"
                                           onchange="displayImg(this, '#cimg')">

                                    <img src="{{ asset('assets/img/city.jpg') }}"
                                         alt="Preview"
                                         id="cimg"
                                         class="img-fluid rounded"
                                         style="max-height: 160px; width: 100%; object-fit: cover; border-radius: 10px;">
                                </div>

                                <small class="text-muted mt-2 d-block text-center">
                                    Ảnh này sẽ hiện tại mục "Khám phá khu vực"
                                </small>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pt-0 pb-4 text-center">
                            <button class="btn btn-gradient mr-2">Lưu dữ liệu</button>
                            <button class="btn btn-cancel-custom" type="button" onclick="reset_form()">Hủy bỏ</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card card-custom">
                    <div class="card-header-custom">
                        <i class="fa fa-th-list text-primary"></i>
                        Danh sách hiện có
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-custom table-hover mb-0" id="location-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="60">#</th>
                                        <th width="140">Ảnh bìa</th>
                                        <th>Tên Khu vực</th>
                                        <th class="text-center" width="150">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($locations as $key => $row)
                                    @php
                                        $imgName = str_replace(' ', '%20', $row->img_path ?? '');
                                        $img = !empty($imgName)
                                            ? asset('assets/uploads/' . $imgName)
                                            : asset('assets/img/city.jpg');
                                    @endphp

                                    <tr>
                                        <td class="text-center text-muted align-middle">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="align-middle">
                                            <img src="{{ $img }}" class="img-preview-table">
                                        </td>

                                        <td class="align-middle">
                                            <b class="text-dark" style="font-size: 1rem;">
                                                {{ $row->location_name }}
                                            </b>
                                        </td>

                                        <td class="text-center align-middle">
                                            <button class="btn-action btn-edit edit_location"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    data-name="{{ $row->location_name }}"
                                                    data-img="{{ $row->img_path }}"
                                                    title="Chỉnh sửa">
                                                <i class="fa fa-pen"></i>
                                            </button>

                                            <button class="btn-action btn-delete delete_location"
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
function displayImg(input, target) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(target).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function reset_form() {
    $('#manage-location').get(0).reset();
    $('#location_id').val('');
    $('#cimg').attr('src', "{{ asset('assets/img/city.jpg') }}");
}

$(document).ready(function () {
    $('#location-list').DataTable({
        language: {
            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ mục",
            sZeroRecords: "Không tìm thấy dòng nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ mục",
            sInfoEmpty: "Đang xem 0 đến 0 trong tổng số 0 mục",
            sSearch: "Tìm nhanh:",
            oPaginate: {
                sPrevious: '<i class="fa fa-chevron-left"></i>',
                sNext: '<i class="fa fa-chevron-right"></i>'
            }
        }
    });
});

$('#manage-location').submit(function (e) {
    e.preventDefault();

    start_load();

    $.ajax({
        url: "{{ route('admin.locations.save') }}",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',

        success: function (resp) {
            if (resp == 1 || resp == 2) {
                alert_toast("Dữ liệu đã được lưu thành công", 'success');

                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Có lỗi xảy ra, vui lòng kiểm tra lại cấu hình!", 'danger');
                end_load();
            }
        },

        error: function () {
            alert_toast("Lỗi server!", 'danger');
            end_load();
        }
    });
});

$('.edit_location').click(function () {
    start_load();

    var form = $('#manage-location');
    form.get(0).reset();

    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var imgName = $(this).attr('data-img');

    $('#location_id').val(id);
    $('#location_name').val(name);

    if (imgName !== "" && imgName !== null) {
        $('#cimg').attr('src', "{{ asset('assets/uploads') }}/" + imgName);
    } else {
        $('#cimg').attr('src', "{{ asset('assets/img/city.jpg') }}");
    }

    end_load();

    $('html, body').animate({scrollTop: 0}, 'fast');
    $('#location_name').focus();
});

$('.delete_location').click(function () {
    _conf("Bạn có chắc muốn xóa khu vực này?", "delete_location", [$(this).attr('data-id')]);
});

function delete_location(id) {
    start_load();

    $.ajax({
        url: "{{ url('/admin/locations/delete') }}/" + id,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },

        success: function (resp) {
            if (resp == 1) {
                alert_toast("Đã xóa khu vực thành công", 'success');

                setTimeout(function () {
                    location.reload();
                }, 1000);

            } else if (resp == 3) {
                alert_toast("Không thể xóa! Khu vực này đang có nhà thuê.", 'danger');
                end_load();

            } else {
                alert_toast("Lỗi hệ thống!", 'danger');
                end_load();
            }
        },

        error: function () {
            alert_toast("Lỗi server!", 'danger');
            end_load();
        }
    });
}
</script>

@endsection