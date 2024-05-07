<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Kiểm tra nếu tồn tại dữ liệu POST từ form quên mật khẩu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy địa chỉ email từ form
    $email = $_POST['email'];

    // Tạo mã số xác nhận ngẫu nhiên
    $verification_code = rand(100000, 999999); // Mã số 6 chữ số

    // Lưu mã số xác nhận vào session hoặc cơ sở dữ liệu để xác minh sau
    session_start();
    $_SESSION['verification_code'] = $verification_code;
    $_SESSION['email'] = $email;

    // Tạo một thư mới để gửi mã xác nhận
    $mail = new PHPMailer();
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'motivatorsthe303@gmail.com'; // Địa chỉ email của bạn
    $mail->Password = 'eplhzfowrrwnvbhb'; // Mật khẩu email của bạn
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('motivatorsthe303@gmail.com', 'Your Name');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Authentication ID changes password';
    $mail->Body = 'Mã xác nhận của bạn là: ' . $verification_code;

    if (!$mail->send()) {
        // Gửi email không thành công
        echo 'Lỗi khi gửi email: ' . $mail->ErrorInfo;
    } else {
        // Chuyển hướng người dùng đến trang nhập mã xác nhận
        header("Location: enter_verification_code.php");
    }
}
?>
