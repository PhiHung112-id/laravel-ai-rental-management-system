@extends('admin.layouts.app')

@section('content')

<style>
    .houses-premium-wrapper {
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
        padding: 20px 15px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        color: #444;
    }

    .table-custom tbody tr:hover {
        background-color: #fcfcfc;
    }

    .house-img-preview {
        width: 110px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
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

    .house-info p {
        margin-bottom: 6px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }

    .badge-category {
        background: #fff3e0;
        color: #ef6c00;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-location {
        background: #e3f2fd;
        color: #0d47a1;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-price {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-sale {
        background: #f3e9fe;
        color: #6f42c1;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }
</style>

<div class="houses-premium-wrapper">
    <div class="container-fluid p-4">
        <div class="col-lg-12">
            <div class="card card-custom">

                <div class="card-header-custom">
                    <h4 class="m-0 font-weight-bold text-dark">
                        <i class="fa fa-home text-primary mr-2"></i>
                        Hệ thống Quản lý Danh sách phòng
                    </h4>

                    <button class="btn btn-gradient btn-sm" id="new_house">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Thêm phòng mới
                    </button>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0" id="house_tbl">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50">#</th>
                                    <th>Thông tin chi tiết không gian sống</th>
                                    <th class="text-center" width="130">Hành động</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($houses as $key => $row)
                                    @php
                                        $imgSrc = !empty($row->img_path) && file_exists(public_path('assets/uploads/'.$row->img_path))
                                            ? asset('assets/uploads/'.$row->img_path)
                                            : asset('assets/uploads/no-image.jpg');
                                    @endphp

                                    <tr>
                                        <td class="text-center text-muted align-middle">
                                            {{ $key + 1 }}
                                        </td>

                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $imgSrc }}"
                                                     class="house-img-preview mr-3"
                                                     alt="Room Image">

                                                <div class="house-info">
                                                    <p class="text-dark mb-2" style="font-size: 1.15rem; font-weight: 700;">
                                                        <i class="fa fa-door-open text-primary mr-1"></i>
                                                        {{ $row->house_no }}
                                                    </p>

                                                    <p class="mb-2">
                                                        <span class="badge-category" title="Loại phòng">
                                                            <i class="fa fa-tag mr-1"></i>
                                                            {{ $row->category->name ?? 'Chưa phân loại' }}
                                                        </span>

                                                        <span class="badge-location" title="Khu vực">
                                                            <i class="fa fa-map-marker-alt mr-1"></i>
                                                            {{ $row->location->location_name ?? 'Chưa xác định' }}
                                                        </span>

                                                        <span class="badge-price" title="Giá thuê hàng tháng">
                                                            <i class="fa fa-receipt mr-1"></i>
                                                            {{ number_format($row->price, 0, ',', '.') }} đ/tháng
                                                        </span>

                                                        <span class="badge-sale" title="Giá trị căn hộ">
                                                            <i class="fa fa-money-bill-wave mr-1"></i>
                                                            {{ number_format($row->sale_price ?? 0, 0, ',', '.') }} VNĐ
                                                        </span>
                                                    </p>

                                                    <p class="text-muted small mt-1 mb-0">
                                                        <i class="fa fa-align-left mr-1"></i>
                                                        {{ $row->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center align-middle">
                                            <button class="btn-action btn-edit edit_house"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Chỉnh sửa">
                                                <i class="fa fa-pen"></i>
                                            </button>

                                            <button class="btn-action btn-delete delete_house"
                                                    type="button"
                                                    data-id="{{ $row->id }}"
                                                    title="Xóa phòng">
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
    $('#house_tbl').DataTable({
        language: {
            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy phòng nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ phòng",
            sSearch: "Tìm nhanh:",
            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        },
        order: [[0, "asc"]]
    });
});

$('#new_house').click(function () {
    uni_modal("Thêm Phòng Mới", "{{ route('admin.houses.manage') }}", "mid-large")
});

$(document).on('click', '.edit_house', function () {
    uni_modal("Cập nhật thông tin Phòng", "{{ url('/admin/houses/manage') }}/" + $(this).attr('data-id'), "mid-large")
});

$(document).on('click', '.delete_house', function () {
    _conf(
        "Bạn có chắc chắn muốn xóa phòng này không khỏi cơ sở dữ liệu?",
        "delete_house",
        [$(this).attr('data-id')]
    );
});

function delete_house(id) {
    start_load();

    $.ajax({
        url: "{{ url('/admin/houses/delete') }}/" + id,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (resp) {
            if (resp == 1) {
                alert_toast("Đã xóa phòng thành công", 'success');

                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Có lỗi xảy ra trong quá trình xóa dữ liệu", 'danger');
                end_load();
            }
        }
    });
}
</script>

@endsection