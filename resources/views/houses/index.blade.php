@extends('layouts.app')

@push('styles')
<style>
    /* =========================================================================
       STYLE ĐỒ HỌA SÀN BẤT ĐỘNG SẢN CAO CẤP - BÁM SÁT THỰC TẾ 100%
       ========================================================================= */
    body { background-color: #f8f9fc; font-family: 'Poppins', sans-serif; }
    .rooms-header-banner { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 75px 0 100px 0; color: white; text-align: center; position: relative; margin-bottom: 60px; }
    .rooms-header-banner h2 { font-size: 2.4rem; font-weight: 800; margin-bottom: 8px; letter-spacing: 0.5px; }
    .rooms-header-banner p { font-size: 1.05rem; opacity: 0.85; font-weight: 400; }
    .filter-floating-bar { background: #ffffff; border-radius: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.05), 8px 12px 0px rgba(244, 182, 25, 0.12); padding: 8px 15px; display: flex; align-items: center; position: absolute; bottom: -32px; left: 50%; transform: translateX(-50%); width: 92%; max-width: 1110px; z-index: 10; }
    .filter-item { flex: 1; display: flex; align-items: center; padding: 0 15px; }
    .filter-item:not(:last-child) { border-right: 1px solid #e2e8f0; }
    .filter-icon { color: #3b82f6; margin-right: 10px; font-size: 1rem; }
    .filter-input { border: none; outline: none; width: 100%; font-size: 0.95rem; font-weight: 500; color: #1e293b; background: transparent; }
    .filter-input::placeholder { color: #94a3b8; font-weight: 400; }
    .btn-filter-submit { background: #fbbf24; color: white; border: none; border-radius: 50px; font-weight: 700; padding: 12px 35px; font-size: 0.95rem; transition: all 0.2s ease; white-space: nowrap; }
    .btn-filter-submit:hover { background: #f59e0b; transform: scale(1.02); }
    .room-card { background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); height: 100%; display: flex; flex-direction: column; }
    .room-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.06); }
    .room-img-wrap { position: relative; height: 210px; overflow: hidden; border: none !important; padding: 0 !important; }
    .room-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .img-dimmed { filter: grayscale(35%) brightness(0.85); }
    .room-status-badge { position: absolute; top: 15px; left: 15px; padding: 5px 12px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; color: white; z-index: 2; }
    .status-available { background: #22c55e; } .status-occupied { background: #ef4444; } .status-sold { background: #4b5563; }
    .room-body { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
    .room-meta-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .cat-badge { background: #eff6ff; color: #2563eb; font-size: 0.78rem; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
    .room-card:nth-child(2n) .cat-badge { background: #f0fdf4; color: #16a34a; }
    .loc-tag { color: #ef4444; font-size: 0.82rem; font-weight: 700; display: flex; align-items: center; gap: 3px; }
    .room-title { font-size: 1.35rem; font-weight: 800; color: #1e293b; margin-bottom: 6px; }
    .room-desc { font-size: 0.85rem; color: #64748b; height: 42px; overflow: hidden; margin-bottom: 18px; line-height: 1.5; }
    .price-block { display: flex; align-items: center; margin-bottom: 6px; font-size: 0.92rem; }
    .price-label { color: #64748b; font-weight: 500; width: 85px; }
    .price-rent { color: #2563eb; font-weight: 700; }
    .price-sale { color: #ef4444; font-weight: 700; }
    .installment-promo-box { background: #fffdf5; border: 1px solid #fef3c7; border-left: 4px solid #f4b619; border-radius: 8px; padding: 10px 15px; margin-top: 10px; margin-bottom: 22px; text-align: left; }
    .promo-title { font-size: 0.75rem; font-weight: 700; color: #b45309; letter-spacing: 0.5px; margin-bottom: 2px; text-transform: uppercase; }
    .promo-value { font-size: 1.1rem; font-weight: 800; color: #d97706; }
    .btn-action-base { width: 100%; padding: 10px 0; border-radius: 50px; font-weight: 700; font-size: 0.88rem; text-align: center; transition: all 0.2s ease; display: block; text-decoration: none !important; margin-top: auto; letter-spacing: 0.5px; }
    .btn-outline-blue { background: #ffffff; color: #2563eb !important; border: 1.5px solid #3b82f6; }
    .btn-outline-blue:hover { background: #2563eb; color: #ffffff !important; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }
    .btn-solid-gray { background: #4b5563; color: #ffffff !important; border: 1.5px solid #4b5563; }
    .btn-solid-gray:hover { background: #374151; box-shadow: 0 4px 12px rgba(75, 85, 99, 0.25); }
    body.dark-mode .filter-floating-bar { background: #1a233a; border-color: #222d4a; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    body.dark-mode .filter-input { color: #f8fafc; }
    body.dark-mode .room-card { background: #1a233a; border-color: #222d4a; }
    body.dark-mode .room-title { color: #f8fafc; }
    body.dark-mode .btn-outline-blue { background: transparent; }
</style>
@endpush

@section('content')
<div class="rooms-header-banner">
    <div class="container">
        <h2>Danh Sách Không Gian Sống</h2>
        <p>Hệ thống quản lý phòng trọ hiện đại 5.0 - Becamex IDC Style</p>
        
        <form action="{{ url('rooms') }}" method="GET">
            <div class="filter-floating-bar">
                <div class="filter-item">
                    <i class="fa fa-search filter-icon"></i>
                    <input type="text" class="filter-input" name="keyword" placeholder="Tìm số phòng, địa chỉ..." value="{{ request('keyword') }}">
                </div>
                
                <div class="filter-item">
                    <i class="fa fa-map-marker-alt filter-icon"></i>
                    <select class="filter-input" name="location_id">
                        <option value="">Khu vực</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                                {{ $loc->location_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-item">
                    <i class="fa fa-home filter-icon"></i>
                    <select class="filter-input" name="cat">
                        <option value="">Loại phòng</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('cat') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-filter-submit">LỌC PHÒNG</button>
            </div>
        </form>
    </div>
</div>

<div class="container mb-5" style="margin-top: 50px;">
    <div class="row">
        @forelse($houses as $house)
            @php
                // Tạm thời dùng @php để tính trạng thái từng phòng giống hệt logic cũ của bro
                $is_rented = \App\Models\Tenant::where('house_id', $house->id)->where('status', 1)->exists();
                $is_sold_installment = \App\Models\InstallmentRequest::where('house_id', $house->id)->where('status', 1)->exists();
                
                $img_class = '';
                $btn_class = 'btn-outline-blue';
                $btn_text = 'XEM CHI TIẾT';

                if($is_sold_installment) {
                    $status_class = 'sold';
                    $status_text = 'Đã bán (Góp)';
                    $img_class = 'img-dimmed';
                    $btn_class = 'btn-solid-gray';
                    $btn_text = 'XEM THÔNG TIN';
                } elseif($is_rented) {
                    $status_class = 'occupied';
                    $status_text = 'Đã thuê';
                    $img_class = 'img-dimmed';
                    $btn_class = 'btn-solid-gray';
                    $btn_text = 'XEM THÔNG TIN';
                } else {
                    $status_class = 'available';
                    $status_text = 'Còn trống';
                }

                $img_name = str_replace(' ', '%20', $house->img_path);
                $img = !empty($img_name) ? asset('assets/uploads/' . $img_name) : asset('assets/uploads/no-image.jpg');
                
                $sale_price = ($house->sale_price > 0) ? $house->sale_price : ($house->price * 100);
                $monthly_pay_calc = round($sale_price / 12);
            @endphp

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="room-card">
                    <div class="room-img-wrap">
                        <span class="room-status-badge status-{{ $status_class }}">
                            {{ $status_text }}
                        </span>
                        <img src="{{ $img }}" class="room-img {{ $img_class }}" alt="">
                    </div>
                    
                    <div class="room-body">
                        <div class="room-meta-row">
                            <span class="cat-badge">{{ $house->category->name ?? 'Không rõ' }}</span>
                            <span class="loc-tag">
                                <i class="fa fa-map-marker-alt"></i> 
                                {{ $house->locationDetail ? $house->locationDetail->location_name : 'Bình Dương' }}
                            </span>
                        </div>

                        <h4 class="room-title">Phòng {{ $house->house_no }}</h4>
                        <p class="room-desc text-muted small">{{ strip_tags($house->description) }}</p>
                        
                        <div class="price-block">
                            <span class="price-label">Giá thuê:</span>
                            <span class="price-rent">{{ number_format($house->price, 0, ',', '.') }}đ<span class="text-muted font-weight-normal" style="font-size:0.82rem;">/tháng</span></span>
                        </div>
                        <div class="price-block">
                            <span class="price-label">Giá bán:</span>
                            <span class="price-sale">{{ number_format($sale_price, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="installment-promo-box">
                            <div class="promo-title">Ưu đãi trả góp 12 tháng</div>
                            <div class="promo-value">{{ number_format($monthly_pay_calc, 0, ',', '.') }}đ <span style="font-size:0.8rem; font-weight:500; color:#b45309;">/tháng</span></div>
                        </div>

                        <a href="{{ url('view/' . $house->id) }}" class="btn-action-base {{ $btn_class }}">
                            {{ $btn_text }} <i class="fa fa-arrow-right ml-1" style="font-size: 0.75rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fa fa-search-minus fa-4x text-muted mb-3" style="opacity: 0.4;"></i>
                <h5 class="font-weight-bold text-secondary">Không tìm thấy căn hộ nào phù hợp</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection