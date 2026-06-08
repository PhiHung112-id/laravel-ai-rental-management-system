<div class="container-fluid">
    <form id="manage-notification">
        @csrf

        <input type="hidden" name="id" value="{{ $notification->id ?? '' }}">

        <div class="form-group">
            <label class="control-label">Tiêu đề thông báo</label>
            <input type="text"
                   class="form-control"
                   name="title"
                   value="{{ $notification->title ?? '' }}"
                   required>
        </div>

        <div class="form-group">
            <label class="control-label">Nội dung chi tiết</label>
            <textarea name="content"
                      cols="30"
                      rows="5"
                      class="form-control"
                      required>{{ $notification->content ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"
                       class="custom-control-input"
                       id="is_pinned"
                       name="is_pinned"
                       value="1"
                       {{ isset($notification) && $notification->is_pinned == 1 ? 'checked' : '' }}>

                <label class="custom-control-label font-weight-bold text-danger"
                       for="is_pinned">
                    Ghim lên đầu trang (Tin quan trọng)
                </label>
            </div>
        </div>
    </form>
</div>

<script>
$('#manage-notification').off('submit').on('submit', function(e){
    e.preventDefault();

    start_load();

    $.ajax({
        url: "{{ route('admin.notifications.save') }}",
        method: "POST",
        data: $(this).serialize(),

        success:function(resp){
            if(resp == 1){
                alert_toast("Lưu thông báo thành công", "success");

                setTimeout(function(){
                    location.reload();
                }, 1000);
            } else {
                alert_toast("Có lỗi xảy ra", "danger");
                end_load();
            }
        },

        error:function(xhr){
            alert(xhr.responseText);
            console.log(xhr.responseText);
            end_load();
        }
    });
});
</script>