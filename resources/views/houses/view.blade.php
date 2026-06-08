@extends('layouts.app')

@push('styles')
<style>
    /* Dán nguyên đoạn CSS dài ngoằng của bro từ file cũ vào đây */
    body { background-color: #f8f9fc; font-family: 'Poppins', sans-serif; color: #334155; }
    .navbar-custom { background: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border-bottom: 1px solid #f1f5f9; padding: 12px 0; }
    .btn-back { color: #64748b; font-weight: 600; text-decoration: none; transition: 0.2s; background: #f8f9fc; padding: 8px 20px; border-radius: 50px; font-size: 0.9rem; }
    .btn-back:hover { color: #3b82f6; background: #eff6ff; text-decoration: none; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-bottom: 15px; letter-spacing: -0.5px; }
    .detail-badge { padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; margin-right: 8px; }
    .badge-loc { background: #fef2f2; color: #ef4444; }
    .badge-cat { background: #eff6ff; color: #3b82f6; }
    .main-img-wrap { position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.06); height: 450px; margin-bottom: 15px; background: #000; }
    .img-main { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
    .img-dimmed { filter: grayscale(35%) brightness(0.7); }
    .thumb-row { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; }
    .thumb-row::-webkit-scrollbar { height: 6px; }
    .thumb-row::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .thumb-img { width: 80px; height: 60px; border-radius: 10px; object-fit: cover; cursor: pointer; border: 2px solid transparent; opacity: 0.6; transition: 0.3s; flex-shrink: 0; }
    .thumb-img:hover { opacity: 1; }
    .thumb-img.active { border-color: #3b82f6; opacity: 1; transform: scale(1.05); box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2); }
    .status-badge-lg { position: absolute; top: 20px; left: 20px; padding: 5px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; color: white; z-index: 2; box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-transform: uppercase; letter-spacing: 0.5px; }
    .bg-available { background: #22c55e; }
    .bg-occupied { background: #ef4444; }
    .bg-sold { background: #4b5563; }
    .content-card { background: #ffffff; border-radius: 20px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; }
    .section-title { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 15px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; text-transform: uppercase; letter-spacing: 0.5px; }
    .amenity-item { display: flex; align-items: center; margin-bottom: 15px; font-weight: 500; color: #475569; font-size: 0.9rem; }
    .amenity-icon { width: 35px; height: 35px; background: #eff6ff; color: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 0.95rem; }
    .booking-sidebar { position: sticky; top: 90px; }
    .booking-card { background: #ffffff; border-radius: 24px; padding: 25px; box-shadow: 0 15px 40px rgba(0,0,0,0.08); border: 1px solid #f1f5f9; }
    .price-label { font-size: 0.8rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
    .price-rent { font-size: 1.8rem; font-weight: 800; color: #3b82f6; line-height: 1; margin-bottom: 20px; }
    .price-sale { font-size: 1.35rem; font-weight: 800; color: #ef4444; line-height: 1; }
    .installment-promo-box { background: #fffdf5; border: 1px solid #fef3c7; border-left: 4px solid #f4b619; border-radius: 12px; padding: 12px 15px; margin-top: 20px; margin-bottom: 20px; }
    .promo-title { font-size: 0.75rem; font-weight: 700; color: #b45309; letter-spacing: 0.5px; margin-bottom: 3px; text-transform: uppercase; }
    .promo-value { font-size: 1.15rem; font-weight: 800; color: #d97706; }
    .btn-main-booking { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; width: 100%; padding: 14px; border-radius: 50px; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; transition: 0.3s; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3); margin-bottom: 12px; text-decoration: none !important; display: block; text-align: center; }
    .btn-main-booking:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(59, 130, 246, 0.4); color: white; }
    .btn-view-ins { background: #ffffff; color: #d97706; border: 1.5px solid #f4b619; width: 100%; padding: 12px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-align: center; transition: 0.2s; display: block; text-decoration: none !important; }
    .btn-view-ins:hover { background: #fef3c7; color: #b45309; }
    .contact-admin-box { background: #f8f9fc; border-radius: 16px; padding: 12px 15px; display: flex; align-items: center; border: 1px solid #e2e8f0; margin-top: 20px; }
    .admin-avatar { width: 40px; height: 40px; background: #c7d2fe; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; margin-right: 12px; }
    .btn-call { background: #22c55e; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.2s; text-decoration: none !important; box-shadow: 0 4px 10px rgba(34, 197, 94, 0.3); font-size: 0.9rem; }
    .btn-call:hover { transform: scale(1.1); background: #16a34a; color: white; }
    .room-card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column; }
    .room-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.06); }
    .room-img-wrap-sm { position: relative; height: 180px; overflow: hidden; border: none !important; padding: 0 !important; }
    .room-status-badge-sm { position: absolute; top: 12px; left: 12px; padding: 3px 10px; border-radius: 6px; font-weight: 700; font-size: 0.7rem; color: white; z-index: 2; }
    .room-body-sm { padding: 18px; display: flex; flex-direction: column; flex-grow: 1; }
    .room-meta-row-sm { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .cat-badge-sm { background: #eff6ff; color: #2563eb; font-size: 0.72rem; font-weight: 600; padding: 3px 8px; border-radius: 5px; }
    .room-card:nth-child(2n) .cat-badge-sm { background: #f0fdf4; color: #16a34a; }
    .loc-tag-sm { color: #ef4444; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 3px; }
    .room-title-sm { font-size: 1.15rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .price-block-sm { display: flex; align-items: center; margin-bottom: 4px; font-size: 0.85rem; }
    .price-label-sm { color: #64748b; font-weight: 500; width: 75px; }
    .price-rent-sm { color: #2563eb; font-weight: 700; font-size: 1rem; }
    .price-sale-sm { color: #dc3545; font-weight: 700; font-size: 0.95rem; }
    .btn-action-base-sm { background: #ffffff; color: #2563eb !important; border: 1px solid #3b82f6; width: 100%; padding: 8px 0; border-radius: 50px; font-weight: 700; font-size: 0.8rem; text-align: center; transition: all 0.2s ease; display: block; text-decoration: none !important; margin-top: 15px; }
    .btn-action-base-sm:hover { background: #2563eb; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }
    .btn-solid-gray-sm { background: #4b5563; color: #ffffff !important; border: 1px solid #4b5563; }
    .btn-solid-gray-sm:hover { background: #374151; }
</style>
@endpush

@section('content')

<div class="container py-5">
    {{-- Phần Header & Breadcrumb --}}
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-2" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-secondary">Danh sách</a></li>
                <li class="breadcrumb-item text-primary font-weight-bold" aria-current="page">Phòng {{ $house->house_no }}</li>
            </ol>
        </nav>
        
        <h1 class="page-title">Không Gian Sống Mẫu {{ $house->house_no }}</h1>

        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
            <span class="detail-badge badge-cat"><i class="fa fa-home mr-1"></i> {{ $house->category->name }}</span>
            <span class="detail-badge badge-loc">
                <i class="fa fa-map-marker-alt mr-1"></i> 
                {{ $house->locationDetail ? $house->locationDetail->location_name : 'Bình Dương' }}
            </span>
        </div>
        <p class="text-muted" style="font-size: 0.9rem;">
            <i class="fa fa-map-pin mr-2 text-danger"></i>
            {{ $house->location ? $house->location : 'Đang cập nhật địa chỉ cụ thể' }}
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            
            {{-- Ảnh chính & Status --}}
            <div class="main-img-wrap">
                <span class="status-badge-lg bg-{{ $status_class }}">{{ $status_label }}</span>
                <img src="{{ $gallery[0] }}" class="img-main {{ !$is_available ? 'img-dimmed' : '' }}" id="displayImg">
            </div>

            {{-- Thư viện ảnh nhỏ (Thumbnails) --}}
            @if (count($gallery) > 1)
                <div class="thumb-row">
                    @foreach ($gallery as $key => $src)
                        <img src="{{ $src }}" class="thumb-img {{ $key == 0 ? 'active' : '' }}" onclick="changeImg('{{ $src }}', this)">
                    @endforeach
                </div>
            @endif

            {{-- Tổng quan thiết kế --}}
            <div class="content-card mt-3">
                <h4 class="section-title"><i class="fa fa-info-circle text-primary mr-2"></i> Tổng quan thiết kế</h4>
                <p style="line-height: 1.8; white-space: pre-wrap; color: #475569; font-size: 0.9rem; margin-bottom: 0;">{{ strip_tags($house->description) }}</p>
            </div>

            {{-- Tiện ích đẳng cấp --}}
            <div class="content-card">
                <h4 class="section-title"><i class="fa fa-gem text-primary mr-2"></i> Tiện ích đẳng cấp</h4>
                <div class="row">
                    <div class="col-md-6 amenity-item"><div class="amenity-icon"><i class="fa fa-wifi"></i></div> Internet tốc độ cao (Miễn phí)</div>
                    <div class="col-md-6 amenity-item"><div class="amenity-icon"><i class="fa fa-parking"></i></div> Hầm giữ xe thông minh</div>
                    <div class="col-md-6 amenity-item"><div class="amenity-icon"><i class="fa fa-video"></i></div> An ninh Camera 24/7</div>
                    <div class="col-md-6 amenity-item"><div class="amenity-icon"><i class="fa fa-fingerprint"></i></div> Khóa vân tay an toàn</div>
                    <div class="col-md-6 amenity-item"><div class="amenity-icon"><i class="fa fa-couch"></i></div> Nội thất cơ bản</div>
                    <div class="col-md-6 amenity-item"><div class="amenity-icon"><i class="fa fa-broom"></i></div> Dịch vụ vệ sinh chung</div>
                </div>
            </div>

            {{-- Bản đồ --}}
            <div class="content-card">
                <h4 class="section-title"><i class="fa fa-map-marked-alt text-primary mr-2"></i> Định vị trên bản đồ</h4>
                @if (!empty($house->map_link))
                    <div style="width: 100%; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                        <iframe src="{{ $house->map_link }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @else
                    <div class="text-center py-4 bg-light rounded" style="border: 2px dashed #cbd5e1;">
                        <i class="fa fa-map-marker-slash fa-2x mb-2 text-secondary" style="opacity: 0.5;"></i>
                        <p class="text-muted font-weight-bold mb-0" style="font-size: 0.9rem;">Hệ thống đang cập nhật tọa độ bản đồ</p>
                    </div>
                @endif
            </div>

            {{-- Đánh giá từ cộng đồng --}}
            <div class="content-card">
                <h4 class="section-title"><i class="fa fa-comments text-primary mr-2"></i> Đánh giá từ cộng đồng</h4>
                
                {{-- Form Đánh giá --}}
                @if (session('login_customer_id'))
                    <div class="bg-light p-3 rounded mb-4 border">
                        <h6 class="font-weight-bold mb-2" style="font-size: 0.95rem;">Trải nghiệm của bạn thế nào?</h6>
                        <form id="manage-review">
                            @csrf
                            <input type="hidden" name="house_id" value="{{ $house->id }}">
                            <div class="form-group mb-2 d-flex align-items-center">
                                <label class="small font-weight-bold mb-0 mr-3 text-muted">Xếp hạng sao:</label>
                                <select name="rating" class="form-control form-control-sm w-auto font-weight-bold text-warning" style="border-radius: 8px; font-size: 0.85rem;">
                                    <option value="5">⭐⭐⭐⭐⭐ Tuyệt vời</option>
                                    <option value="4">⭐⭐⭐⭐ Tốt</option>
                                    <option value="3">⭐⭐⭐ Tạm được</option>
                                    <option value="2">⭐⭐ Kém</option>
                                    <option value="1">⭐ Tồi tệ</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <textarea name="comment" rows="3" class="form-control" placeholder="Viết cảm nhận của bạn về không gian này..." style="border-radius: 12px; resize: none; font-size: 0.9rem;" required></textarea>
                            </div>
                            <button class="btn btn-primary btn-sm rounded-pill px-4 font-weight-bold shadow-sm" type="submit" id="btn-review">Gửi bình luận</button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-primary d-flex align-items-center p-3 mb-4" style="border-radius: 12px;">
                        <i class="fa fa-info-circle fa-lg mr-3 opacity-50"></i>
                        <div>
                            <p class="mb-0" style="font-size: 0.85rem;">Vui lòng <a href="{{ url('login') }}" class="font-weight-bold text-primary text-decoration-underline">Đăng nhập</a> để tham gia bình luận.</p>
                        </div>
                    </div>
                @endif
                
                {{-- Danh sách Đánh giá --}}
                <div id="review-list">
                    @forelse ($reviews as $review)
                        <div class="mb-3 border-bottom pb-3">
                            <div class="d-flex justify-content-between align-items-end mb-1">
                                <div>
                                    <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">{{ $review->customer->name }}</div>
                                    <div class="text-warning" style="font-size: 0.8rem;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="small text-muted" style="font-size: 0.8rem;">
                                    <i class="fa fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="text-secondary" style="font-size: 0.9rem; line-height: 1.6;">{{ $review->comment }}</div>

                            @if (!empty($review->admin_reply))
                                <div class="mt-2 p-2 rounded" style="background-color: #f0fdf4; border-left: 3px solid #22c55e;">
                                    <div class="font-weight-bold text-success mb-1" style="font-size: 0.85rem;">
                                        <i class="fa fa-user-shield mr-1"></i> Ban Quản Lý phản hồi:
                                    </div>
                                    <div class="text-dark pl-2" style="font-style: italic; font-size: 0.85rem;">
                                        "{!! nl2br(e($review->admin_reply)) !!}"
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <p class="text-muted" style="font-size: 0.9rem;">Căn hộ này chưa có đánh giá nào.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar Booking --}}
        <div class="col-lg-4">
            <div class="booking-sidebar">
                <div class="booking-card">
                    <div class="price-label">Giá thuê theo tháng</div>
                    <div class="price-rent">{{ number_format($house->price, 0, ',', '.') }}<span style="font-size: 0.9rem; color: #64748b; font-weight: 500;"> đ</span></div>

                    <div class="price-label mt-3">Giá trị sở hữu (Mua đứt)</div>
                    <div class="price-sale">{{ number_format($sale_price_val, 0, ',', '.') }}<span style="font-size: 0.9rem; color: #64748b; font-weight: 500;"> đ</span></div>

                    <div class="installment-promo-box">
                        <div class="promo-title">Chính sách trả góp 12 tháng</div>
                        <div class="promo-value">{{ number_format($monthly_pay_calc, 0, ',', '.') }}đ <span style="font-size:0.75rem; font-weight:500; color:#b45309;">/tháng</span></div>
                    </div>

                    @if ($is_available)
                        @if (session('login_customer_id'))
                            <button class="btn-main-booking" onclick="booking({{ $house->id }})">ĐẶT PHÒNG NGAY</button>
                        @else
                            <a href="{{ url('login') }}" class="btn-main-booking"><i class="fa fa-sign-in-alt mr-2"></i> ĐĂNG NHẬP ĐỂ ĐẶT</a>
                        @endif
                        <a href="{{ url('installment?id=' . $house->id) }}" class="btn-view-ins"><i class="fa fa-calculator mr-2"></i> Xem kế hoạch trả góp chi tiết</a>
                    @else
                        <div class="alert alert-secondary text-center py-3 mb-0" style="border-radius: 12px; border: 2px dashed #94a3b8; background: #f8fafc;">
                            <i class="fa fa-lock fa-lg mb-2 text-secondary"></i>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 0.9rem;">GIAO DỊCH ĐÃ ĐÓNG</h6>
                            <p class="text-muted mb-0" style="font-size: 0.8rem;">Căn hộ này đã được {{ $status_class == 'sold' ? 'bán trả góp' : 'cho thuê' }}.</p>
                        </div>
                    @endif

                    <div class="contact-admin-box">
                        <div class="admin-avatar"><i class="fa fa-headset"></i></div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="font-weight-bold text-dark text-truncate" style="font-size: 0.9rem;">Hỗ trợ tư vấn</div>
                            <div class="text-muted" style="font-size: 0.8rem;">Admin Quản Gia 5.0</div>
                        </div>
                        <a href="tel:{{ $contact ?? '19001560' }}" class="btn-call" title="Gọi ngay"><i class="fa fa-phone"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cùng phân khúc --}}
    <div class="py-4 mt-3 border-top">
        <h4 class="font-weight-bold mb-4 text-dark" style="font-size: 1.3rem;">Cùng phân khúc <span class="text-primary">{{ $house->category->name }}</span></h4>
        <div class="row">
            @forelse ($related as $r_row)
                @php
                    $is_r_rented = \App\Models\Tenant::where('house_id', $r_row->id)->where('status', 1)->exists();
                    $is_r_sold = \App\Models\InstallmentRequest::where('house_id', $r_row->id)->where('status', 1)->exists();
                    
                    $r_img_class = '';
                    $r_btn_class = 'btn-action-base-sm';
                    $r_btn_text = 'XEM CHI TIẾT';

                    if($is_r_sold) {
                        $r_status_class = 'sold';
                        $r_status_text = 'Đã bán (Góp)';
                        $r_img_class = 'img-dimmed';
                        $r_btn_class .= ' btn-solid-gray-sm';
                        $r_btn_text = 'XEM THÔNG TIN';
                    } elseif($is_r_rented) {
                        $r_status_class = 'occupied';
                        $r_status_text = 'Đã thuê';
                        $r_img_class = 'img-dimmed';
                        $r_btn_class .= ' btn-solid-gray-sm';
                        $r_btn_text = 'XEM THÔNG TIN';
                    } else {
                        $r_status_class = 'available';
                        $r_status_text = 'Còn trống';
                    }

                    $r_img = !empty($r_row->img_path) ? asset('assets/uploads/' . $r_row->img_path) : asset('assets/uploads/no-image.jpg');
                    $r_sale_price = ($r_row->sale_price > 0) ? $r_row->sale_price : ($r_row->price * 100);
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="room-card">
                        <div class="room-img-wrap-sm">
                            <span class="room-status-badge-sm bg-{{ $r_status_class }}">{{ $r_status_text }}</span>
                            <img src="{{ $r_img }}" class="room-img {{ $r_img_class }}" alt="">
                        </div>
                        <div class="room-body-sm">
                            <div class="room-meta-row-sm">
                                <span class="cat-badge-sm">{{ $r_row->category->name ?? '' }}</span>
                                <span class="loc-tag-sm"><i class="fa fa-map-marker-alt"></i> {{ $r_row->locationDetail->location_name ?? '' }}</span>
                            </div>
                            <h4 class="room-title-sm">Phòng {{ $r_row->house_no }}</h4>
                            
                            <div class="price-block-sm mt-3">
                                <span class="price-label-sm">Giá thuê:</span>
                                <span class="price-rent-sm">{{ number_format($r_row->price, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="price-block-sm">
                                <span class="price-label-sm">Giá bán:</span>
                                <span class="price-sale-sm">{{ number_format($r_sale_price, 0, ',', '.') }}đ</span>
                            </div>

                            <a href="{{ url('view/' . $r_row->id) }}" class="{{ $r_btn_class }}">
                                {{ $r_btn_text }} <i class="fa fa-arrow-right ml-1" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-3 bg-white rounded border border-dashed" style="font-size: 0.9rem;">Chưa có phòng nào cùng phân khúc này.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

{{-- Dán code JS xuống cuối trang --}}
@push('scripts')
<script>
    function changeImg(src, element) {
        $('#displayImg').css('opacity', '0.5');
        setTimeout(function(){
            $('#displayImg').attr('src', src).css('opacity', '1');
        }, 150);
        $('.thumb-img').removeClass('active');
        $(element).addClass('active');
    }

    function booking(house_id) {
        if (!confirm("Bạn chắc chắn muốn gửi yêu cầu đặt phòng này?")) return;
        var btn = $('.btn-main-booking');
        btn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Đang xử lý...').prop('disabled', true);
        
        $.ajax({
            url: "{{ url('ajax/save_booking') }}", // Bro sẽ cần định nghĩa route này sau
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Laravel YÊU CẦU có cái này
                house_id: house_id,
                customer_id: "{{ session('login_customer_id') }}"
            },
            success: function (resp) {
                if (resp == 1) {
                    alert("🎉 Đặt phòng thành công! Chúng tôi sẽ liên hệ để xác nhận sớm nhất.");
                    location.href = "{{ url('my_account') }}";
                } else if (resp == 2) {
                    alert("⚠️ Bạn đã gửi yêu cầu đặt phòng này rồi, vui lòng chờ Ban Quản Lý duyệt nhé.");
                    btn.html('ĐẶT PHÒNG NGAY').prop('disabled', false);
                } else {
                    alert("Có lỗi xảy ra trong quá trình xử lý.");
                    btn.html('ĐẶT PHÒNG NGAY').prop('disabled', false);
                }
            }
        });
    }

    $('#manage-review').submit(function (e) {
        e.preventDefault();
        var btn = $('#btn-review');
        btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Đang gửi...');
        
        $.ajax({
            url: "{{ url('ajax/save_review') }}", // Cần định nghĩa route
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
                if (resp == 1) {
                    location.reload(); 
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                    btn.attr('disabled', false).html('Gửi bình luận');
                }
            }
        });
    });
</script>
@endpush