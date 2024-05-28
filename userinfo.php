<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn:last-child {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông tin người dùng</h1>
        <?php
        session_start();
        if (!isset($_SESSION['user_ten'])) {
            header("Location: loginaccount.php");
            exit;
        }

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

        // Lấy thông tin từ bảng tbl_user
        $username = $_SESSION['user_ten']; // Giả sử tên người dùng được lưu trong session
        $sql_user = "SELECT * FROM tbl_user WHERE user_ten='$username'";
        $result_user = $conn->query($sql_user);

        if ($result_user && $result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();

            // Lấy thông tin email từ bảng tbl_user
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
        <a href="update_info.php" class="btn">Cập nhật thông tin</a>
        <a href="changepassword.php" class="btn">Đổi mật khẩu</a>
        <a href="logout.php" class="btn">Đăng xuất</a>
        <a href="index.php" class="btn">Quay lại</a>
    </div>
</body>
</html>
