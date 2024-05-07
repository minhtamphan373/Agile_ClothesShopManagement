<?php
session_start();

// Kiểm tra nếu tồn tại dữ liệu POST từ form nhập mã xác nhận
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy mã xác nhận từ form
    $verification_code_entered = $_POST['verification_code'];

    // Kiểm tra mã xác nhận nhập vào có trùng khớp với mã đã gửi hay không
    if ($_SESSION['verification_code'] == $verification_code_entered) {
        // Mã xác nhận hợp lệ, chuyển hướng người dùng đến trang đổi mật khẩu mới
        header("Location: reset_password.php");
    } else {
        // Mã xác nhận không hợp lệ, thông báo cho người dùng và yêu cầu nhập lại
        echo "Mã xác nhận không hợp lệ. Vui lòng thử lại.";
    }
}
?>
