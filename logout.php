<?php
session_start();
// Hủy bỏ tất cả các biến phiên
$_SESSION = array();

// Nếu muốn xóa cả phiên, hãy xóa cả cookie phiên.
// Lưu ý rằng điều này sẽ xóa cả phiên và đăng xuất tất cả các phiên khác của người dùng.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy phiên hiện tại
session_destroy();

// Chuyển hướng về trang chính hoặc bất kỳ trang nào bạn muốn
header("Location: index.php?logout=success");
exit();
?>

