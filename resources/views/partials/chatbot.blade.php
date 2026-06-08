<style>
    .floating-contact-stack {
        position: fixed; bottom: 30px; right: 30px;
        display: flex; flex-direction: column; gap: 12px; z-index: 99999;
    }

    .contact-btn-item {
        width: 55px; height: 55px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white !important; font-size: 22px; cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        text-decoration: none !important; position: relative;
    }

    .contact-btn-item:hover {
        transform: scale(1.1) translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    }

    .btn-msg-purple { background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%); }
    .btn-zalo-blue { background-color: #0068ff; font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 13px; }
    .btn-phone-green { background: linear-gradient(135deg, #22c55e 0%, #15803d 100%); }
    .btn-community-orange { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }
    .btn-ai-robot { background: linear-gradient(135deg, #4e73df 0%, #1d4ed8 100%); }

    .btn-phone-green::after {
        content: ''; position: absolute; width: 100%; height: 100%;
        border: 2px solid #22c55e; border-radius: 50%;
        animation: phonePulse 1.8s infinite; z-index: -1; opacity: 0;
    }

    @keyframes phonePulse {
        0% { transform: scale(1); opacity: 0.6; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    .contact-btn-item::before {
        content: attr(data-tooltip);
        position: absolute; right: 70px; top: 50%;
        transform: translateY(-50%) translateX(10px);
        background: rgba(15, 23, 42, 0.9);
        color: #fff; padding: 6px 14px;
        font-size: 0.8rem; font-weight: 600;
        border-radius: 8px; white-space: nowrap;
        opacity: 0; pointer-events: none;
        transition: all 0.25s ease;
    }

    .contact-btn-item:hover::before {
        opacity: 1;
        transform: translateY(-50%) translateX(0);
    }

    .chat-premium-window {
        position: fixed; bottom: 100px; right: 100px;
        width: 380px; height: 520px; background: #fff;
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(15, 23, 42, 0.15);
        display: flex; flex-direction: column; overflow: hidden;
        z-index: 99998;
        transform: scale(0); transform-origin: bottom right;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        opacity: 0; pointer-events: none;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .chat-premium-window.show {
        transform: scale(1);
        opacity: 1;
        pointer-events: auto;
    }

    .chat-p-header {
        color: white; padding: 18px 20px;
        display: flex; align-items: center; justify-content: space-between;
    }

    .bg-header-ai { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .bg-header-comm { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }

    .chat-p-header h5 {
        margin: 0; font-size: 1.05rem; font-weight: 700;
    }

    .chat-p-body {
        flex: 1; padding: 20px; overflow-y: auto;
        background: #f8fafc; display: flex;
        flex-direction: column; gap: 12px;
    }

    .chat-suggestions {
        display: flex; gap: 8px; padding: 10px 15px 12px;
        background: #fff; border-top: 1px solid #f1f5f9;
        overflow-x: auto; flex-wrap: nowrap;
    }

    .btn-suggest {
        flex-shrink: 0; white-space: nowrap;
        background: #eff6ff; color: #4e73df;
        border: 1px solid #c3dafe;
        border-radius: 20px; padding: 6px 14px;
        font-size: 0.8rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s;
    }

    .btn-suggest:hover {
        background: #4e73df; color: white;
        transform: translateY(-2px);
    }

    .chat-bubble {
        padding: 11px 16px;
        border-radius: 16px;
        font-size: 0.88rem;
        line-height: 1.45;
        font-weight: 500;
        position: relative;
        max-width: 85%;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .bubble-bot {
        background: #fff; color: #334155;
        border: 1px solid #e2e8f0;
        align-self: flex-start;
        border-bottom-left-radius: 0;
    }

    .bubble-user {
        background: #4e73df; color: white;
        align-self: flex-end;
        border-bottom-right-radius: 0;
        box-shadow: 0 3px 10px rgba(78, 115, 223, 0.2);
    }

    .cc-msg {
        display: flex;
        flex-direction: column;
        max-width: 85%;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .cc-msg.me {
        align-self: flex-end;
        align-items: flex-end;
    }

    .cc-msg.other {
        align-self: flex-start;
    }

    .cc-info {
        font-size: 12px;
        color: #555;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .role-badge {
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 800;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin { background: #e74a3b; }
    .role-resident { background: #1cc88a; }

    .cc-bubble {
        padding: 10px 14px;
        position: relative;
        word-wrap: break-word;
        line-height: 1.4;
    }

    .cc-msg.me .cc-bubble {
        background: #f97316;
        color: white;
        border-radius: 18px 18px 4px 18px;
    }

    .cc-msg.other .cc-bubble {
        background: #e9ecef;
        color: #333;
        border-radius: 18px 18px 18px 4px;
    }

    .cc-msg.admin.other .cc-bubble {
        background: #ffebee;
        color: #c62828;
        border-left: 4px solid #e74a3b;
        font-weight: 500;
        border-radius: 4px 18px 18px 4px;
        box-shadow: 0 2px 8px rgba(231, 74, 59, 0.15);
    }

    .cc-time {
        font-size: 10px;
        color: rgba(0,0,0,0.65);
        text-align: right;
        margin-top: 4px;
        display: block;
        white-space: nowrap;
    }

    .cc-msg.me .cc-time {
        color: rgba(255,255,255,0.9);
    }

    .cc-edited {
        font-size: 10px;
        opacity: .7;
        margin-top: 3px;
        font-style: italic;
    }

    .cc-actions {
        margin-top: 3px;
    }

    .btn-edit-msg {
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 11px;
        cursor: pointer;
        padding: 0;
    }

    .btn-edit-msg:hover {
        color: #f97316;
    }

    .chat-p-footer {
        padding: 15px; background: #fff;
        border-top: 1px solid #f1f5f9;
        display: flex; gap: 10px; align-items: center;
    }

    .chat-p-input {
        flex: 1; border: 1px solid #cbd5e1;
        border-radius: 50px; padding: 10px 18px;
        outline: none; font-size: 0.88rem;
        color: #334155; background: #f8fafc;
    }

    .chat-p-send {
        border: none; width: 42px; height: 42px;
        border-radius: 50%; display: flex;
        align-items: center; justify-content: center;
        cursor: pointer; transition: 0.2s;
        flex-shrink: 0; color: white;
    }

    .bg-send-ai { background: #4e73df; }
    .bg-send-comm { background: #f97316; }

    .chat-login-lock {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        text-align: center; height: 100%;
        padding: 30px; color: #64748b;
    }
</style>

@php
    $currentCustomerId = session('login_customer_id', 0);
@endphp

<div class="floating-contact-stack">
    <a href="#" class="contact-btn-item btn-msg-purple" data-tooltip="Gửi tin nhắn Fanpage">
        <i class="fab fa-facebook-messenger"></i>
    </a>

    <a href="https://zalo.me/0988888888" target="_blank" class="contact-btn-item btn-zalo-blue" data-tooltip="Hỗ trợ qua Zalo">
        Zalo
    </a>

    <a href="tel:19001560" class="contact-btn-item btn-phone-green" data-tooltip="Hotline: 1900 1560">
        <i class="fa fa-phone-alt"></i>
    </a>

    <div class="contact-btn-item btn-community-orange" id="commChatToggle" data-tooltip="Sảnh Cư Dân 5.0">
        <i class="fa fa-comments"></i>
    </div>

    <div class="contact-btn-item btn-ai-robot" id="aiChatToggle" data-tooltip="Trợ lý Trực Tuyến AI">
        <i class="fa fa-robot"></i>
    </div>
</div>

<div class="chat-premium-window" id="aiChatWindow">
    <div class="chat-p-header bg-header-ai">
        <h5><i class="fa fa-robot mr-2"></i> Trợ lý Quản Gia 5.0</h5>
        <i class="fa fa-times" id="aiChatClose" style="cursor: pointer;"></i>
    </div>

    <div class="chat-p-body" id="aiChatBody">
        <div class="chat-bubble bubble-bot shadow-sm">
            Xin chào! Mình là AI của hệ thống. Bạn cần tư vấn về phòng trống, giá thuê hay thủ tục mua trả góp căn hộ nào?
        </div>
    </div>

    <div class="chat-suggestions">
        <button class="btn-suggest">Bên mình còn phòng trống không?</button>
        <button class="btn-suggest">Giá thuê phòng rẻ nhất?</button>
        <button class="btn-suggest">Liên hệ Ban Quản Lý</button>
    </div>

    <div class="chat-p-footer">
        <input type="text" class="chat-p-input" id="aiChatInput" placeholder="Nhập câu hỏi của bạn..." autocomplete="off">
        <button class="chat-p-send bg-send-ai shadow-sm" id="aiChatSend">
            <i class="fa fa-paper-plane"></i>
        </button>
    </div>
</div>

<div class="chat-premium-window chat-comm-window" id="commChatWindow">
    <div class="chat-p-header bg-header-comm">
        <h5><i class="fa fa-users mr-2"></i> Sảnh Cư Dân Tòa Nhà</h5>
        <i class="fa fa-times" id="commChatClose" style="cursor: pointer;"></i>
    </div>

    @if($currentCustomerId)
        <div class="chat-p-body" id="commChatBody"></div>

        <div class="chat-p-footer">
            <input type="text" class="chat-p-input" id="commChatInput" placeholder="Trò chuyện cùng sảnh cư dân..." autocomplete="off">
            <button class="chat-p-send bg-send-comm shadow-sm" id="commChatSend">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    @else
        <div class="chat-p-body">
            <div class="chat-login-lock">
                <i class="fa fa-lock fa-3x text-warning mb-3"></i>
                <h6 class="font-weight-bold text-dark">Không Gian Giao Lưu Cư Dân</h6>
                <p class="small">Vui lòng đăng nhập tài khoản thành viên hệ thống Quản Gia 5.0 để tham gia trò chuyện cùng cộng đồng!</p>
                <a href="{{ route('login') }}" class="btn btn-sm text-white mt-2 px-4 rounded-pill font-weight-bold" style="background:#ea580c">
                    Đăng nhập ngay
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    const currentCustomerId = {{ $currentCustomerId }};

    $('#aiChatToggle').click(function(){
        $('#commChatWindow').removeClass('show');
        $('#aiChatWindow').toggleClass('show');
    });

    $('#aiChatClose').click(function(){
        $('#aiChatWindow').removeClass('show');
    });

    $('#commChatToggle').click(function(){
        $('#aiChatWindow').removeClass('show');
        $('#commChatWindow').toggleClass('show');

        if($('#commChatWindow').hasClass('show')){
            loadCommunityMessages();
        }
    });

    $('#commChatClose').click(function(){
        $('#commChatWindow').removeClass('show');
    });

    function sendAiMessage() {
        var text = $('#aiChatInput').val().trim();
        if(!text) return;

        $('#aiChatBody').append('<div class="chat-bubble bubble-user shadow-sm">'+text+'</div>');
        $('#aiChatInput').val('');
        $('#aiChatBody').scrollTop($('#aiChatBody')[0].scrollHeight);

        var typingId = 'typing_' + Date.now();

        $('#aiChatBody').append('<div id="'+typingId+'" class="chat-bubble bubble-bot shadow-sm text-muted"><i>Trợ lý AI đang suy nghĩ...</i></div>');
        $('#aiChatBody').scrollTop($('#aiChatBody')[0].scrollHeight);

        $.ajax({
            url: "{{ route('chat.ai') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                message: text,
                user_type: 2
            },
            success: function(resp){
                $('#' + typingId).remove();
                $('#aiChatBody').append('<div class="chat-bubble bubble-bot shadow-sm">' + resp + '</div>');
                $('#aiChatBody').scrollTop($('#aiChatBody')[0].scrollHeight);
            },
            error: function(){
                $('#' + typingId).remove();
                $('#aiChatBody').append('<div class="chat-bubble bubble-bot shadow-sm text-danger">Xin lỗi, máy chủ AI đang bận. Vui lòng thử lại sau!</div>');
            }
        });
    }

    $('#aiChatSend').click(sendAiMessage);

    $('#aiChatInput').keypress(function(e){
        if(e.key === 'Enter') sendAiMessage();
    });

    $('.btn-suggest').click(function(){
        $('#aiChatInput').val($(this).text());
        sendAiMessage();
    });

    function loadCommunityMessages(){
        if(currentCustomerId == 0) return;

        $.ajax({
            url: "{{ route('chat.load') }}",
            method: 'GET',
            dataType: 'json',
            success: function(data){
                var html = '';

                if(data.length > 0){
                    $.each(data, function(k, v){
                        var isMe = (v.user_id == currentCustomerId && v.user_type == 2);
                        var isAdmin = (v.user_type == 1);

                        var align = isMe ? 'me' : 'other';
                        var roleClass = isAdmin ? 'admin' : 'resident';

                        var roleBadge = isAdmin
                            ? '<span class="role-badge role-admin"><i class="fa fa-bullhorn"></i> Ban Quản Lý</span>'
                            : '<span class="role-badge role-resident"><i class="fa fa-home"></i> Cư dân</span>';

                        var displayName = isMe ? 'Tôi' : v.sender_name;
                        var justify = isMe ? 'justify-content: flex-end;' : '';

                        html += '<div class="cc-msg '+align+' '+roleClass+'">';
                        html += '<div class="cc-info" style="'+justify+'">' + roleBadge + ' <b>' + displayName + '</b></div>';

                        html += '<div class="cc-bubble" title="'+(v.time || '')+'">';
                        html += v.message;

                        if(v.is_edited == 1){
                            html += '<div class="cc-edited">(đã chỉnh sửa)</div>';
                        }

                        html += '<span class="cc-time">'+(v.time || '')+'</span>';
                        html += '</div>';

                        if(isMe){
                            html += '<div class="cc-actions">';
                            html += '<button type="button" class="btn-edit-msg" data-id="'+v.id+'" data-message="'+String(v.message).replace(/"/g, '&quot;')+'">';
                            html += '<i class="fa fa-pen"></i> Sửa';
                            html += '</button>';
                            html += '</div>';
                        }

                        html += '</div>';
                    });
                } else {
                    html = '<div class="text-center text-muted mt-5"><small>Sảnh trò chuyện hiện tại trống trơn.</small></div>';
                }

                var body = $('#commChatBody');
                var scrollAtBottom = body.scrollTop() + body.innerHeight() >= body[0].scrollHeight - 50;

                body.html(html);

                if(scrollAtBottom || body.data('first-load') !== true){
                    body.scrollTop(body[0].scrollHeight);
                    body.data('first-load', true);
                }
            }
        });
    }

    function sendCommunityMessage() {
        var text = $('#commChatInput').val().trim();
        if(!text) return;

        $.ajax({
            url: "{{ route('chat.send') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                message: text,
                user_type: 2
            },
            success: function(resp){
                if(String(resp).trim() == '1'){
                    $('#commChatInput').val('');
                    loadCommunityMessages();
                } else {
                    alert('Không gửi được tin nhắn. Mã lỗi: ' + resp);
                }
            },
            error: function(xhr){
                console.log(xhr.responseText);
                alert('Lỗi server: ' + xhr.status);
            }
        });
    }

    if(currentCustomerId > 0) {
        $('#commChatSend').click(sendCommunityMessage);

        $('#commChatInput').keypress(function(e){
            if(e.key === 'Enter') sendCommunityMessage();
        });

        setInterval(loadCommunityMessages, 3000);
    }
        $(document).on('click', '.btn-edit-msg', function(){

        let id = $(this).data('id');
        let oldMsg = $(this).data('message');

        let newMsg = prompt("Sửa tin nhắn:", oldMsg);

        if(newMsg == null || newMsg.trim() == '') return;

        $.ajax({
            url: '/chat/edit/' + id,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                message: newMsg
            },
            success: function(resp){

                if(resp == '1'){
                    loadCommunityMessages();
                }
                else if(resp == 'expired'){
                    alert('Chỉ được sửa trong 5 phút');
                }
                else{
                    alert('Không thể sửa tin');
                }
            },
            error: function(xhr){
                console.log(xhr.responseText);
                alert('Lỗi server');
            }
        });
    });
</script>