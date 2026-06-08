<style>
    .utility-form-wrap {
        font-family: 'Poppins', sans-serif;
        color: #444;
    }

    .utility-box {
        background: #f8f9fc;
        border: 1px solid #eaecf4;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 16px;
    }

    .utility-title {
        font-weight: 700;
        color: #4e73df;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .control-label {
        font-weight: 600;
        color: #555;
        font-size: .9rem;
        margin-bottom: 6px;
    }

    .form-control,
    .custom-select {
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        padding: 10px 12px;
        height: auto;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px;
        background: #fff;
        border: 1px solid #d1d3e2;
        color: #4e73df;
        font-weight: 700;
    }

    .meter-card {
        border-radius: 14px;
        padding: 16px;
        background: #fff;
        border: 1px solid #edf0f7;
        box-shadow: 0 4px 14px rgba(0,0,0,.04);
    }

    .meter-electric {
        border-left: 5px solid #f6c23e;
    }

    .meter-water {
        border-left: 5px solid #36b9cc;
    }

    .hint-box {
        background: #fff8e1;
        border: 1px dashed #f6c23e;
        color: #7c5a00;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: .88rem;
    }
</style>

<div class="container-fluid utility-form-wrap py-2">
    <form id="manage-reading">
        @csrf

        <input type="hidden" name="id" value="{{ $reading->id ?? '' }}">

        <div class="utility-box">
            <div class="utility-title">
                <i class="fa fa-door-open"></i>
                Thông tin phòng & kỳ ghi chỉ số
            </div>

            <div class="form-group">
                <label class="control-label">Phòng cần ghi chỉ số</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-home"></i>
                        </span>
                    </div>

                    <select name="house_id" class="custom-select select2" required>
                        <option value="">Chọn phòng</option>

                        @foreach($houses as $house)
                            <option value="{{ $house->id }}"
                                {{ isset($reading) && $reading->house_id == $house->id ? 'selected' : '' }}>
                                Phòng {{ $house->house_no }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group mb-0">
                <label class="control-label">Ngày ghi chỉ số</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-calendar-alt"></i>
                        </span>
                    </div>

                    <input type="date"
                           name="reading_date"
                           class="form-control"
                           value="{{ isset($reading) ? date('Y-m-d', strtotime($reading->reading_date)) : date('Y-m-d') }}"
                           required>
                </div>
            </div>
        </div>

        <div class="utility-box">
            <div class="utility-title">
                <i class="fa fa-tachometer-alt"></i>
                Chỉ số tiêu thụ cuối kỳ
            </div>

            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="meter-card meter-electric">
                        <label class="control-label text-warning">
                            <i class="fa fa-bolt mr-1"></i>
                            Chỉ số điện
                        </label>

                        <div class="input-group">
                            <input type="number"
                                   name="electric"
                                   class="form-control text-right"
                                   min="0"
                                   value="{{ $reading->electric ?? 0 }}"
                                   required>

                            <div class="input-group-append">
                                <span class="input-group-text">kWh</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="meter-card meter-water">
                        <label class="control-label text-info">
                            <i class="fa fa-tint mr-1"></i>
                            Chỉ số nước
                        </label>

                        <div class="input-group">
                            <input type="number"
                                   name="water"
                                   class="form-control text-right"
                                   min="0"
                                   value="{{ $reading->water ?? 0 }}"
                                   required>

                            <div class="input-group-append">
                                <span class="input-group-text">m³</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hint-box">
            <i class="fa fa-info-circle mr-1"></i>
            Hệ thống sẽ lưu chỉ số điện nước theo phòng và kỳ ngày ghi. Dữ liệu này dùng để tính chi phí phát sinh khi lập hóa đơn.
        </div>
    </form>
</div>

<script>
$('.select2').select2({
    placeholder: "Chọn phòng cần ghi chỉ số",
    width: "100%",
    dropdownParent: $('#uni_modal')
});

$('#manage-reading').off('submit').on('submit', function(e){
    e.preventDefault();

    start_load();

    $.ajax({
        url: "{{ route('admin.utilities.save') }}",
        method: "POST",
        data: $(this).serialize(),

        success:function(resp){
            if(resp == 1){
                alert_toast("Lưu chỉ số điện nước thành công", "success");

                setTimeout(function(){
                    location.reload();
                }, 1000);
            } else {
                alert_toast("Có lỗi xảy ra", "danger");
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
</script>