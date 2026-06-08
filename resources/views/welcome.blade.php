@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* CSS TRANG CHỦ GIỮ NGUYÊN */
    .ticker-wrap { width: 100%; overflow: hidden; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(5px); border-bottom: 1px solid rgba(78, 115, 223, 0.1); padding: 12px 0; position: relative; z-index: 10; }
    .ticker-content { display: flex; white-space: nowrap; animation: ticker-animation 35s linear infinite; }
    .ticker-item { display: inline-block; padding: 0 50px; font-size: 0.95rem; color: #4e73df; font-weight: 600; }
    .ticker-item i { color: #f6c23e; margin-right: 8px; }
    @keyframes ticker-animation { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
    .ticker-wrap:hover .ticker-content { animation-play-state: paused; cursor: default; }

    /* ĐÃ FIX LINK ẢNH NỀN BẰNG ASSET CỦA LARAVEL */
    .hero-wrap::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.65); z-index: 1; }
    .hero-content { position: relative; z-index: 2; padding: 0 20px; width: 100%; }
    .hero-title { font-family: 'Playfair Display', serif; font-weight: 700; color: #ffffff; margin-bottom: 20px; line-height: 1.3; text-shadow: 0 5px 15px rgba(0,0,0,0.5); }
    .text-gold { color: #f4b619; }
    .hero-subtitle { color: #e2e8f0; font-size: 1.2rem; font-weight: 400; letter-spacing: 0.5px; margin-bottom: 40px; }
    .btn-gold-search { background: #f4b619; color: #fff; border-radius: 50px; font-weight: 700; font-size: 1.1rem; padding: 14px 45px; border: none; transition: 0.3s; display: inline-block; text-decoration: none !important; box-shadow: 0 5px 15px rgba(244, 182, 25, 0.4); }
    .btn-gold-search:hover { background: #dfa00b; color: #fff; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(244, 182, 25, 0.6); }

    .area-card { position: relative; border-radius: 20px; overflow: hidden; height: 250px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; margin-bottom: 20px; border: none; display: block; }
    .area-card img { width: 100%; height: 100%; object-fit: cover; transition: all 0.5s ease; }
    .area-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, transparent 100%); z-index: 2; }
    .area-info { position: absolute; bottom: 20px; left: 20px; z-index: 3; color: white; text-align: left; }
    .area-name { font-size: 1.25rem; font-weight: 700; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
    .area-count { font-size: 0.85rem; opacity: 0.85; font-weight: 500; }
    .area-card:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(78, 115, 223, 0.15); }
    .area-card:hover img { transform: scale(1.1); }

    .room-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.03); transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.02); height: 100%; display: flex; flex-direction: column; }
    .room-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
    .room-img-wrap { position: relative; height: 200px; overflow: hidden; }
    .room-img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .room-card:hover .room-img { transform: scale(1.08); }
    .room-badge { position: absolute; top: 15px; left: 15px; padding: 5px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; color: white; z-index: 2; box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
    .bg-available { background: #22c55e; } .bg-occupied { background: #ef4444; } .bg-sold { background: #4b5563; }      
    .room-body { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
    .room-meta-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .room-cat { color: #4e73df; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .room-location-tag { color: #e74c3c; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 4px; }
    .room-title { font-size: 1.35rem; font-weight: 800; color: #1e293b; margin-bottom: 15px; }
    .price-container { background: #f8f9fc; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #f1f5f9; }
    .price-row { display: flex; justify-content: space-between; align-items: center; padding: 4px 0; }
    .price-label { font-size: 0.88rem; color: #64748b; font-weight: 500; }
    .price-value-rent { font-size: 1.05rem; font-weight: 700; color: #4e73df; }
    .price-value-sale { font-size: 1.05rem; font-weight: 700; color: #e74c3c; }
    .btn-view-detail { background: #f1f5f9; color: #4e73df; border: none; width: 100%; padding: 12px; border-radius: 12px; font-weight: 700; transition: 0.2s; font-size: 0.95rem; text-align: center; display: block; text-decoration: none !important; }
    .room-card:hover .btn-view-detail { background: #4e73df; color: white; }

    .eco-card { border: none; border-radius: 20px; transition: all 0.3s ease; background: #fff; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.03); }
    .eco-card:hover { transform: translateY(-12px); box-shadow: 0 15px 35px rgba(78, 115, 223, 0.12); }
    .eco-icon { width: 70px; height: 70px; line-height: 70px; background: #eff6ff; color: #4e73df; border-radius: 50%; margin: 0 auto 20px; font-size: 28px; transition: 0.3s; }
    .eco-card:hover .eco-icon { background: #4e73df; color: white; transform: rotateY(180deg); }
    .feature-box { border: none; border-radius: 20px; transition: 0.3s; box-shadow: 0 5px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; }
    .feature-box:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    
    /* ĐÃ FIX LINK ẢNH NỀN THỐNG KÊ */
    .stat-section { background-image: url('{{ asset("assets/img/stat-bg.jpg") }}'); background-color: #1e293b; background-size: cover; background-position: center; background-attachment: fixed; position: relative; border-radius: 30px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    .stat-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.85); z-index: 1; }
    .stat-item { position: relative; z-index: 2; padding: 20px; transition: 0.3s; }
    .stat-item:hover { transform: translateY(-5px); }
    .counter-value { font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.3); }
    .partner-section { background: #ffffff; border-radius: 50px 50px 0 0; }
    .partner-logo{
        opacity:.9;
        transition:all .3s ease;
        max-height:70px;
        margin:20px;
        object-fit:contain;
    }

    .partner-logo:hover{
        opacity:1;
        transform:translateY(-3px) scale(1.05);
    }
    .title-divider { width: 70px; height: 4px; background: linear-gradient(90deg, #4e73df, #224abe); border-radius: 10px; margin: 15px auto; }
    .hero-wrap{
        position:relative;
        height:575px;
        overflow:hidden;
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius: 0 0 4rem 4rem;
    }

    .hero-video{
        position:absolute;
        top:50%;
        left:50%;
        min-width:100%;
        min-height:100%;
        width:auto;
        height:auto;
        transform:translate(-50%,-50%);
        object-fit:cover;
        z-index:1;
    }

    .hero-overlay{
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,.45);
        z-index:2;
    }

    .hero-content{
        position:relative;
        z-index:3;
        color:white;
        max-width:850px;
        padding:20px;
    }

    .hero-title{
        font-size:3.8rem;
        font-weight:800;
        line-height:1.2;
        margin-bottom:25px;
    }

    .text-gold{
        color:#f4b619;
    }

    .hero-subtitle{
        font-size:1.2rem;
        margin-bottom:35px;
        opacity:.95;
    }

    .btn-gold-search{
        background:linear-gradient(135deg,#f4b619,#ffce47);
        color:#111;
        border-radius:50px;
        padding:14px 35px;
        font-weight:700;
        border:none;
    }

    .btn-gold-search:hover{
        transform:translateY(-3px);
        color:#111;
    }

    @media(max-width:768px){

    .hero-title{
        font-size:2.3rem;
    }

    .hero-subtitle{
        font-size:1rem;
    }

    }

    .area-slider-wrap{
        overflow:hidden;
        width:100%;
        position:relative;
        padding-top:18px;
        padding-bottom:28px;
    }
    
    .area-slider-track{

        display:flex;
        gap:25px;
        width:max-content;

        animation:autoAreaSlide 30s linear infinite;
    }

    .area-slider-track:hover{
        animation-play-state:paused;
    }

    .area-item{
        width:280px;
        flex-shrink:0;
    }

    @keyframes autoAreaSlide{

        from{
            transform:translateX(0);
        }

        to{
            transform:translateX(calc(-50%));
        }

    }

    @media(max-width:768px){

    .area-item{
        width:220px;
    }

    }
</style>
@endpush

@section('content')

<div class="ticker-wrap shadow-sm">
    <div class="ticker-content">
        <div class="ticker-item"><i class="fa fa-bullhorn"></i> Chào mừng đến với Quản Gia 5.0 - Hệ thống quản lý phòng trọ hiện đại nhất!</div>
        <div class="ticker-item"><i class="fa fa-gift"></i> Ưu đãi đặc biệt: Giảm 10% tiền phòng tháng đầu cho sinh viên năm nhất!</div>
        <div class="ticker-item"><i class="fa fa-shield-alt"></i> Cam kết an ninh: Hệ thống Camera và khóa vân tay hoạt động 24/7.</div>
        <div class="ticker-item"><i class="fa fa-info-circle"></i> Miễn phí 100% phí dịch vụ internet tốc độ cao khi đặt phòng trong tuần này.</div>
        <div class="ticker-item"><i class="fa fa-map-marker-alt"></i> Mới cập nhật: Đã có thêm phòng trống tại khu vực Thuận An và Dĩ An.</div>
    </div>
</div>

<div class="hero-wrap">

    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('assets/video/banner.mp4') }}"
                type="video/mp4">
    </video>

    <div class="hero-overlay"></div>

    <div class="hero-content text-center">
        <h1 class="hero-title">
            Tìm Kiếm Không Gian Sống
            <br>
            <span class="text-gold">
                Lý Tưởng Của Bạn
            </span>
        </h1>

        <p class="hero-subtitle">
            BecameS - Hệ thống phòng trọ an ninh và tiện nghi hàng đầu.
        </p>

        <a href="{{ url('rooms') }}"
           class="btn btn-gold-search shadow-lg">

            Bắt đầu tìm kiếm ngay
            <i class="fa fa-arrow-right ml-2"></i>

        </a>
    </div>

</div>

<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-dark">Khám Phá Khu Vực</h2>
        <div class="title-divider"></div>
    </div>
    <div class="area-slider-wrap">

        <div class="area-slider-track">

            @foreach($locations as $area)

                @php
                    $img_name=str_replace(' ','%20',$area->img_path);

                    $area_img=!empty($img_name)
                        ? asset('assets/uploads/'.$img_name)
                        : asset('assets/uploads/no-image.jpg');
                @endphp

                <div class="area-item">

                    <a href="{{ url('rooms?location_id='.$area->id) }}"
                    class="card area-card">

                        <img src="{{ $area_img }}">

                        <div class="area-overlay"></div>

                        <div class="area-info">

                            <div class="area-name">
                                {{ $area->location_name }}
                            </div>

                            <div class="area-count">
                                {{ $area->empty_rooms }}
                                phòng trống
                            </div>

                        </div>

                    </a>

                </div>

            @endforeach


            {{-- duplicate để chạy vô hạn --}}

            @foreach($locations as $area)

                @php
                    $img_name=str_replace(' ','%20',$area->img_path);

                    $area_img=!empty($img_name)
                        ? asset('assets/uploads/'.$img_name)
                        : asset('assets/uploads/no-image.jpg');
                @endphp

                <div class="area-item">

                    <a href="{{ url('rooms?location_id='.$area->id) }}"
                    class="card area-card">

                        <img src="{{ $area_img }}">

                        <div class="area-overlay"></div>

                        <div class="area-info">

                            <div class="area-name">
                                {{ $area->location_name }}
                            </div>

                            <div class="area-count">
                                {{ $area->empty_rooms }}
                                phòng trống
                            </div>

                        </div>

                    </a>

                </div>

            @endforeach

        </div>

    </div>
</div>

<div class="container py-4">
    <div class="text-center mb-5">
        <h6 class="text-primary font-weight-bold text-uppercase" style="letter-spacing: 2px;">Tầm Nhìn Chiến Lược</h6>
        <h2 class="font-weight-bold text-dark">Hệ Sinh Thái Toàn Diện</h2>
        <div class="title-divider"></div>
    </div>
    <div class="row">
        {{-- Khối Hệ sinh thái giữ nguyên HTML... --}}
        <div class="col-md-3 mb-4"><div class="eco-card p-4 border h-100"><div class="eco-icon"><i class="fa fa-city"></i></div><h6 class="font-weight-bold text-dark">Hạ Tầng Hiện Đại</h6><p class="small text-muted mb-0">Phát triển chuỗi phòng trọ chuẩn đô thị thông minh theo định hướng Becamex IDC.</p></div></div>
        <div class="col-md-3 mb-4"><div class="eco-card p-4 border h-100"><div class="eco-icon"><i class="fa fa-robot"></i></div><h6 class="font-weight-bold text-dark">Giải Pháp AI</h6><p class="small text-muted mb-0">Tích hợp AI hỗ trợ cư dân tìm kiếm phòng và dự đoán mức giá thông minh nhất.</p></div></div>
        <div class="col-md-3 mb-4"><div class="eco-card p-4 border h-100"><div class="eco-icon"><i class="fa fa-users-cog"></i></div><h6 class="font-weight-bold text-dark">Quản Trị Số</h6><p class="small text-muted mb-0">Số hóa toàn diện hợp đồng, điện nước và các thủ tục hành chính dành cho cư dân.</p></div></div>
        <div class="col-md-3 mb-4"><div class="eco-card p-4 border h-100"><div class="eco-icon"><i class="fa fa-seedling"></i></div><h6 class="font-weight-bold text-dark">Môi Trường Xanh</h6><p class="small text-muted mb-0">Tạo dựng cộng đồng văn minh, thân thiện và phát triển bền vững cho sinh viên.</p></div></div>
    </div>
</div>

<div class="container py-4">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-dark">Tại Sao Nên Chọn Quản Gia 5.0?</h2>
        <div class="title-divider"></div>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="p-4 bg-white shadow-sm h-100 feature-box">
                <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5 class="font-weight-bold text-dark">An Ninh Tuyệt Đối</h5>
                <p class="text-muted small">Hệ thống camera giám sát và khóa vân tay hiện đại, đảm bảo an toàn 24/7 cho cư dân.</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 bg-white shadow-sm h-100 feature-box">
                <i class="fa fa-hand-holding-usd fa-3x text-warning mb-3"></i>
                <h5 class="font-weight-bold text-dark">Giá Cả Minh Bạch</h5>
                <p class="text-muted small">Mọi chi phí điện, nước, dịch vụ được liệt kê rõ ràng, không có bất kỳ chi phí ẩn nào.</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 bg-white shadow-sm h-100 feature-box">
                <i class="fa fa-headset fa-3x text-success mb-3"></i>
                <h5 class="font-weight-bold text-dark">Hỗ Trợ Thông Minh</h5>
                <p class="text-muted small">Sử dụng Chatbot AI và hệ thống trực tuyến để giải quyết mọi yêu cầu của bạn tức thì.</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5" id="featured-rooms">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="section-title">
            <h2 class="font-weight-bold text-dark mb-0">Phòng Mới Cập Nhật</h2>
            <div style="width: 60px; height: 4px; background: #4e73df; margin-top: 10px; border-radius: 10px;"></div>
        </div>
        <a href="{{ url('rooms') }}" class="text-primary font-weight-bold" style="text-decoration: none;">Xem tất cả <i class="fa fa-arrow-right ml-1"></i></a>
    </div>

    <div class="row">
        @foreach($featured_rooms as $room)
            @php
                // Kiểm tra bằng Query Builder thay vì SQL Raw
                $is_rented = \App\Models\Tenant::where('house_id', $room->id)->where('status', 1)->exists();
                $is_sold_installment = \App\Models\InstallmentRequest::where('house_id', $room->id)->where('status', 1)->exists();
                
                if($is_sold_installment) {
                    $status_class = 'sold'; $status_text = 'Đã bán (Góp)';
                } elseif($is_rented) {
                    $status_class = 'occupied'; $status_text = 'Đã thuê';
                } else {
                    $status_class = 'available'; $status_text = 'Còn trống';
                }
                
                $img = !empty($room->img_path) ? asset('assets/uploads/'.str_replace(' ', '%20', $room->img_path)) : asset('assets/uploads/no-image.jpg');
                $sale_price = ($room->sale_price > 0) ? $room->sale_price : ($room->price * 100);
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="room-card shadow-sm">
                    <div class="room-img-wrap">
                        <span class="room-badge bg-{{ $status_class }}">{{ $status_text }}</span>
                        <img src="{{ $img }}" class="room-img" alt="Phòng {{ $room->house_no }}">
                    </div>
                    <div class="room-body">
                        <div class="room-meta-row">
                            <div class="room-cat">{{ $room->category->name ?? '' }}</div>
                            <div class="room-location-tag"><i class="fa fa-map-marker-alt"></i> {{ $room->locationDetail->location_name ?? '' }}</div>
                        </div>
                        <h4 class="room-title">Phòng {{ $room->house_no }}</h4>
                        <div class="price-container">
                            <div class="price-row">
                                <span class="price-label">Giá thuê:</span>
                                <span class="price-value-rent">{{ number_format($room->price, 0, ',', '.') }}đ <small class="text-muted" style="font-size:0.75rem;">/tháng</small></span>
                            </div>
                            <div class="price-row" style="border-top: 1px dashed #e2e8f0; margin-top: 4px; padding-top: 6px;">
                                <span class="price-label">Giá bán:</span>
                                <span class="price-value-sale">{{ number_format($sale_price, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                        <a href="{{ url('view/'.$room->id) }}" class="btn-view-detail">Xem chi tiết căn phòng</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="text-center mt-4">
    <a href="{{ url('rooms') }}" class="btn btn-outline-primary px-5 py-3" style="border-radius: 50px; font-weight: 700; border-width: 2px;">
        Khám Phá Toàn Bộ Danh Sách
    </a>
</div>

<div class="container-fluid py-5 my-5" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; box-shadow: 0 10px 30px rgba(78, 115, 223, 0.2); border-radius: 20px;">
    <div class="container py-4 text-center text-md-left">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="font-weight-bold mb-3">Bạn chưa biết chọn phòng nào phù hợp?</h2>
                <p class="mb-0 opacity-75" style="font-size: 1.1rem;">
                    Hãy sử dụng công cụ Dự đoán giá bằng Trí Tuệ Nhân Tạo (AI) của hệ thống Quản Gia 5.0 để tìm ra căn phòng tối ưu nhất với tài chính của bạn.
                </p>
            </div>

            <div class="col-md-4 text-md-right mt-4 mt-md-0">
                <a href="{{ url('predict_price') }}" class="btn btn-light px-5 py-3 font-weight-bold shadow-sm" style="border-radius: 50px; color: #4e73df; font-size: 1.1rem;">
                    Trải nghiệm AI ngay <i class="fa fa-robot ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 mb-5 mt-5">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-dark">Khách Hàng Nói Gì Về Chúng Tôi</h2>
        <div class="title-divider"></div>
    </div>
    <div class="row">
        @forelse($reviews as $rev)
            @php
                if(!empty($rev->customer->avatar)) {
                    $avt_file = str_replace(' ', '%20', $rev->customer->avatar);
                    $avatar_url = asset('assets/uploads/' . $avt_file);
                } else {
                    $avatar_url = 'https://ui-avatars.com/api/?name='.urlencode($rev->customer->name).'&background=random&color=fff';
                }
            @endphp
            <div class="col-md-4 mb-4">
                <div class="p-4 border shadow-sm h-100 bg-white" style="border-radius: 20px;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $avatar_url }}" class="rounded-circle mr-3" width="55" height="55" style="object-fit: cover;" alt="">
                        <div>
                            <h6 class="mb-0 font-weight-bold text-dark">{{ $rev->customer->name }}</h6>
                            <small class="text-warning">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fa fa-star {{ $i <= $rev->rating ? '' : 'text-light' }}"></i>
                                @endfor
                            </small>
                        </div>
                    </div>
                    <p class="text-muted font-italic small" style="line-height: 1.6;">"{{ $rev->comment ?? 'Tuyệt vời!' }}"</p>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted"><p>Hiện chưa có đánh giá nào từ khách hàng.</p></div>
        @endforelse
    </div>
</div>

<section class="stat-section container my-5">
    <div class="stat-overlay"></div> 
    <div class="position-relative py-5" style="z-index: 2;">
        <div class="row text-center px-4" id="counter-section">
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <div class="stat-item">
                    <i class="fa fa-building fa-3x text-primary mb-3" style="filter: drop-shadow(0 0 10px rgba(78,115,223,0.5));"></i>
                    <h2 class="font-weight-bold text-white counter-value" data-count="{{ $total_rooms }}">0</h2>
                    <p class="text-white-50 text-uppercase small font-weight-bold mb-0">Căn Hộ Sở Hữu</p>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <div class="stat-item">
                    <i class="fa fa-users fa-3x text-success mb-3" style="filter: drop-shadow(0 0 10px rgba(16,185,129,0.5));"></i>
                    <h2 class="font-weight-bold text-white counter-value" data-count="{{ $total_customers }}">0</h2>
                    <p class="text-white-50 text-uppercase small font-weight-bold mb-0">Cư Dân Phục Vụ</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <i class="fa fa-key fa-3x text-warning mb-3" style="filter: drop-shadow(0 0 10px rgba(245,158,11,0.5));"></i>
                    <h2 class="font-weight-bold text-white counter-value" data-count="{{ $rented_rooms }}">0</h2>
                    <p class="text-white-50 text-uppercase small font-weight-bold mb-0">Đã Ký Hợp Đồng</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <i class="fa fa-door-open fa-3x text-info mb-3" style="filter: drop-shadow(0 0 10px rgba(54,185,204,0.5));"></i>
                    <h2 class="font-weight-bold text-white counter-value" data-count="{{ $available_rooms }}">0</h2>
                    <p class="text-white-50 text-uppercase small font-weight-bold mb-0">Phòng Đang Trống</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="partner-section py-5 shadow-sm mt-5">
    <div class="container">
        <div class="text-center mb-4">
            <h5 class="font-weight-bold text-muted" style="letter-spacing: 3px;">ĐỐI TÁC ĐỒNG HÀNH</h5>
        </div>

        <div class="row align-items-center justify-content-center text-center px-4">

            <div class="col-6 col-md-2 mb-3">
                <img src="{{ asset('assets/img/partners/becamex.jpg') }}"
                    class="partner-logo img-fluid"
                    alt="BecameS">
            </div>

            <div class="col-6 col-md-2 mb-3">
                <img src="{{ asset('assets/img/partners/vsip.png') }}"
                    class="partner-logo img-fluid"
                    alt="VSIP">
            </div>

            <div class="col-6 col-md-2 mb-3">
                <img src="{{ asset('assets/img/partners/microsoft.png') }}"
                    class="partner-logo img-fluid"
                    alt="Microsoft">
            </div>

            <div class="col-6 col-md-2 mb-3">
                <img src="{{ asset('assets/img/partners/fpt.png') }}"
                    class="partner-logo img-fluid"
                    alt="FPT">
            </div>

            <div class="col-6 col-md-2 mb-3">
                <img src="{{ asset('assets/img/partners/Becamex_group.png') }}"
                    class="partner-logo img-fluid"
                    alt="Becamex Group">
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var animated = false;
        $(window).scroll(function() {
            var counterSection = $('#counter-section');
            if (counterSection.length) {
                var oTop = counterSection.offset().top - window.innerHeight;
                if (!animated && $(window).scrollTop() > oTop) {
                    $('.counter-value').each(function() {
                        var $this = $(this),
                            countTo = $this.attr('data-count');
                        $({ countNum: $this.text() }).animate({
                                countNum: countTo
                            },
                            {
                                duration: 1500,
                                easing: 'swing',
                                step: function() {
                                    $this.text(Math.floor(this.countNum));
                                },
                                complete: function() {
                                    $this.text(this.countNum);
                                }
                            });
                    });
                    animated = true;
                }
            }
        });
    });
</script>
@endpush