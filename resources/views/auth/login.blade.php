<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập | Quản Gia 5.0</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        /* GIỮ NGUYÊN TOÀN BỘ CSS LOGIN CŨ CỦA BRO Ở ĐÂY */
        :root { --primary: #3b82f6; --gold: #f4b619; }
        body { font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed; position: relative; }
        body::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 64, 175, 0.7) 100%); z-index: -1; }
        .auth-card { background: rgba(255, 255, 255, 0.98); width: 100%; max-width: 480px; padding: 50px 40px; border-radius: 30px; box-shadow: 0 25px 50px rgba(0,0,0,0.3); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .brand-title { font-weight: 800; font-size: 2.2rem; color: #1e293b; margin-bottom: 5px; letter-spacing: -0.5px; }
        .input-group-text { background: #f8fafc; border: 2px solid #e2e8f0; border-right: none; border-radius: 50px 0 0 50px; padding-left: 25px; color: var(--primary); font-size: 1.1rem; }
        .form-control { background: #f8fafc; border: 2px solid #e2e8f0; border-left: none; border-radius: 0 50px 50px 0; height: 55px; font-size: 1rem; font-weight: 500; color: #1e293b; padding-left: 10px; box-shadow: none !important; }
        .form-control:focus { background: #ffffff; border-color: var(--primary); }
        .form-control:focus + .input-group-prepend .input-group-text { background: #ffffff; border-color: var(--primary); }
        .form-control::placeholder { color: #94a3b8; font-weight: 400; }
        .btn-auth { width: 100%; border-radius: 50px; padding: 15px; font-size: 1.1rem; font-weight: 700; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; color: white; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3); transition: 0.3s; letter-spacing: 1px; }
        .btn-auth:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(59, 130, 246, 0.4); color: white; }
        .divider { display: flex; align-items: center; text-align: center; margin: 25px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #e2e8f0; }
        .divider span { padding: 0 15px; color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
        .switch-link { text-align: center; margin-top: 25px; font-size: 0.95rem; color: #64748b; }
        .switch-link a { font-weight: 700; color: var(--primary); text-decoration: none; }
        .switch-link a:hover { text-decoration: underline; color: #1d4ed8; }
    </style>
    
</head>
<body>
<div class="auth-card">
    <div class="text-center mb-4">
        <div class="d-inline-block bg-primary text-white rounded-circle p-3 mb-3 shadow" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;">
            <i class="fa fa-laptop-house fa-2x"></i>
        </div>
        <h3 class="brand-title">QUẢN GIA <span style="color: var(--gold);">5.0</span></h3>
        <p class="text-muted" style="font-size: 0.95rem;">Hệ thống lưu trú thông minh</p>
    </div>

    <form id="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
            <input type="email" name="email" class="form-control" placeholder="Nhập địa chỉ Email" required>
        </div>
        <div class="input-group mb-4">
            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
            <input type="password" name="password" class="form-control" placeholder="Nhập Mật khẩu" required>
        </div>
        <button type="submit" class="btn btn-auth">ĐĂNG NHẬP <i class="fa fa-arrow-right ml-2"></i></button>
    </form>

    <div class="divider"><span>Hoặc</span></div>

    <div class="d-flex justify-content-center w-100">
        <div id="g_id_onload" data-client_id="655389662758-r9o4f51ogkf25qceq4o19albf72crlpa.apps.googleusercontent.com" data-context="signin" data-ux_mode="popup" data-callback="handleGoogleLogin" data-auto_prompt="false"></div>
        <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="outline" data-text="signin_with" data-size="large" data-logo_alignment="left" data-width="400"></div>
    </div>

    <div class="switch-link">Chưa có tài khoản? <a href="{{ url('signup') }}">Tạo mới ngay</a></div>
    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="text-secondary font-weight-bold" style="font-size: 0.9rem; text-decoration: none;">
            <i class="fa fa-arrow-left mr-1"></i> Quay lại trang chủ
        </a>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#login-form').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originText = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-2"></i> Đang xác thực...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(resp){
                console.log(resp);

                if(resp == 1 || resp === '1') {
                    window.location.href = "{{ route('home') }}";
                } else {
                    alert("⚠️ Email hoặc mật khẩu không chính xác!");
                    btn.prop('disabled', false).html(originText);
                }
            },
            error: function(xhr){
                console.log(xhr.responseText);
                alert("Lỗi server: " + xhr.status);
                btn.prop('disabled', false).html(originText);
            }
        });
    });

    function handleGoogleLogin(response){

        $.ajax({
            url: "{{ url('/login/google') }}",
            method: "POST",
            data: {
                credential: response.credential,
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success:function(resp){

                if(resp == 1 || resp.success){

                    window.location.href = "{{ route('home') }}";

                }else{

                    alert('Đăng nhập Google thất bại');

                }
            },

            error:function(xhr){

                console.log(xhr.responseText);

                alert('Lỗi Google Login');

            }
        });

    }
</script>
</body>
</html>