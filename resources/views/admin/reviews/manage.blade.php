<div class="container-fluid">

    <form id="manage-review">

        @csrf

        <input type="hidden"
               name="id"
               value="{{ $review->id }}">

        <div class="form-group">

            <label class="control-label">
                Nội dung đánh giá khách hàng
            </label>

            <div class="alert alert-light border">

                "{{ $review->comment }}"

            </div>

        </div>

        <div class="form-group">

            <label class="control-label">
                Phản hồi của Ban Quản Lý
            </label>

            <textarea name="admin_reply"
                      rows="5"
                      class="form-control"
                      required>{{ $review->admin_reply }}</textarea>

        </div>

    </form>

</div>

<script>

$('#manage-review').submit(function(e){

    e.preventDefault();

    start_load();

    $.ajax({

        url:"{{ route('admin.reviews.save') }}",

        method:'POST',

        data:$(this).serialize(),

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Đã lưu phản hồi thành công",
                    'success'
                );

                setTimeout(function(){

                    location.reload();

                },1000);

            }else{

                alert_toast(
                    "Có lỗi xảy ra!",
                    'danger'
                );

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