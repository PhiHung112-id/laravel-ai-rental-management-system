<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ session('system.name', 'Admin Dashboard') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    @stack('styles')

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        html {
            scroll-behavior: smooth;
        }

        main#view-panel {
            padding: 20px;
            margin-top: 60px;
            min-height: calc(100vh - 60px);
            transition: all 0.3s;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .modal-header {
            background: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-dialog.large {
            width: 80% !important;
            max-width: unset;
        }

        .modal-dialog.mid-large {
            width: 50% !important;
            max-width: unset;
        }

        #viewer_modal .btn-close {
            position: absolute;
            z-index: 999999;
            right: 15px;
            top: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: unset;
            font-size: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        #viewer_modal .btn-close:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        #viewer_modal .modal-dialog {
            width: 90%;
            max-width: unset;
            height: 90%;
            margin: auto;
        }

        #viewer_modal .modal-content {
            background: rgba(0, 0, 0, 0.9);
            border: unset;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #viewer_modal img,
        #viewer_modal video {
            max-height: 90%;
            max-width: 90%;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }

        #preloader,
        #preloader2 {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: #fff;
        }

        #preloader:before,
        #preloader2:before {
            content: "";
            position: fixed;
            top: calc(50% - 30px);
            left: calc(50% - 30px);
            border: 6px solid #f2f2f2;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: animate-preloader 1s linear infinite;
        }

        @keyframes animate-preloader {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== DATA TABLE GIỐNG PHP THUẦN ===== */

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            outline: none !important;
            border: 1px solid #d1d3e2 !important;
            border-radius: 8px !important;
            padding: 5px 10px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px !important;
        }

        /* ===== PAGINATION GỌN ===== */

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 2px !important;
        }

        /* ===== NÚT SỐ ===== */

        .dataTables_wrapper .dataTables_paginate .paginate_button {

            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;

            min-width: auto !important;
            height: 34px !important;

            padding: 0 8px !important;

            border: none !important;

            background: transparent !important;

            color: #444 !important;

            font-size: 15px !important;

            font-weight: 400 !important;

            line-height: 1 !important;

            box-shadow: none !important;

            transition: 0.15s;
        }

        /* ===== ACTIVE ===== */

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {

            min-width: 34px !important;

            border: 1px solid #bdbdbd !important;

            border-radius: 2px !important;

            background: linear-gradient(
                to bottom,
                #ffffff 0%,
                #dcdcdc 100%
            ) !important;

            color: #111 !important;
        }

        /* ===== HOVER ===== */

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {

            background: transparent !important;

            color: #111 !important;
        }

        /* ===== MŨI TÊN ===== */

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {

            font-size: 22px !important;

            color: #777 !important;

            padding: 0 4px !important;

            min-width: 24px !important;
        }

        /* ===== HOVER MŨI TÊN ===== */

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {

            color: #222 !important;
        }

        /* ===== DISABLED ===== */

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {

            opacity: 0.45 !important;
        }

        /* ===== DÒNG HIỂN THỊ ===== */

        .dataTables_wrapper .dataTables_info {

            padding-top: 12px !important;

            color: #444 !important;

            font-size: 15px !important;

            font-weight: 400 !important;
        }

        #view-panel {
            transition: opacity .15s ease;
        }
    </style>
</head>

<body class="fixed-nav sticky-footer" id="page-top">

<script>
    if (localStorage.getItem('admin-theme') === 'dark') {
        document.body.classList.add('dark-mode');
    }
</script>

@include('admin.partials.topbar')
@include('admin.partials.sidebar')

<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
    <div class="toast-body text-white"></div>
</div>

<main id="view-panel">
    @yield('content')
</main>

<div id="preloader"></div>

<div class="modal fade" id="confirm_modal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="delete_content"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirm">Tiếp tục</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uni_modal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit" onclick="$('#uni_modal form').submit()">Lưu lại</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewer_modal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal">
                <span class="fa fa-times"></span>
            </button>
            <img src="" alt="">
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
    window.start_load = function(){
        $('body').prepend('<div id="preloader2"></div>');
    }

    window.end_load = function(){
        $('#preloader2').fadeOut('fast', function() {
            $(this).remove();
        });
    }

    window.viewer_modal = function(src = ''){
        start_load();

        let ext = src.split('.').pop();
        let view = '';

        if(ext === 'mp4'){
            view = $("<video src='"+src+"' controls autoplay></video>");
        } else {
            view = $("<img src='"+src+"' />");
        }

        $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove();
        $('#viewer_modal .modal-content').append(view);

        $('#viewer_modal').modal({
            show:true,
            backdrop:'static',
            keyboard:false,
            focus:true
        });

        end_load();
    }

    window.uni_modal = function(title = '', url = '', size = ''){
        start_load();

        $.ajax({
            url: url,
                error:function(xhr){
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                    end_load();
                },
            success: function(resp){
                if(resp){
                    $('#uni_modal .modal-title').html(title);
                    $('#uni_modal .modal-body').html(resp);

                    if(size !== ''){
                        $('#uni_modal .modal-dialog').addClass(size);
                    } else {
                        $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md");
                    }

                    $('#uni_modal').modal({
                        show:true,
                        backdrop:'static',
                        keyboard:false,
                        focus:true
                    });

                    end_load();
                }
            }
        });
    }

    window._conf = function(msg = '', func = '', params = []){
        $('#confirm_modal #confirm').attr('onclick', func + "(" + params.join(',') + ")");
        $('#confirm_modal .modal-body').html(msg);
        $('#confirm_modal').modal('show');
    }

    window.alert_toast = function(msg = 'Thông báo', bg = 'success'){
        $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');

        if(bg === 'success') $('#alert_toast').addClass('bg-success');
        if(bg === 'danger') $('#alert_toast').addClass('bg-danger');
        if(bg === 'info') $('#alert_toast').addClass('bg-info');
        if(bg === 'warning') $('#alert_toast').addClass('bg-warning');

        let icon = '';
        if(bg === 'success') icon = '<i class="fa fa-check-circle"></i> ';
        if(bg === 'danger') icon = '<i class="fa fa-exclamation-triangle"></i> ';

        $('#alert_toast .toast-body').html(icon + msg);
        $('#alert_toast').toast({delay:3000}).toast('show');
    }

    $(document).ready(function(){
        $('#preloader').fadeOut('fast', function() {
            $(this).remove();
        });
    });

    $(document).on('click', '.ajax-link', function(e){
        e.preventDefault();

        let url = $(this).attr('href');

        $('.sidebar-list .nav-item').removeClass('active');
        $(this).addClass('active');

        $('#view-panel').css('opacity', '.45');

        $.ajax({
            url: url,
            method: 'GET',
            success: function(resp){
                let html = $('<div>').html(resp);
                let content = html.find('#view-panel').html();

                if(content){
                    $('#view-panel').html(content);
                    window.history.pushState({}, '', url);
                }else{
                    window.location.href = url;
                }

                $('#view-panel').css('opacity', '1');
            },
            error:function(){
                window.location.href = url;
            }
        });
    });

    window.onpopstate = function(){
        location.reload();
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('scripts')

</body>
</html>