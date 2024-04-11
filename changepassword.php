<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
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

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"], .back-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            display: block;
            transition: background-color 0.3s ease;
            text-decoration: none; /* Remove underline from link */
            text-align: center;
        }

        button[type="submit"]:hover, .back-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Đổi mật khẩu</h1>
        <form method="POST" action="">
            <label for="current_password">Mật khẩu hiện tại:</label>
            <input type="password" id="current_password" name="current_password" required><br>
            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" id="new_password" name="new_password" required><br>
            <label for="confirm_password">Nhập lại mật khẩu mới:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <button type="submit">Cập nhật mật khẩu</button> <br>
            <button onclick="window.location.href='userinfo.php'" class="back-btn">Quay Lại</button>
        </form>
        
        <?php
        // Xử lý khi nhấn nút cập nhật
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            // Lấy tên người dùng từ session
            $username = $_SESSION['user_ten'];

            // Lấy dữ liệu từ form
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Truy vấn để lấy mật khẩu từ cơ sở dữ liệu
            $sql_check_password = "SELECT user_password FROM tbl_user WHERE user_ten='$username'";
            $result = $conn->query($sql_check_password);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $dbPassword = $row['user_password'];
                if ($currentPassword == $dbPassword) {
                    // Mật khẩu hiện tại hợp lệ
                    if ($newPassword == $confirmPassword) {
                        // Mật khẩu mới và xác nhận mật khẩu mới khớp nhau
                        // Cập nhật mật khẩu mới trong cơ sở dữ liệu
                        $sql_update_password = "UPDATE tbl_user SET user_password='$newPassword' WHERE user_ten='$username'";
                        if ($conn->query($sql_update_password) === TRUE) {
                            echo "<p style='color: green;'>Mật khẩu đã được cập nhật thành công.</p>";
                        } else {
                            echo "<p class='error-message'>Lỗi khi cập nhật mật khẩu: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p class='error-message'>Mật khẩu mới và xác nhận mật khẩu mới không khớp nhau.</p>";
                    }
                } else {
                    echo "<p class='error-message'>Mật khẩu hiện tại không đúng.</p>";
                }
            } else {
                echo "<p class='error-message'>Không tìm thấy người dùng.</p>";
            }

            // Đóng kết nối cơ sở dữ liệu
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
