<?php
session_start();
if(!isset($_SESSION['user_ten'])) {
    header("Location: loginaccount.php");
    exit;
}

// Kết nối đến cơ sở dữ liệu (thay đổi thông tin kết nối theo cấu hình của bạn)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website_ivy";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý dữ liệu được gửi từ form cập nhật thông tin
    $date_of_birth = $_POST["date_of_birth"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];

    // Lấy tên người dùng từ session
    $username = $_SESSION['user_ten'];

    // Lấy user_id của người dùng từ bảng tbl_user
    $sql_user_id = "SELECT user_id FROM tbl_user WHERE user_ten='$username'";
    $result_user_id = $conn->query($sql_user_id);

    if ($result_user_id && $result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $user_id_ref = $row_user_id["user_id"];

        // Kiểm tra xem user_id đã tồn tại trong bảng user_info hay chưa
        $sql_check_user_info = "SELECT * FROM user_info WHERE user_id_ref='$user_id_ref'";
        $result_check_user_info = $conn->query($sql_check_user_info);

        if ($result_check_user_info && $result_check_user_info->num_rows > 0) {
            // Nếu user_id đã tồn tại trong bảng user_info, thực hiện UPDATE
            $sql_update = "UPDATE user_info 
                           SET date_of_birth='$date_of_birth', age='$age', gender='$gender', address='$address' 
                           WHERE user_id_ref='$user_id_ref'";

            if ($conn->query($sql_update) === TRUE) {
                // Chuyển hướng về trang user_info.php
                header("Location: userinfo.php");
                exit;
            } else {
                echo "Lỗi: " . $sql_update . "<br>" . $conn->error;
            }
        } else {
            // Nếu user_id chưa tồn tại trong bảng user_info, thực hiện INSERT
            $sql_insert = "INSERT INTO user_info (user_id_ref, date_of_birth, age, gender, address) 
                           VALUES ('$user_id_ref', '$date_of_birth', '$age', '$gender', '$address')";

            if ($conn->query($sql_insert) === TRUE) {
                // Chuyển hướng về trang user_info.php
                header("Location: userinfo.php");
                exit;
            } else {
                echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Không tìm thấy thông tin người dùng.";
    }

    // Đóng kết nối cơ sở dữ liệu
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin</title>
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
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="date"],
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cập nhật thông tin</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="date_of_birth">Ngày tháng năm sinh:</label>
            <input type="date" id="date_of_birth" name="date_of_birth">

            <label for="age">SĐT:</label>
            <input type="text" id="age" name="age" pattern="0[0-9]{9,10}" title="SĐT phải bắt đầu bằng số 0 và có từ 10 đến 11 chữ số">

            <label for="gender">Giới tính:</label>
            <select id="gender" name="gender">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>

            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" rows="4" cols="50"></textarea>

            <input type="submit" value="Cập nhật">
        </form>
    </div>
</body>
</html>

