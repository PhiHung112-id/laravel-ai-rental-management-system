<style>
    .container-fluid{
        font-family:'Poppins',sans-serif;
    }

    .user-form-card{
        background:#fff;
        border-radius:16px;
    }

    .form-section-title{
        font-size:1rem;
        font-weight:700;
        color:#4e73df;
        margin-bottom:18px;
        display:flex;
        align-items:center;
        gap:10px;
    }

    .control-label{
        font-weight:600;
        color:#555;
        margin-bottom:6px;
        font-size:.9rem;
    }

    .input-group{
        box-shadow:0 2px 8px rgba(0,0,0,.03);
        border-radius:12px;
    }

    .input-group-text{
        background:#f8f9fc;
        border:1px solid #dbe2ef;
        color:#4e73df;
        border-radius:12px 0 0 12px;
        min-width:48px;
        justify-content:center;
    }

    .form-control,
    .custom-select{
        border:1px solid #dbe2ef;
        border-left:none;
        border-radius:0 12px 12px 0;
        height:auto;
        padding:12px 15px;
        font-size:.95rem;
    }

    .form-control:focus,
    .custom-select:focus{
        box-shadow:none;
        border-color:#4e73df;
    }

    .custom-select.standalone{
        border-left:1px solid #dbe2ef;
        border-radius:12px;
    }

    .form-hint{
        font-size:.82rem;
        color:#6b7280;
        margin-top:6px;
    }

    .role-preview{
        background:#f8fafc;
        border:1px dashed #dbe2ef;
        border-radius:14px;
        padding:14px;
        margin-top:10px;
    }

    .role-badge{
        padding:6px 14px;
        border-radius:30px;
        font-size:.82rem;
        font-weight:700;
        display:inline-block;
    }

    .badge-admin{
        background:#e3f2fd;
        color:#1565c0;
    }

    .badge-staff{
        background:#e8f5e9;
        color:#2e7d32;
    }

    .badge-user{
        background:#fff3e0;
        color:#ef6c00;
    }

    .alert{
        border-radius:12px;
    }
</style>

<div class="container-fluid py-2">

    <div class="user-form-card">

        <div id="msg"></div>

        <form id="manage-user">

            @csrf

            <input type="hidden"
                   name="id"
                   value="{{ $user->id ?? '' }}">

            <div class="form-section-title">
                <i class="fa fa-user-cog"></i>
                Thông tin tài khoản hệ thống
            </div>

            <div class="form-group">

                <label class="control-label">
                    Họ và tên người dùng
                </label>

                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <input type="text"
                           name="name"
                           class="form-control"
                           required
                           value="{{ $user->name ?? '' }}"
                           placeholder="Nhập họ và tên...">

                </div>

            </div>

            <div class="form-group">

                <label class="control-label">
                    Tên đăng nhập hệ thống
                </label>

                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-at"></i>
                        </span>
                    </div>

                    <input type="text"
                        name="username"
                        class="form-control"
                        required
                        autocomplete="off"
                        value="{{ $user->email ?? '' }}"
                        placeholder="Nhập username...">

                </div>

            </div>

            <div class="form-group">

                <label class="control-label">
                    Mật khẩu bảo mật
                </label>

                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <input type="password"
                           name="password"
                           class="form-control"
                           autocomplete="new-password"
                           placeholder="Nhập mật khẩu mới...">

                </div>

                @if(isset($user))
                    <div class="form-hint">
                        <i class="fa fa-info-circle mr-1"></i>
                        Để trống nếu không muốn thay đổi mật khẩu hiện tại.
                    </div>
                @endif

            </div>

            <div class="form-group">

                <label class="control-label">
                    Phân quyền tài khoản
                </label>

                <select name="type"
                        id="type"
                        class="custom-select standalone">

                    <option value="1"
                        {{ isset($user) && $user->type == 1 ? 'selected' : '' }}>
                        Quản trị viên (Admin)
                    </option>

                    <option value="2"
                        {{ isset($user) && $user->type == 2 ? 'selected' : '' }}>
                        Nhân viên (Staff)
                    </option>

                    <option value="3"
                        {{ isset($user) && $user->type == 3 ? 'selected' : '' }}>
                        Người dùng
                    </option>

                </select>

                <div class="role-preview">

                    <div class="mb-2 font-weight-bold text-secondary">
                        Quyền hiện tại:
                    </div>

                    <span id="role_badge_preview"
                          class="role-badge badge-admin">
                        Admin
                    </span>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

function updateRolePreview(){

    let role = $('#type').val();

    let badge = $('#role_badge_preview');

    badge.removeClass(
        'badge-admin badge-staff badge-user'
    );

    if(role == 1){

        badge.addClass('badge-admin');
        badge.text('Quản trị viên');

    }else if(role == 2){

        badge.addClass('badge-staff');
        badge.text('Nhân viên');

    }else{

        badge.addClass('badge-user');
        badge.text('Người dùng');

    }
}

updateRolePreview();

$('#type').change(function(){
    updateRolePreview();
});

$('#manage-user').off('submit').on('submit', function(e){

    e.preventDefault();

    start_load();

    $('#msg').html('');

    $.ajax({

        url:"{{ route('admin.users.save') }}",

        method:'POST',

        data:$(this).serialize(),

        success:function(resp){

            if(resp == 1){

                alert_toast(
                    "Lưu dữ liệu thành công",
                    'success'
                );

                setTimeout(function(){

                    location.reload();

                },1000);

            }else if(resp == 2){

                $('#msg').html(`
                    <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-circle mr-1"></i>
                        Username đã tồn tại trong hệ thống
                    </div>
                `);

                end_load();

            }else{

                $('#msg').html(`
                    <div class="alert alert-danger text-center">
                        Có lỗi hệ thống xảy ra
                    </div>
                `);

                console.log(resp);

                end_load();
            }
        },

        error:function(xhr){

            console.log(xhr.responseText);

            $('#msg').html(`
                <div class="alert alert-danger text-center">
                    ${xhr.responseText}
                </div>
            `);

            end_load();
        }
    });

});

</script>