<style>
    .container-fluid { font-family: 'Poppins', sans-serif; }
    .control-label { font-weight: 600; color: #555; margin-bottom: 5px; }
    .form-control, .custom-select { border-radius: 5px; }
</style>

<div class="container-fluid">
    <form id="manage-complaint">
        @csrf

        <input type="hidden" name="id" value="{{ $complaint->id ?? '' }}">

        <div id="msg"></div>

        <div class="form-group">
            <label class="control-label">Người báo cáo / Phòng</label>

            <select name="tenant_id" id="tenant_id" class="custom-select select2" required>
                <option value=""></option>

                @foreach($tenants as $tenant)
                    @php
                        $tenantName = trim(($tenant->lastname ?? '') . ', ' . ($tenant->firstname ?? '') . ' ' . ($tenant->middlename ?? ''));
                    @endphp

                    <option value="{{ $tenant->id }}"
                        {{ isset($complaint) && (int)$complaint->tenant_id === (int)$tenant->id ? 'selected' : '' }}>
                        Phòng {{ $tenant->house->house_no ?? 'N/A' }} - {{ ucwords($tenantName) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="control-label">Nội dung sự cố (Report)</label>
            <textarea name="report" cols="30" rows="3" class="form-control" required placeholder="Mô tả chi tiết sự cố...">{{ $complaint->report ?? '' }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Trạng thái</label>

                    <select name="status" class="custom-select">
                        <option value="0" {{ isset($complaint) && (int)$complaint->status === 0 ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="1" {{ isset($complaint) && (int)$complaint->status === 1 ? 'selected' : '' }}>Đang sửa chữa</option>
                        <option value="2" {{ isset($complaint) && (int)$complaint->status === 2 ? 'selected' : '' }}>Đã hoàn thành</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Chi phí (VNĐ)</label>
                    <input type="number" step="any" name="cost" class="form-control text-right" min="0" value="{{ $complaint->cost ?? 0 }}">
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$('.select2').select2({
    placeholder: "Chọn phòng / khách thuê",
    width: "100%",
    dropdownParent: $('#uni_modal')
});

$('#manage-complaint').off('submit').on('submit', function(e){
    e.preventDefault();

    start_load();
    $('#msg').html('');

    $.ajax({
        url: "{{ route('admin.complaints.save') }}",
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',

        success: function(resp){
            if(String(resp).trim() == '1'){
                alert_toast("Dữ liệu đã được lưu thành công", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1000);
            } else {
                alert_toast("Có lỗi xảy ra! Response: " + resp, 'danger');
                console.log(resp);
                end_load();
            }
        },

        error: function(xhr){
            $('#msg').html('<div class="alert alert-danger">'+xhr.responseText+'</div>');
            console.log(xhr.responseText);
            end_load();
        }
    });
});
</script>