$(document).ready(function() {
    // Kiểm tra bộ nhớ trình duyệt để gạt nút công tắc tương ứng
    if (localStorage.getItem('admin-theme') === 'dark') {
        $('#dark-mode-toggle, #checkbox').prop('checked', true);
    }

    // Lắng nghe hành động gạt nút thay đổi giao diện
    $('#dark-mode-toggle, #checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            $('body').addClass('dark-mode');
            localStorage.setItem('admin-theme', 'dark');
            if (typeof alert_toast === "function") alert_toast("Đã chuyển sang chế độ ban đêm", "info");
        } else {
            $('body').removeClass('dark-mode');
            localStorage.setItem('admin-theme', 'light');
            if (typeof alert_toast === "function") alert_toast("Đã tắt chế độ ban đêm", "muted");
        }
    });
});