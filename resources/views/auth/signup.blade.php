<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng ký | Quản Gia 5.0</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        :root { --primary: #1cc88a; }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 550px;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            backdrop-filter: blur(5px);
        }

        .brand-title {
            font-weight: 800;
            font-size: 2.2rem;
            color: #4e73df;
            margin-bottom: 10px;
        }

        .input-group-text {
            background: #fff;
            border: 1px solid #ddd;
            border-right: none;
            border-radius: 50px 0 0 50px;
            padding-left: 25px;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .form-control {
            background: #fff;
            border: 1px solid #ddd;
            border-left: none;
            border-radius: 0 50px 50px 0;
            height: 55px;
            font-size: 1.1rem;
            padding-left: 15px;
        }

        .form-control:focus {
            background: #fff;
            box-shadow: none;
            border-color: var(--primary);
        }

        .btn-auth {
            width: 100%;
            border-radius: 50px;
            padding: 15px;
            font-size: 1.3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            border: none;
            color: white;
            box-shadow: 0 10px 25px rgba(28, 200, 138, 0.4);
            transition: 0.3s;
            letter-spacing: 1px;
        }

        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(28, 200, 138, 0.5);
            color: white;
        }

        .switch-link {
            text-align: center;
            margin-top: 25px;
            font-size: 1.1rem;
        }

        .switch-link a {
            font-weight: 700;
            color: #4e73df;
            text-decoration: none;
        }
    </style>
</head>

<body>
<div class="auth-card">
    <div class="text-center mb-5">
        <i class="fa fa-user-plus fa-4x text-success mb-3"></i>
        <h3 class="brand-title">QUẢN GIA <span style="color: #f6c23e;">5.0</span></h3>
        <p class="text-muted" style="font-size: 1.1rem;">Tạo tài khoản mới miễn phí</p>
    </div>

    <form id="register-form" method="POST" action="{{ route('signup') }}">
        @csrf

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
            </div>
            <input type="text" name="name" class="form-control" placeholder="Họ và tên của bạn" required>
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
            </div>
            <input type="email" name="email" class="form-control" placeholder="Email sử dụng" required>
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-phone"></i></span>
            </div>
            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required>
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
            </div>
            <input type="text" name="address" class="form-control" placeholder="Địa chỉ liên hệ">
        </div>

        <div class="input-group mb-5">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu bảo mật" required>
        </div>

        <button type="submit" class="btn btn-auth">TẠO TÀI KHOẢN</button>
    </form>

    <div class="switch-link">
        Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-secondary font-weight-bold">
            <i class="fa fa-arrow-left mr-1"></i> Về trang chủ
        </a>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#register-form').submit(function(e){
        e.preventDefault();

        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originText = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-2"></i> Đang xử lý...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(resp){
                console.log(resp);

                if(resp == 1 || resp === '1'){
                    alert("🎉 Đăng ký thành công! Vui lòng đăng nhập.");
                    window.location.href = "{{ route('login') }}";
                } else if(resp == 2 || resp === '2') {
                    alert("⚠️ Email này đã được sử dụng!");
                    btn.prop('disabled', false).html(originText);
                } else {
                    alert("Có lỗi xảy ra: " + resp);
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
</script>
</body>
</html>