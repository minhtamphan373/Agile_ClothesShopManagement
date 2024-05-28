
<?php
session_start();
// Kiểm tra xem dữ liệu POST từ form đổi mật khẩu đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy mật khẩu mới từ form
    $new_password = $_POST['new_password'];

    // Lấy địa chỉ email từ session
    
    $email = $_SESSION['email'];

    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "website_ivy";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // Tạo truy vấn SQL để cập nhật mật khẩu mới trong cơ sở dữ liệu
    $sql = "UPDATE tbl_user SET user_password='$new_password' WHERE user_email='$email'";

    // Thực hiện truy vấn và kiểm tra kết quả
    if ($conn->query($sql) === TRUE) {
        // Mật khẩu đã được cập nhật thành công
        echo "Mật khẩu đã được cập nhật thành công.";
    } else {
        // Lỗi khi cập nhật mật khẩu
        echo "Lỗi khi cập nhật mật khẩu: " . $conn->error;
    }

    // Đóng kết nối cơ sở dữ liệu
    $conn->close();

    // Xóa các session đã lưu để không cho phép đặt lại mật khẩu một lần nữa
    unset($_SESSION['verification_code']);
    unset($_SESSION['email']);
    header("Location: loginaccount.php");
}
?>
