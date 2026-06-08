@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root { --primary: #4361ee; --bg-body: #f4f7fe; --text-main: #2b3674; --card-bg: #ffffff; --warning: #f6c23e; }

    body {
        background: var(--bg-body);
        font-family: 'Be Vietnam Pro', sans-serif;
        color: var(--text-main);
    }

    .custom-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
        border: none;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .profile-banner {
        height: 120px;
        background: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);
        border-radius: 20px 20px 0 0;
        margin: -30px -30px 60px -30px;
    }

    .avatar-container {
        position: absolute;
        top: 70px;
        left: 50%;
        transform: translateX(-50%);
        width: 110px;
        height: 110px;
        background: white;
        border-radius: 50%;
        padding: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f4f7fe;
    }

    .info-label {
        font-size: 0.8rem;
        color: #a3aed0;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 20px;
        display: block;
    }

    .booking-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        transition: 0.3s;
        border: 1px solid transparent;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        border-color: #4895ef;
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.15);
    }

    .installment-card:hover {
        border-color: #f6c23e !important;
        box-shadow: 0 20px 40px rgba(246, 194, 62, 0.15);
    }

    .b-img-box {
        width: 120px;
        height: 90px;
        border-radius: 12px;
        overflow: hidden;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .b-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .amenity-icon {
        background: #fff9eb;
        color: #f6c23e;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .st-0 { background: #fff8e1; color: #ffb703; }
    .st-1 { background: #e0fbf0; color: #02c39a; }
    .st-2 { background: #fee2e2; color: #ef4444; }
    .st-3 { background: #fee2e2; color: #ef4444; }

    .avatar-edit-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 25px;
    }

    .avatar-edit-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #e0e5f2;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 35px;
        height: 35px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .avatar-upload-btn:hover {
        transform: scale(1.1);
    }

    .form-control-custom {
        height: 45px;
        border-radius: 12px;
        border: 1px solid #e0e5f2;
        box-shadow: none !important;
        font-size: 0.95rem;
    }

    .complaint-card {
        border-left: 5px solid #6c757d;
    }

    .complaint-card.status-0 {
        border-left-color: #ffb703;
    }

    .complaint-card.status-1 {
        border-left-color: #4361ee;
    }

    .complaint-card.status-2 {
        border-left-color: #02c39a;
    }

    .img-report-mini {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }

    .fa, .fas, .far, .fal, .fab, .fa-solid {
        font-family: "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
    }
</style>

@php
    $fallbackAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=200';

    if (!empty($user->avatar)) {
        if (filter_var($user->avatar, FILTER_VALIDATE_URL)) {
            $avatarSrc = $user->avatar;
            $isGoogleAvatar = true;
        } else {
            $avatarSrc = asset('assets/uploads/' . str_replace(' ', '%20', $user->avatar)) . '?v=' . time();
            $isGoogleAvatar = false;
        }
    } else {
        $avatarSrc = $fallbackAvatar;
        $isGoogleAvatar = false;
    }
@endphp

<div class="container py-5">
    <div class="row">

        <div class="col-lg-4 mb-4">
            <div class="custom-card text-center shadow-sm">
                <div class="profile-banner"></div>

                <div class="avatar-container">
                    <img src="{{ $avatarSrc }}"
                         class="avatar-img"
                         alt="Avatar"
                         onerror="this.src='{{ $fallbackAvatar }}'">
                </div>

                <h4 class="font-weight-bold mt-4 pt-3 mb-0">{{ $user->name }}</h4>

                @if($isGoogleAvatar)
                    <small class="text-muted d-block mt-1">
                        <i class="fab fa-google text-danger mr-1"></i>Tài khoản Google
                    </small>
                @endif

                <p class="text-muted small mt-2 mb-4">{{ $user->email }}</p>

                <div class="text-left px-2">
                    <span class="info-label">Số điện thoại</span>
                    <span class="info-value">
                        <i class="fa fa-phone-alt text-primary mr-2 small"></i>
                        {{ !empty($user->phone) ? $user->phone : 'Chưa cập nhật' }}
                    </span>

                    <span class="info-label">Địa chỉ cư trú</span>
                    <span class="info-value">
                        <i class="fa fa-map-marker-alt text-primary mr-2 small"></i>
                        {{ !empty($user->address) ? $user->address : 'Chưa cập nhật' }}
                    </span>
                </div>

                <button type="button" class="btn btn-primary btn-block rounded-pill font-weight-bold py-3 mt-3 shadow-sm" data-toggle="modal" data-target="#editProfileModal">
                    <i class="fa fa-user-edit mr-2"></i> Chỉnh sửa hồ sơ
                </button>

                <a href="{{ route('logout') }}" class="btn btn-light text-danger btn-block rounded-pill font-weight-bold py-2 mt-2">
                    <i class="fa fa-sign-out-alt mr-2"></i> Đăng xuất
                </a>
            </div>
        </div>

        <div class="col-lg-8">

            <h5 class="font-weight-bold mb-3">
                <i class="fa fa-calculator text-warning mr-2"></i>Yêu cầu Trả góp
            </h5>

            @forelse($installments as $item)
                @php
                    $house = $item->house;
                    $salePrice = ($house && $house->sale_price > 0) ? $house->sale_price : (($house->price ?? 0) * 100);
                    $months = isset($item->months) && $item->months > 0 ? $item->months : 12;
                    $monthlyPay = round($salePrice / $months);
                    $iStatus = $item->status;
                @endphp

                <a href="{{ url('installment_payment?req_id=' . $item->id) }}" class="text-decoration-none">
                    <div class="booking-card installment-card" style="border-left: 5px solid #f6c23e;">
                        <div class="amenity-icon bg-light text-warning mr-4" style="width: 70px; height: 70px; border-radius: 15px;">
                            <i class="fa fa-file-invoice-dollar fa-2x"></i>
                        </div>

                        <div class="flex-grow-1 text-dark">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="font-weight-bold mb-0 text-dark" style="font-size: 1.15rem;">
                                    Phòng {{ $house->house_no ?? 'N/A' }} ({{ number_format($salePrice, 0, ',', '.') }}đ)
                                </h6>

                                <span class="badge-status st-{{ $iStatus }}">
                                    @if($iStatus == 0)
                                        Chờ duyệt
                                    @elseif($iStatus == 1)
                                        <i class="fa fa-check-circle mr-1"></i> Đã duyệt
                                    @elseif($iStatus == 2)
                                        Hoàn thành
                                    @else
                                        Từ chối
                                    @endif
                                </span>
                            </div>

                            <div class="small text-muted" style="line-height: 1.7;">
                                <span class="text-dark font-weight-bold">Kỳ hạn: {{ $months }} tháng</span>
                                - Góp: {{ number_format($monthlyPay, 0, ',', '.') }} đ/tháng<br>
                                Tổng: {{ number_format($salePrice, 0, ',', '.') }} đ
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-4 border rounded-lg bg-white mb-5">
                    <p class="text-muted small mb-0">Bạn chưa đăng ký mua trả góp căn hộ nào.</p>
                </div>
            @endforelse


            <h5 class="font-weight-bold mb-3 mt-4">
                <i class="fa fa-history text-primary mr-2"></i>Lịch sử thuê phòng
            </h5>

            @forelse($bookings as $row)
                @php
                    $house = $row->house;
                    $status = $row->status;
                    $img = ($house && !empty($house->img_path))
                        ? asset('assets/uploads/' . str_replace(' ', '%20', $house->img_path))
                        : asset('assets/uploads/no-image.jpg');
                @endphp

                <div class="booking-card" style="border-left: 5px solid var(--primary);">
                    <div class="b-img-box">
                        <img src="{{ $img }}" class="b-img">
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="font-weight-bold text-dark mb-1">
                                Phòng {{ $house->house_no ?? 'N/A' }}
                            </h6>

                            <span class="badge-status st-{{ $status }}">
                                @if($status == 0)
                                    Chờ duyệt
                                @elseif($status == 1)
                                    Đã duyệt
                                @else
                                    Đã hủy
                                @endif
                            </span>
                        </div>

                        <div class="small text-muted mb-2">
                            {{ $house->category->name ?? 'Không rõ loại phòng' }}
                            •
                            {{ number_format($house->price ?? 0, 0, ',', '.') }} đ/tháng
                        </div>

                        <div class="d-flex pt-1">
                            @if($house)
                                <a href="{{ route('rooms.view', $house->id) }}" class="btn btn-sm btn-primary rounded-pill mr-2 px-3">
                                    <i class="fa fa-info-circle mr-1"></i> Chi tiết
                                </a>
                            @endif

                            @if($status == 1 && $realTenantId > 0 && $house)
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger rounded-pill btn-report px-3"
                                        data-toggle="modal"
                                        data-target="#complaintModal"
                                        data-house="{{ $house->house_no }}"
                                        data-house-id="{{ $house->id }}">
                                    <i class="fa fa-tools mr-1"></i> Báo cáo sự cố
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 border rounded-lg bg-white mb-4">
                    <p class="text-muted small mb-0">Chưa có dữ liệu giao dịch thuê phòng trọ.</p>
                </div>
            @endforelse


            <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                <h5 class="font-weight-bold m-0">
                    <i class="fa fa-tools text-danger mr-2"></i>Trạng thái Sửa chữa
                </h5>
            </div>

            @if($realTenantId > 0)
                @forelse($complaints as $complaint)
                    @php
                        $cStatus = $complaint->status;
                        $cImg = !empty($complaint->img_path)
                            ? asset('assets/uploads/' . str_replace(' ', '%20', $complaint->img_path))
                            : '';
                    @endphp

                    <div class="booking-card complaint-card status-{{ $cStatus }}">
                        @if($cImg)
                            <img src="{{ $cImg }}" class="img-report-mini shadow-sm">
                        @else
                            <div class="amenity-icon bg-light text-muted mr-3" style="width:50px; height:50px;">
                                <i class="fa fa-image"></i>
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="font-weight-bold mb-0 text-dark">
                                        Phòng {{ $complaint->house->house_no ?? 'N/A' }}
                                    </h6>

                                    <small class="text-muted">
                                        {{ $complaint->date_created ? \Carbon\Carbon::parse($complaint->date_created)->format('d/m/Y H:i') : '' }}
                                    </small>
                                </div>

                                <span class="badge-status st-{{ $cStatus }}">
                                    @if($cStatus == 0)
                                        Chờ xử lý
                                    @elseif($cStatus == 1)
                                        Đang xử lý
                                    @else
                                        Đã hoàn thành
                                    @endif
                                </span>
                            </div>

                            <div class="mt-2 text-dark" style="font-size: 0.9rem;">
                                <b>Nội dung kỹ thuật:</b> {{ $complaint->report }}
                            </div>

                            @if($cStatus == 2 && $complaint->cost > 0)
                                <div class="mt-2">
                                    <span class="badge badge-light text-danger font-weight-bold p-2" style="border: 1px solid #fee2e2;">
                                        Chi phí vật tư: {{ number_format($complaint->cost, 0, ',', '.') }} đ
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 border rounded-lg bg-white">
                        <p class="text-muted small mb-0">Hệ thống chưa ghi nhận báo cáo sự cố nào từ căn hộ của bạn.</p>
                    </div>
                @endforelse
            @else
                <div class="text-center py-4 border rounded-lg bg-white text-muted small">
                    <i class="fa fa-info-circle mr-1 text-primary"></i>
                    Tính năng kích hoạt sau khi hợp đồng thuê phòng của bạn được duyệt thành công.
                </div>
            @endif
        </div>
    </div>
</div>


<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa fa-user-cog text-primary mr-2"></i>Cập nhật thông tin
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="modal-body p-4">
                <form id="update-profile-form" enctype="multipart/form-data">
                    @csrf

                    <div class="avatar-edit-container">
                        <img src="{{ $avatarSrc }}" class="avatar-edit-img" id="avatar-preview-modal" onerror="this.src='{{ $fallbackAvatar }}'">

                        <label for="avatar-file-input" class="avatar-upload-btn mb-0">
                            <i class="fa fa-camera"></i>
                        </label>

                        <input type="file" name="img" id="avatar-file-input" accept="image/*" style="display: none;" onchange="previewModalAvatar(this)">
                    </div>

                    <div class="form-group">
                        <label class="info-label">Họ và tên cư dân</label>
                        <input type="text" name="name" class="form-control form-control-custom" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="info-label">Địa chỉ email (Không thể sửa)</label>
                        <input type="email" name="username" class="form-control form-control-custom" value="{{ $user->email }}" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label class="info-label">Số điện thoại liên hệ</label>
                        <input type="text" name="phone" class="form-control form-control-custom" value="{{ $user->phone ?? '' }}" placeholder="Nhập số điện thoại mới...">
                    </div>

                    <div class="form-group">
                        <label class="info-label">Địa chỉ thường trú</label>
                        <input type="text" name="address" class="form-control form-control-custom" value="{{ $user->address ?? '' }}" placeholder="Nhập địa chỉ của bạn...">
                    </div>

                    <div class="form-group mb-4">
                        <label class="info-label">Mật khẩu mới (Để trống nếu giữ nguyên)</label>
                        <input type="password" name="password" class="form-control form-control-custom" placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block rounded-pill font-weight-bold py-3 shadow">
                        LƯU THAY ĐỔI
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="complaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold text-danger">
                    <i class="fa fa-tools mr-2"></i>Báo sự cố Phòng <span id="modal-house-no"></span>
                </h5>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-4">
                <form id="manage-complaint" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="tenant_id" value="{{ $realTenantId }}">
                    <input type="hidden" name="house_id" id="modal-house-id">
                    <input type="hidden" name="status" value="0">
                    <input type="hidden" name="cost" value="0">

                    <div class="form-group">
                        <label class="info-label">Mô tả hỏng hóc thiết bị</label>
                        <textarea name="report" rows="3" class="form-control" placeholder="Mô tả cụ thể sự cố thiết bị hoặc hạ tầng cần ban quản lý bảo trì..." required style="border-radius: 12px; resize: none; font-size: 0.9rem;"></textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label class="info-label">Hình ảnh hiện trạng</label>
                        <input type="file" name="img" class="form-control-file border p-2 rounded-lg" accept="image/*" onchange="previewComplaint(this)">
                    </div>

                    <div class="text-center mb-3" id="comp-preview-box" style="display:none">
                        <img src="" id="comp-img" class="img-fluid rounded-lg shadow-sm" style="max-height: 150px;">
                    </div>

                    <button type="submit" class="btn btn-danger btn-block rounded-pill font-weight-bold py-3 shadow">
                        GỬI YÊU CẦU ĐẾN BQL
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function previewModalAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatar-preview-modal').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewComplaint(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#comp-img').attr('src', e.target.result);
                $('#comp-preview-box').show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('.btn-report').click(function () {
        $('#modal-house-no').text($(this).attr('data-house'));
        $('#modal-house-id').val($(this).attr('data-house-id'));
        $('#manage-complaint')[0].reset();
        $('#comp-preview-box').hide();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#update-profile-form').submit(function (e) {
        e.preventDefault();

        var btn = $(this).find('button[type="submit"]');

        btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin mr-2"></i>Đang xử lý...');

        $.ajax({
            url: "{{ route('profile.update') }}",
            method: 'POST',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
                var res = String(resp).trim();

                if (res === '1') {
                    alert("🎉 Thông tin hồ sơ cá nhân đã được cập nhật thành công!");
                    $('#editProfileModal').modal('hide');

                    setTimeout(function(){
                        location.reload();
                    }, 300);
                } else {
                    alert("❌ Lỗi Logic Server: " + res);
                    btn.attr('disabled', false).text('LƯU THAY ĐỔI');
                }
            },
            error: function(xhr) {
                alert("❌ MÁY CHỦ BỊ LỖI: " + xhr.status);
                console.log(xhr.responseText);
                btn.attr('disabled', false).text('LƯU THAY ĐỔI');
            }
        });
    });

    $('#manage-complaint').submit(function (e) {
        e.preventDefault();

        var btn = $(this).find('button[type="submit"]');

        btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin mr-2"></i>Đang gửi yêu cầu...');

        $.ajax({
            url: "{{ route('complaint.store') }}",
            method: 'POST',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp) {
                var res = String(resp).trim();

                if (res === '1') {
                    alert("🎉 Gửi báo cáo thành công! Ban quản lý sẽ tiếp nhận xử lý.");
                    location.reload();
                } else {
                    alert("Đã xảy ra lỗi khi gửi thông tin: " + res);
                    btn.attr('disabled', false).text('GỬI YÊU CẦU ĐẾN BQL');
                }
            },
            error: function(xhr) {
                alert("❌ MÁY CHỦ BỊ LỖI: " + xhr.status);
                console.log(xhr.responseText);
                btn.attr('disabled', false).text('GỬI YÊU CẦU ĐẾN BQL');
            }
        });
    });
</script>

@endsection