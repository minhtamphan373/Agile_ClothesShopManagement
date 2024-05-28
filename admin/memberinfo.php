<?php
include "header.php";
include "leftside.php";

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

$user_id = $_GET['user_id'];
// Lấy thông tin từ bảng tbl_user

$sql_user = "SELECT * FROM tbl_user WHERE user_id='$user_id'";
$result_user = $conn->query($sql_user);

if ($result_user && $result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();

    // Lấy thông tin email từ bảng tbl_user
    $username = $row_user['user_ten'];
    $useremail = $row_user['user_email'];

    // Kiểm tra nếu thông tin từ bảng user_info có sẵn
    if ($row_user['user_id'] && isset($row_user['user_id'])) {
        $sql_info = "SELECT * FROM user_info WHERE user_id_ref=" . $row_user['user_id'];
        $result_info = $conn->query($sql_info);

        if ($result_info && $result_info->num_rows > 0) {
            $row_info = $result_info->fetch_assoc();
        } else {
            $row_info = false;
        }
    } else {
        $row_info = false;
    }
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

    <div class="admin-content-right">
        <h1>Thông tin người dùng</h1>
        <div class="table-content">                 
            <p><strong>Tên người dùng:</strong> <?php echo $username; ?></p>
            <p><strong>Email:</strong> <?php echo $useremail; ?></p>
            
            
            <?php if ($row_info) : ?>
                <p><strong>Ngày tháng năm sinh:</strong> <?php echo $row_info['date_of_birth']; ?></p>
                <p><strong>SĐT:</strong> <?php echo $row_info['age']; ?></p>
                <p><strong>Giới tính:</strong> <?php echo $row_info['gender']; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $row_info['address']; ?></p>                              
            <?php else: ?>
                <p>Thông tin chi tiết chưa được cập nhật.</p>
            <?php endif; ?>  

            <a href="memberlist.php">Quay lại</a>
        </div>      
    </div>
</body>
</html>
