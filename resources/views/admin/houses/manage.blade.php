<div class="container-fluid">
    <form id="manage-house" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" value="{{ $house->id ?? '' }}">
        <div id="msg"></div>

        <div class="form-group">
            <label>Số nhà / Số phòng</label>
            <input type="text" class="form-control" name="house_no" required value="{{ $house->house_no ?? '' }}">
        </div>

        <div class="form-group">
            <label>Vị trí / Địa chỉ cụ thể</label>
            <textarea name="location" class="form-control" rows="2" required>{{ $house->location ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label>Link Google Maps</label>
            <input type="text" class="form-control" name="map_link" value="{{ $house->map_link ?? '' }}">
            <small class="form-text text-muted">
                <i>Cách lấy: Vào Google Maps > Tìm địa điểm > Chia sẻ > Sao chép liên kết > Dán vào đây.</i>
            </small>
        </div>

        <div class="form-group">
            <label>Loại phòng</label>
            <select name="category_id" class="custom-select" required>
                <option value="" disabled selected>-- Chọn loại --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ isset($house) && $house->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Mô tả chi tiết</label>
            <textarea name="description" rows="3" class="form-control" required>{{ $house->description ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label>Giá thuê (VNĐ)</label>
            <input type="number" class="form-control text-right" name="price" min="0" step="any" required value="{{ $house->price ?? '' }}">
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 border-right">
                <div class="form-group">
                    <label><b>Ảnh đại diện (Ảnh bìa)</b></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="customFile">Chọn 1 ảnh...</label>
                    </div>
                </div>

                <div class="form-group text-center">
                    @php
                        $cover = isset($house) && !empty($house->img_path)
                            ? asset('assets/uploads/'.$house->img_path)
                            : asset('assets/uploads/no-image.jpg');
                    @endphp
                    <img src="{{ $cover }}" id="cimg" class="img-fluid img-thumbnail" style="max-height:200px;width:100%;object-fit:cover;">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><b>Bộ sưu tập ảnh chi tiết</b></label>

                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFileMulti" name="images[]" multiple onchange="displayMultiImg(this)">
                        <label class="custom-file-label" for="customFileMulti">Chọn nhiều ảnh...</label>
                    </div>

                    <div id="multi-preview" class="row mt-2" style="max-height:200px;overflow-y:auto;"></div>

                    <small class="form-text text-muted mt-2">
                        <i class="fa fa-info-circle"></i> Giữ phím <b>Ctrl</b> để chọn nhiều ảnh cùng lúc.
                    </small>
                </div>

                @if(isset($house))
                    <label>Ảnh đã tải lên:</label>
                    <div class="row mt-2" style="max-height:200px;overflow-y:auto;background:#f8f9fa;padding:10px;">
                    @forelse($house->images as $img)

                        <div class="col-4 mb-2 text-center img-item"
                            id="img-{{ $img->id }}">

                            <div style="position:relative;">

                                <button type="button"
                                        class="btn btn-danger btn-sm delete-img"
                                        data-id="{{ $img->id }}"
                                        style="
                                            position:absolute;
                                            top:-8px;
                                            right:-8px;
                                            z-index:10;
                                            width:24px;
                                            height:24px;
                                            border-radius:50%;
                                            padding:0;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                            font-size:12px;
                                            box-shadow:0 2px 6px rgba(0,0,0,.25);
                                        ">
                                    <i class="fa fa-times"></i>
                                </button>

                                <img src="{{ asset('assets/uploads/'.$img->img_path) }}"
                                    class="img-thumbnail"
                                    style="
                                        width:100%;
                                        height:70px;
                                        object-fit:cover;
                                        border-radius:8px;
                                    ">
                            </div>

                        </div>

                    @empty
                            <div class="col-12 text-muted small text-center">Chưa có ảnh chi tiết nào.</div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
function displayMultiImg(input) {
    var container = document.getElementById('multi-preview');
    container.innerHTML = '';

    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(function(file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var div = document.createElement('div');
                div.className = 'col-4 mb-2 text-center';

                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100%';
                img.style.height = '70px';
                img.style.objectFit = 'cover';

                div.appendChild(img);
                container.appendChild(div);
            }

            reader.readAsDataURL(file);
        });
    }
}

function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".custom-file-input").on("change", function() {
    if($(this).attr('name') == 'images[]'){
        var files = $(this)[0].files;

        if(files.length > 1){
            $(this).siblings(".custom-file-label").addClass("selected").html(files.length + " ảnh đã chọn");
        } else if(files.length == 1) {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        }
    } else {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    }
});

$('#manage-house').submit(function(e){
    e.preventDefault();

    start_load();
    $('#msg').html('');

    $.ajax({
        url: "{{ route('admin.houses.save') }}",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',

        success:function(resp){
            if(resp == 1){
                alert_toast("Lưu dữ liệu thành công",'success');

                setTimeout(function(){
                    location.reload();
                },1000);
            } else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Số phòng này đã tồn tại trong hệ thống.</div>');
                end_load();
            } else if(resp == 3){
                $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Giá thuê phòng không được nhỏ hơn 0.</div>');
                end_load();
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            } else {
                $('#msg').html('<div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại.</div>');
                end_load();
            }
        }
    });
});

$(document).on('click', '.delete-img', function(){

    if(!confirm('Xóa ảnh này?')){
        return;
    }

    let id = $(this).attr('data-id');

    $.ajax({

        url: "{{ url('/admin/houses/delete-image') }}/" + id,

        method: "POST",

        data: {
            _token: "{{ csrf_token() }}"
        },

        success:function(resp){

            if(resp == 1){

                $('#img-'+id).fadeOut(300,function(){
                    $(this).remove();
                });

                alert_toast("Đã xóa ảnh",'success');

            } else {

                alert_toast("Xóa thất bại",'danger');

            }
        }
    });

});
</script>