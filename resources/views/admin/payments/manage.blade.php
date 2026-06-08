<div class="container-fluid py-2">
    <form id="manage-payment">
        @csrf

        <input type="hidden" name="id" value="{{ $payment->id ?? '' }}">
        <div id="msg"></div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Khách thuê phòng</label>

                    <select name="tenant_id" id="tenant_id" class="custom-select select2" required>
                        <option value=""></option>

                        @foreach($tenants as $tenant)
                            @php
                                $tenantName = trim(($tenant->lastname ?? '').', '.($tenant->firstname ?? '').' '.($tenant->middlename ?? ''));
                            @endphp

                            <option value="{{ $tenant->id }}"
                                    data-price="{{ $tenant->house->price ?? 0 }}"
                                    data-house="{{ $tenant->house->house_no ?? '' }}"
                                    data-name="{{ $tenantName }}"
                                    {{ isset($payment) && $payment->tenant_id == $tenant->id ? 'selected' : '' }}>
                                Phòng {{ $tenant->house->house_no ?? '' }} - {{ ucwords($tenantName) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="details"></div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Mã Hóa đơn</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-primary">HD-</span>
                        </div>

                        <input type="text"
                               class="form-control font-weight-bold"
                               name="invoice"
                               value="{{ $payment->invoice ?? random_int(100000, 999999) }}"
                               readonly
                               style="background-color:#f8f9fc;">

                        @if(!isset($payment))
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary"
                                        type="button"
                                        id="btn-random-code"
                                        title="Tạo mã khác">
                                    <i class="fa fa-sync-alt"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    <small class="text-muted">Mã tự động, không trùng lặp.</small>
                </div>
            </div>
        </div>

        <hr>

        <label class="control-label text-primary">
            <i class="fa fa-calculator"></i> Chi phí phát sinh tháng này:
        </label>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Tiền Điện</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-bolt text-warning"></i>
                            </span>
                        </div>

                        <input type="number"
                               class="form-control text-right calculate-total"
                               min="0"
                               name="cost_electric"
                               id="cost_electric"
                               value="{{ $payment->cost_electric ?? 0 }}">

                        <div class="input-group-append">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Tiền Nước</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-tint text-info"></i>
                            </span>
                        </div>

                        <input type="number"
                               class="form-control text-right calculate-total"
                               min="0"
                               name="cost_water"
                               id="cost_water"
                               value="{{ $payment->cost_water ?? 0 }}">

                        <div class="input-group-append">
                            <span class="input-group-text">đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="total-box shadow-sm">
                    <label class="control-label" style="font-size:1rem;">
                        TỔNG THANH TOÁN (Tiền phòng + Điện + Nước)
                    </label>

                    <div class="input-group">
                        <input type="number"
                               class="form-control text-right"
                               style="font-size:1.5rem;font-weight:bold;color:#c62828;height:50px;"
                               name="amount"
                               min="0"
                               id="amount"
                               value="{{ $payment->amount ?? 0 }}"
                               readonly>

                        <div class="input-group-append">
                            <span class="input-group-text" style="font-size:1.2rem;font-weight:bold;">
                                VNĐ
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-4">

        <label class="control-label text-success">
            <i class="fa fa-share-alt"></i> Thông tin Thanh toán & Gửi khách hàng:
        </label>

        <div class="row">
            <div class="col-md-5 text-center">
                <div style="border:2px dashed #28a745;padding:10px;border-radius:10px;background:#f8fff9;">
                    <b class="text-success mb-2 d-block">Quét mã VietQR</b>

                    <img id="vietqr-img"
                         src="https://img.vietqr.io/image/MB-123456789-compact2.png?amount=0&addInfo=Thanh%20toan%20tien%20phong"
                         alt="VietQR"
                         style="width:100%;max-width:200px;border-radius:8px;">

                    <small class="text-muted d-block mt-2">
                        Mã QR tự động cập nhật theo tổng tiền
                    </small>
                </div>
            </div>

            <div class="col-md-7">
                <div class="form-group">
                    <label class="control-label">Mẫu tin nhắn gửi Zalo/SMS:</label>

                    <textarea id="zalo-msg-template"
                              class="form-control"
                              rows="8"
                              readonly
                              style="font-size:.85rem;background:#fff;"></textarea>
                </div>

                <div class="d-flex justify-content-end" style="gap:10px;">
                    <button type="button" class="btn btn-outline-primary" onclick="copyZaloMsg()">
                        <i class="far fa-copy"></i> Copy Tin Nhắn
                    </button>

                    <button type="button"
                            class="btn btn-primary"
                            onclick="openZalo()"
                            style="background-color:#0068ff;border-color:#0068ff;">
                        <i class="fas fa-paper-plane"></i> Gửi qua Zalo
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="details_clone" style="display:none">
    <div class="tenant-details-box">
        <div class="d-flex justify-content-between">
            <span>
                <i class="fa fa-user"></i>
                <b class="tname"></b>
            </span>

            <span>
                Phòng:
                <b class="hno text-primary" style="font-size:1.2rem;"></b>
            </span>
        </div>

        <hr style="margin:5px 0;">

        <div class="d-flex justify-content-between align-items-center">
            <span>Giá thuê cứng:</span>
            <span class="price-display">
                <span class="price"></span> đ
            </span>
        </div>

        <input type="hidden" class="hidden_rent_price" value="0">
    </div>
</div>

<style>
    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .control-label {
        font-weight: 600;
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .form-control,
    .custom-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px;
        height: auto;
    }

    .input-group-text {
        background: #f8f9fa;
        border-radius: 8px 0 0 8px;
        font-weight: bold;
        color: #555;
        border: 1px solid #ddd;
    }

    .tenant-details-box {
        background: #e3f2fd;
        border: 1px dashed #1976d2;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .price-display {
        font-size: 1.1rem;
        font-weight: bold;
        color: #28a745;
    }

    .total-box {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 10px;
        padding: 15px;
    }
</style>

<script>
window.PAYMENT_BANK = {
    BANK_ID: "MB",
    ACCOUNT_NO: "123456789",
    ACCOUNT_NAME: "NGUYEN PHI HUNG"
};

$('.select2').select2({
    placeholder: "Chọn khách thuê",
    width: "100%",
    dropdownParent: $('#uni_modal')
});

function formatMoney(value){
    return new Intl.NumberFormat('vi-VN').format(value || 0);
}

function paymentCalculateTotal(){
    let rent = parseFloat($('.hidden_rent_price').val()) || 0;
    let electric = parseFloat($('#cost_electric').val()) || 0;
    let water = parseFloat($('#cost_water').val()) || 0;
    let total = rent + electric + water;

    $('#amount').val(total);

    let opt = $('#tenant_id option:selected');
    let roomNo = opt.data('house') ? 'Phòng ' + opt.data('house') : 'Phòng';
    let tenantName = opt.data('name') || 'Khách hàng';
    let invoiceCode = $('input[name="invoice"]').val() || '';
    let bank = window.PAYMENT_BANK;

    let addInfo = ("Thanh toan " + invoiceCode + " " + roomNo)
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/ /g, '%20');

    let qrUrl = `https://img.vietqr.io/image/${bank.BANK_ID}-${bank.ACCOUNT_NO}-compact2.png?amount=${total}&addInfo=${addInfo}&accountName=${bank.ACCOUNT_NAME.replace(/ /g, '%20')}`;

    $('#vietqr-img').attr('src', qrUrl);

    let zaloText = `🏡 QUẢN GIA 5.0 - THÔNG BÁO THU TIỀN\n`;
    zaloText += `Xin chào ${tenantName},\n`;
    zaloText += `BQL xin gửi hóa đơn chi phí ${roomNo} tháng này:\n`;
    zaloText += `Mã HĐ: HD-${invoiceCode}\n`;
    zaloText += `-------------------\n`;
    zaloText += `⚡ Tiền điện: ${formatMoney(electric)} đ\n`;
    zaloText += `💧 Tiền nước: ${formatMoney(water)} đ\n`;
    zaloText += `🏠 Tiền phòng: ${formatMoney(rent)} đ\n`;
    zaloText += `-------------------\n`;
    zaloText += `💰 TỔNG THANH TOÁN: ${formatMoney(total)} VNĐ\n\n`;
    zaloText += `💳 Thông tin chuyển khoản:\n`;
    zaloText += `Ngân hàng: ${bank.BANK_ID}\n`;
    zaloText += `STK: ${bank.ACCOUNT_NO}\n`;
    zaloText += `CTK: ${bank.ACCOUNT_NAME}\n`;
    zaloText += `ND: HD ${invoiceCode} ${roomNo}`;

    $('#zalo-msg-template').val(zaloText);
}

function paymentRandomCode(){
    let randomNum = Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000;
    $('input[name="invoice"]').val(randomNum);
    paymentCalculateTotal();
}

$(document).off('click.paymentRandom', '#btn-random-code')
.on('click.paymentRandom', '#btn-random-code', function(){
    paymentRandomCode();
});

$(document).off('input.paymentCalc change.paymentCalc keyup.paymentCalc', '#cost_electric, #cost_water, input[name="invoice"]')
.on('input.paymentCalc change.paymentCalc keyup.paymentCalc', '#cost_electric, #cost_water, input[name="invoice"]', function(){
    paymentCalculateTotal();
});

$(document).off('change.paymentTenant', '#tenant_id')
.on('change.paymentTenant', '#tenant_id', function(){
    let opt = $(this).find(':selected');

    if (!$(this).val()) {
        $('#details').html('');
        $('.hidden_rent_price').val(0);
        paymentCalculateTotal();
        return;
    }

    let details = $('#details_clone .tenant-details-box').clone();
    let price = parseFloat(opt.data('price')) || 0;
    let house = opt.data('house') || '';
    let name = opt.data('name') || '';

    details.find('.tname').text(name);
    details.find('.hno').text(house);
    details.find('.price').text(formatMoney(price));
    details.find('.hidden_rent_price').val(price);

    $('#details').html(details);
    paymentCalculateTotal();
});

window.copyZaloMsg = function(){
    let copyText = document.getElementById("zalo-msg-template");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert_toast("Đã copy tin nhắn! Hãy dán vào Zalo.", "success");
};

window.openZalo = function(){
    window.copyZaloMsg();
    window.open('https://chat.zalo.me', '_blank');
};

$('#manage-payment').off('submit').on('submit', function(e){
    e.preventDefault();

    start_load();

    $.ajax({
        url: "{{ route('admin.payments.save') }}",
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',

        success:function(resp){
            if(resp == 1){
                alert_toast("Lưu dữ liệu thành công", 'success');
                setTimeout(function(){
                    location.reload();
                },1000);
            } else if(resp == 2) {
                alert_toast("Lỗi: Số tiền không được nhỏ hơn 0!", 'warning');
                end_load();
            } else {
                alert_toast("Có lỗi xảy ra", 'danger');
                end_load();
            }
        },

        error:function(xhr){
            console.log(xhr.responseText);
            alert(xhr.responseText);
            end_load();
        }
    });
});

setTimeout(function(){
    $('#tenant_id').trigger('change');
    paymentCalculateTotal();
}, 300);
</script>