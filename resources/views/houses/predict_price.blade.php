@extends('layouts.app')

@push('styles')
<style>
    /* CSS của bro giữ nguyên */
    .ai-header-banner { background: linear-gradient(135deg, #0f172a 0%, #1e40af 100%); padding: 70px 0 80px 0; color: white; text-align: center; margin-bottom: -50px; border-radius: 0 0 50px 50px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3); position: relative; overflow: hidden; }
    .ai-header-banner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 20px 20px; opacity: 0.5; z-index: 0; }
    .ai-header-banner .container { position: relative; z-index: 1; }
    .ai-header-banner h2 { font-family: 'Playfair Display', serif; font-size: 2.8rem; font-weight: 700; margin-bottom: 10px; }
    .text-glow { color: #60a5fa; text-shadow: 0 0 15px rgba(96, 165, 250, 0.6); }
    .premium-card { background: #ffffff; border-radius: 24px; border: none; box-shadow: 0 15px 40px rgba(0,0,0,0.06); overflow: hidden; }
    .premium-card-header { background: #ffffff; padding: 25px 30px 15px; border-bottom: 1px solid #f1f5f9; }
    .premium-card-body { padding: 30px; }
    .custom-label { font-size: 0.85rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; }
    .custom-select-premium, .custom-input-premium { height: 55px; border-radius: 15px; border: 2px solid #e2e8f0; font-size: 1rem; font-weight: 500; color: #1e293b; padding: 10px 20px; transition: all 0.3s ease; background-color: #f8fafc; width: 100%; }
    .custom-select-premium:focus, .custom-input-premium:focus { border-color: #3b82f6; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); outline: none; }
    .custom-range { width: 100%; height: 8px; background: #e2e8f0; border-radius: 5px; outline: none; appearance: none; }
    .custom-range::-webkit-slider-thumb { appearance: none; width: 24px; height: 24px; border-radius: 50%; background: #3b82f6; cursor: pointer; border: 4px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
    .btn-ai-submit { background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%); color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 1.05rem; padding: 16px; transition: all 0.3s ease; box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4); text-transform: uppercase; letter-spacing: 1px; width: 100%; }
    .btn-ai-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5); color: white; }
    .ai-result-box { background: #0f172a; border-radius: 20px; padding: 30px; color: white; height: 100%; position: relative; overflow: hidden; border: 1px solid #1e293b; }
    .scanner-line { position: absolute; top: -100px; left: 0; width: 100%; height: 50px; background: linear-gradient(to bottom, transparent, rgba(59, 130, 246, 0.4), transparent); animation: scan 2s linear infinite; display: none; z-index: 10; }
    @keyframes scan { 0% { top: -50px; } 100% { top: 100%; } }
    .loader-container { text-align: center; margin-top: 50px; display: none; }
    .loader-icon { font-size: 3rem; color: #60a5fa; animation: spin 2s linear infinite; margin-bottom: 15px; }
    @keyframes spin { 100% { transform: rotate(360deg); } }
    .result-content { display: none; }
    .price-estimated { font-size: 2.8rem; font-weight: 800; color: #34d399; line-height: 1.1; margin-bottom: 5px; }
    .factor-list { margin-top: 25px; border-top: 1px solid #1e293b; padding-top: 20px; }
    .factor-item { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #94a3b8; }
    .factor-val { font-weight: 700; color: #f8fafc; }
</style>
@endpush

@section('content')
<div class="ai-header-banner">
    <div class="container">
        <h2>Dự Đoán Giá <span class="text-glow">Trí Tuệ Nhân Tạo</span></h2>
        <p>Thuật toán Machine Learning phân tích thông minh giúp bạn tìm mức giá tối ưu nhất thị trường</p>
    </div>
</div>

<div class="container mb-5" style="position: relative; z-index: 5; margin-top: 20px;">
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card premium-card">
                <div class="premium-card-header">
                    <h5 class="font-weight-bold text-dark mb-0"><i class="fa fa-robot text-primary mr-2"></i> Nhập thông số căn hộ</h5>
                </div>
                <div class="premium-card-body">
                    <form id="aiPredictForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mb-4">
                                <label class="custom-label">Tỉnh / Thành phố:</label>
                                <select class="form-control custom-select-premium" id="ai_city" required>
                                    <option value="Hồ Chí Minh">TP. Hồ Chí Minh</option>
                                    <option value="Hà Nội">Hà Nội</option>
                                    <option value="Bình Dương">Bình Dương</option>
                                    <option value="Đà Nẵng">Đà Nẵng</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-4">
                                <label class="custom-label">Quận / Huyện:</label>
                                <select class="form-control custom-select-premium" id="ai_district" required></select>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="custom-label d-flex justify-content-between">
                                Diện tích mong muốn: <span id="area_val" class="text-primary font-weight-bold">50 m²</span>
                            </label>
                            <input type="range" class="custom-range" id="ai_area" min="15" max="300" value="50" oninput="document.getElementById('area_val').innerText = this.value + ' m²'">
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Số phòng ngủ:</label>
                                <input type="number" id="ai_bedrooms" class="form-control custom-input-premium" value="2" min="0" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Số phòng tắm:</label>
                                <input type="number" id="ai_bathrooms" class="form-control custom-input-premium" value="1" min="0" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-ai-submit" id="btn-submit">
                            <i class="fa fa-bolt mr-2"></i> BẮT ĐẦU PHÂN TÍCH
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="ai-result-box shadow-lg">
                <div class="scanner-line" id="scannerLine"></div>
                <div class="text-center" id="idleState" style="margin-top: 80px; opacity: 0.5;">
                    <i class="fa fa-brain fa-5x mb-3"></i>
                    <h5 class="font-weight-light">Hệ thống đang chờ dữ liệu...</h5>
                </div>
                <div class="loader-container" id="loadingState">
                    <i class="fa fa-cog loader-icon d-block"></i>
                    <h5 class="mt-3 text-glow">Đang xử lý thuật toán...</h5>
                    <p class="text-muted small mt-2">Đối chiếu dữ liệu thị trường bằng mô hình AI</p>
                </div>
                <div class="result-content" id="resultState">
                    <h6 class="text-uppercase text-muted font-weight-bold"><i class="fa fa-check-circle text-success mr-2"></i>Hoàn tất phân tích</h6>
                    <div class="price-estimated" id="finalPrice">0 đ</div>
                    <div class="factor-list">
                        <div class="factor-item"><span><i class="fa fa-map-marker-alt mr-2 text-danger"></i>Khu vực:</span><span class="factor-val" id="res_loc">...</span></div>
                        <div class="factor-item"><span><i class="fa fa-expand-arrows-alt mr-2 text-info"></i>Diện tích:</span><span class="factor-val" id="res_area">0 m²</span></div>
                        <div class="factor-item"><span><i class="fa fa-bed mr-2 text-warning"></i>Phòng ngủ / Tắm:</span><span class="factor-val" id="res_rooms">0 / 0</span></div>
                    </div>
                    <a href="{{ url('rooms') }}" class="btn btn-outline-light btn-block mt-4 rounded-pill font-weight-bold">TÌM PHÒNG TƯƠNG TỰ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const locationData = {
        "Hồ Chí Minh": ["Quận 1", "Quận 3", "Quận 7", "Thủ Đức", "Bình Thạnh"],
        "Hà Nội": ["Cầu Giấy", "Hoàn Kiếm", "Đống Đa", "Hà Đông"],
        "Bình Dương": ["Thủ Dầu Một", "Dĩ An", "Thuận An", "Bến Cát"],
        "Đà Nẵng": ["Hải Châu", "Sơn Trà", "Ngũ Hành Sơn"]
    };
    $('#ai_city').change(function() {
        const districts = locationData[$(this).val()] || ["Quận Khác"];
        const $districtSelect = $('#ai_district');
        $districtSelect.empty();
        districts.forEach(d => $districtSelect.append(new Option(d, d)));
    }).trigger('change');

    $('#aiPredictForm').submit(function(e) {
        e.preventDefault();
        $('#idleState, #resultState').hide();
        $('#loadingState, #scannerLine').show();
        $('#btn-submit').prop('disabled', true);

        $.ajax({
            url: 'http://localhost:8001/predict',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                area: parseFloat($('#ai_area').val()),
                bedrooms: parseInt($('#ai_bedrooms').val()),
                bathrooms: parseInt($('#ai_bathrooms').val()),
                district: $('#ai_district').val(),
                city: $('#ai_city').val()
            }),
            success: function(resp) {
                setTimeout(() => {
                    $('#loadingState, #scannerLine').hide();
                    $('#resultState').fadeIn();
                    $('#btn-submit').prop('disabled', false);
                    animateValue("finalPrice", 0, Math.round(resp.predicted_price * 1000000), 1500);
                    $('#res_loc').text($('#ai_district').val() + ', ' + $('#ai_city').val());
                    $('#res_area').text($('#ai_area').val() + ' m²');
                    $('#res_rooms').text($('#ai_bedrooms').val() + ' PN / ' + $('#ai_bathrooms').val() + ' PT');
                }, 1500);
            },
            error: () => {
                alert("Lỗi kết nối AI!");
                $('#loadingState, #scannerLine').hide();
                $('#idleState').show();
                $('#btn-submit').prop('disabled', false);
            }
        });
    });

    function animateValue(id, start, end, duration) {
        var obj = document.getElementById(id);
        $({ count: start }).animate({ count: end }, {
            duration: duration,
            step: function() { obj.innerHTML = new Intl.NumberFormat('vi-VN').format(Math.floor(this.count)) + ' đ'; },
            complete: function() { obj.innerHTML = new Intl.NumberFormat('vi-VN').format(end) + ' đ'; }
        });
    }
</script>
@endpush