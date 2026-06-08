@extends('layouts.app')

@push('styles')
<style>
    /* TOÀN BỘ CSS CỦA BRO ĐƯỢC BẢO TOÀN TẠI ĐÂY */
    .contact-header-banner { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 80px 0 130px 0; color: white; text-align: center; border-radius: 0 0 50px 50px; box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2); position: relative; }
    .contact-header-banner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px; border-radius: 0 0 50px 50px; }
    .contact-title { font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 700; margin-bottom: 10px; text-shadow: 0 4px 15px rgba(0,0,0,0.3); position: relative; z-index: 2; }
    .contact-subtitle { font-size: 1.1rem; opacity: 0.9; font-weight: 400; letter-spacing: 0.5px; position: relative; z-index: 2; }
    .text-gold { color: #f4b619; }
    .premium-wrapper { margin-top: -80px; position: relative; z-index: 10; }
    .premium-card { background: #ffffff; border-radius: 24px; border: 1px solid #f1f5f9; box-shadow: 0 15px 40px rgba(0,0,0,0.06); transition: transform 0.3s ease; }
    .premium-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(0,0,0,0.1); }
    .icon-box { width: 55px; height: 55px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
    .bg-soft-blue { background: #eff6ff; color: #3b82f6; }
    .bg-soft-green { background: #f0fdf4; color: #16a34a; }
    .bg-soft-gold { background: #fffdf5; color: #d97706; border: 1px solid #fef3c7; }
    .custom-label { font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
    .form-floating-input { background-color: #f8fafc !important; border: 2px solid #e2e8f0 !important; border-radius: 15px !important; padding: 15px 20px !important; font-size: 0.95rem; color: #1e293b; transition: all 0.3s ease; }
    .form-floating-input:focus { background-color: #ffffff !important; border-color: #3b82f6 !important; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important; }
    .btn-gold-submit { background: #f4b619; color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 1.05rem; padding: 16px; transition: all 0.3s ease; box-shadow: 0 6px 15px rgba(244, 182, 25, 0.3); text-transform: uppercase; letter-spacing: 1px; }
    .btn-gold-submit:hover { background: #dfa00b; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(244, 182, 25, 0.4); color: white; }
    .map-frame { border-radius: 16px; overflow: hidden; border: 2px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
</style>
@endpush

@section('content')
<div class="contact-header-banner">
    <div class="container">
        <h6 class="text-uppercase font-weight-bold mb-2" style="letter-spacing: 2px; color: #93c5fd;">Trung tâm chăm sóc</h6>
        <h1 class="contact-title">Liên Hệ <span class="text-gold">Tư Vấn</span></h1>
        <p class="contact-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và đồng hành cùng không gian sống của bạn.</p>
    </div>
</div>

<div class="container premium-wrapper mb-5">
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="premium-card p-4 p-md-5 h-100">
                <h4 class="font-weight-bold text-dark mb-4">Thông tin hệ thống</h4>
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box bg-soft-blue"><i class="fa fa-map-marker-alt"></i></div>
                    <div class="ml-3"><div class="custom-label mb-1">ĐỊA CHỈ TRỤ SỞ</div><div class="text-dark font-weight-medium">Đại lộ Bình Dương, Phú Cường, Thủ Dầu Một, Bình Dương</div></div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box bg-soft-green"><i class="fa fa-phone-alt"></i></div>
                    <div class="ml-3"><div class="custom-label mb-1">HOTLINE TRỰC TUYẾN</div><div class="text-dark font-weight-bold h5 mb-0">1900 1560</div></div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box bg-soft-gold"><i class="fa fa-envelope-open"></i></div>
                    <div class="ml-3"><div class="custom-label mb-1">EMAIL TIẾP NHẬN</div><div class="text-dark font-weight-medium">cskh@quangia50.vn</div></div>
                </div>
                <hr class="my-4">
                <h5 class="font-weight-bold text-dark mb-3"><i class="fa fa-crosshairs text-primary mr-2"></i> Định vị bản đồ</h5>
                <div class="map-frame">
                    <iframe src="https://www.google.com/maps/embed?..." width="100%" height="240" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="premium-card p-4 p-md-5 h-100">
                <div class="mb-4 pb-2 border-bottom">
                    <h4 class="font-weight-bold text-dark mb-2">Gửi yêu cầu trực tuyến</h4>
                    <p class="text-muted small">Ban quản lý cam kết sẽ liên hệ và giải quyết vấn đề của bạn trong vòng 24 giờ làm việc.</p>
                </div>

                <form id="contact-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-4">
                            <label class="custom-label">HỌ VÀ TÊN:</label>
                            <input type="text" name="name" class="form-control form-floating-input" value="{{ session('login_customer_name', '') }}" required {{ session()->has('login_customer_id') ? 'readonly' : '' }}>
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label class="custom-label">ĐỊA CHỈ EMAIL:</label>
                            <input type="email" name="email" class="form-control form-floating-input" value="{{ session('login_customer_email', '') }}" required {{ session()->has('login_customer_id') ? 'readonly' : '' }}>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label class="custom-label">TIÊU ĐỀ HỖ TRỢ:</label>
                        <input type="text" name="subject" class="form-control form-floating-input" placeholder="Vấn đề bạn quan tâm là gì?" required>
                    </div>
                    <div class="form-group mb-5">
                        <label class="custom-label">NỘI DUNG CHI TIẾT:</label>
                        <textarea name="message" class="form-control form-floating-input" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-gold-submit btn-block">GỬI THÔNG TIN YÊU CẦU <i class="fa fa-paper-plane ml-2"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#contact-form').submit(function(e){
        e.preventDefault();
        var btn = $(this).find('button');
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Đang truyền dữ liệu...').prop('disabled', true);

        $.ajax({
            url: "{{ url('/contact/submit') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp.trim() == '1'){
                    alert("🎉 Tuyệt vời! Quản Gia 5.0 đã nhận được yêu cầu của bạn.");
                    location.reload();
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                    btn.html(originalText).prop('disabled', false);
                }
            }
        });
    });
</script>
@endpush