@extends('admin.layouts.app')

@section('content')

<style>
.maintenance-premium-wrapper {
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
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn-gradient {
    background: linear-gradient(135deg,#e74a3b 0%,#be2617 100%);
    color:white;
    border:none;
    padding:10px 24px;
    border-radius:50px;
    font-weight:600;
    box-shadow:0 4px 12px rgba(231,74,59,.3);
}

.btn-gradient:hover{
    color:white;
}

.table-custom thead th{
    background-color:#f8f9fa;
    color:#555;
    font-weight:600;
    border-bottom:2px solid #eee;
    padding:15px;
    font-size:.9rem;
}

.table-custom tbody td{
    padding:18px 15px;
    vertical-align:middle;
    border-top:1px solid #f0f0f0;
    color:#444;
    font-size:.95rem;
}

.badge-status{
    padding:6px 16px;
    border-radius:30px;
    font-size:.82rem;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:5px;
}

.status-0{
    background:#ffebee;
    color:#c62828;
}

.status-1{
    background:#e3f2fd;
    color:#1565c0;
}

.status-2{
    background:#e8f5e9;
    color:#2e7d32;
}

.text-cost-active{
    color:#e74a3b;
    font-weight:700;
}

.btn-action{
    width:36px;
    height:36px;
    border-radius:12px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:none;
    margin:0 3px;
}

.btn-edit{
    background:#e3f2fd;
    color:#1976d2;
}

.btn-delete{
    background:#ffebee;
    color:#c62828;
}

.complaint-thumb{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:12px;
    cursor:pointer;
    border:2px solid #f1f5f9;
    transition:.25s;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.complaint-thumb:hover{
    transform:scale(1.05);
}

.no-image-box{
    width:70px;
    height:70px;
    border-radius:12px;
    background:#f8fafc;
    border:2px dashed #e5e7eb;
    color:#9ca3af;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:1.2rem;
}

.image-modal{
    display:none;
    position:fixed;
    z-index:99999;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.88);
    justify-content:center;
    align-items:center;
    padding:20px;
}

.image-modal img{
    max-width:90%;
    max-height:90vh;
    border-radius:16px;
    box-shadow:0 10px 40px rgba(0,0,0,.5);
}

.image-modal .close-preview{
    position:absolute;
    top:25px;
    right:35px;
    color:white;
    font-size:35px;
    cursor:pointer;
    z-index:100000;
}
</style>

<div class="maintenance-premium-wrapper">
    <div class="container-fluid p-4">
        <div class="col-lg-12">

            <div class="card card-custom">

                <div class="card-header-custom">

                    <h4 class="m-0 font-weight-bold text-dark">
                        <i class="fa fa-tools text-danger mr-2"></i>
                        Hệ thống Quản lý Sự cố & Sửa chữa
                    </h4>

                    <button class="btn btn-gradient btn-sm"
                            id="new_complaint">

                        <i class="fa fa-plus-circle mr-1"></i>
                        Báo cáo sự cố

                    </button>

                </div>

                <div class="card-body p-3">

                    <div class="table-responsive">

                        <table class="table table-custom table-hover mb-0"
                               id="complaint_tbl">

                            <thead>
                                <tr>
                                    <th class="text-center" width="50">#</th>
                                    <th width="120">Ngày báo</th>
                                    <th>Cư dân / Vị trí phòng</th>
                                    <th>Nội dung sự cố chi tiết</th>
                                    <th class="text-center" width="120">Hình ảnh</th>
                                    <th class="text-center" width="150">
                                        Trạng thái
                                    </th>
                                    <th class="text-right" width="140">
                                        Chi phí xử lý
                                    </th>
                                    <th class="text-center" width="130">
                                        Hành động
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($complaints as $key => $row)

                                @php
                                    $tenantName = trim(
                                        ($row->tenant->lastname ?? '') . ', ' .
                                        ($row->tenant->firstname ?? '') . ' ' .
                                        ($row->tenant->middlename ?? '')
                                    );

                                    $imageUrl = !empty($row->img_path)
                                        ? asset('assets/uploads/' . $row->img_path)
                                        : null;
                                @endphp

                                <tr>

                                    <td class="text-center text-muted align-middle">
                                        {{ $key + 1 }}
                                    </td>

                                    <td class="align-middle text-muted small">
                                        {{
                                            date(
                                                'd/m/Y H:i',
                                                strtotime(
                                                    $row->date_created ??
                                                    $row->created_at
                                                )
                                            )
                                        }}
                                    </td>

                                    <td class="align-middle">

                                        <b class="text-dark"
                                           style="font-size:.95rem;">

                                            {{ ucwords($tenantName) }}

                                        </b>

                                        <br>

                                        <small class="text-muted">
                                            <i class="fa fa-door-open mr-1"></i>

                                            Phòng:
                                            <b>
                                                {{ $row->tenant->house->house_no ?? 'N/A' }}
                                            </b>
                                        </small>

                                    </td>

                                    <td class="align-middle text-secondary font-weight-medium">
                                        {{ $row->report }}
                                    </td>

                                    <td class="text-center align-middle">

                                        @if($imageUrl)

                                            <img src="{{ $imageUrl }}"
                                                 class="complaint-thumb preview-image"
                                                 data-img="{{ $imageUrl }}"
                                                 alt="Ảnh sự cố">

                                        @else

                                            <span class="no-image-box"
                                                  title="Không có ảnh">
                                                <i class="fa fa-image"></i>
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-center align-middle">

                                        @if($row->status == 0)

                                            <span class="badge-status status-0">
                                                <i class="fa fa-clock mr-1"></i>
                                                Chờ xử lý
                                            </span>

                                        @elseif($row->status == 1)

                                            <span class="badge-status status-1">
                                                <i class="fa fa-hammer mr-1"></i>
                                                Đang sửa
                                            </span>

                                        @else

                                            <span class="badge-status status-2">
                                                <i class="fa fa-check-circle mr-1"></i>
                                                Hoàn thành
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-right align-middle font-weight-bold">

                                        @if($row->cost > 0)

                                            <span class="text-cost-active">
                                                {{ number_format($row->cost,0,',','.') }} đ
                                            </span>

                                        @else

                                            <span class="text-muted">-</span>

                                        @endif

                                    </td>

                                    <td class="text-center align-middle">

                                        <button class="btn-action btn-edit edit_complaint"
                                                type="button"
                                                data-id="{{ $row->id }}">

                                            <i class="fa fa-pen"></i>

                                        </button>

                                        <button class="btn-action btn-delete delete_complaint"
                                                type="button"
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
</div>

<div class="image-modal" id="imagePreviewModal">

    <span class="close-preview">
        &times;
    </span>

    <img src="" id="previewImage" alt="Ảnh phóng to">

</div>

<script>

$(document).ready(function(){

    $('#complaint_tbl').DataTable({

        language: {

            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy dữ liệu sự cố nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ phiếu sự cố",
            sSearch: "Tìm nhanh:",

            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    })
})

$('#new_complaint').click(function(){
    uni_modal(
        "Ghi nhận Sự cố Mới",
        "{{ route('admin.complaints.manage') }}",
        "mid-large"
    );
});

$(document).on('click', '.edit_complaint', function(){
    uni_modal(
        "Cập nhật Tiến độ / Chi phí sửa chữa",
        "{{ url('/admin/complaints/manage') }}/" + $(this).attr('data-id'),
        "mid-large"
    );
});

$(document).on('click', '.delete_complaint', function(){
    _conf(
        "Bạn có chắc chắn muốn xóa phiếu báo sự cố này?",
        "delete_complaint",
        [$(this).attr('data-id')]
    );
});

$(document).on('click','.preview-image',function(){

    let img = $(this).attr('data-img');

    $('#previewImage').attr('src', img);

    $('#imagePreviewModal').css('display','flex').hide().fadeIn(200);

});

$(document).on('click','.close-preview, #imagePreviewModal',function(e){

    if(
        e.target.id === 'imagePreviewModal' ||
        $(e.target).hasClass('close-preview')
    ){
        $('#imagePreviewModal').fadeOut(200);
    }

});

function delete_complaint(id){
    start_load();

    $.ajax({
        url: "{{ url('/admin/complaints/delete') }}/" + id,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success:function(resp){
            if(resp == 1){
                alert_toast("Đã xóa dữ liệu sự cố thành công", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1000);
            } else {
                alert_toast("Xóa thất bại!", 'danger');
                end_load();
            }
        },
        error:function(xhr){
            console.log(xhr.responseText);
            alert("Lỗi server, mở F12 Console để xem.");
            end_load();
        }
    });
}
</script>

@endsection