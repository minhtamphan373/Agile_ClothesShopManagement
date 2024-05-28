<?php
    // Nhập các lớp PHPMailer vào không gian tên toàn cục
    // Cần phải đặt ở đầu tập lệnh của bạn, không phải bên trong một hàm
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Tải trình tải tự động của Composer
    require 'vendor/autoload.php';

    include("class/index_class.php");
    //include("config/config.php");
    Session::init();
    $register = new index();

    
    
?>
<?php

    $emailErr = $passwordErr = "";
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){      
        $useremail = $_POST['email'];
        $password = $_POST['password'];

        /**---kiểm tra email */
        if(empty($useremail)){
            $emailErr = "Email là bắt buộc.";
        }
        else{
            if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Định dạng email không hợp lệ.";
            }
        }

        /**---kiểm tra mật khẩu */
        if(empty($password)){
            $passwordErr = "Mật khẩu là bắt buộc.";
        }

        /**---xác minh người dùng */
        $status = $register -> get_user_status($useremail); // Gọi hàm để lấy trạng thái của người dùng
        if ($status === 0) {
            // Tài khoản đã bị khóa
            $msg = "Tài khoản của bạn đã bị khóa.";
            $_SESSION['status'] = $status;
            header("Location: loginaccount.php");
        }
        if(empty($emailErr) && empty($passwordErr)) {
            $verify_result = $register->verifyr_user_register($useremail, $password);

            if($verify_result == true && $status == 1) {
                    // Xác thực người dùng thành công, chuyển hướng đến trang bảng điều khiển hoặc trang chủ
                    
                    $_SESSION['status'] = $status;
                    header("Location: index.php");
                    exit();
            } else {
                $msg = "Email hoặc mật khẩu không hợp lệ. Nếu vẫn không đăng nhập được, </br>
                có khả năng bạn đã bị khóa tài khoản. Liên hệ ngay với admin để mở lại";
            }
        }
    }
?>




<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/account.css">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://kit.fontawesome.com/54f0cb7e4a.js" crossorigin="anonymous"></script>
    <title>Ivy-Đăng nhập</title>
</head>

<body>
    <div class="login">
        <div class="login-form">
            <span style="color:red; font-family: 'Bona Nova', serif;">
                <?php                       
                        if(isset($msg)){echo $msg;}
                    ?>
            </span>
            <h1>Ivy - Đăng nhập</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="text" name="email" placeholder="Nhập Email của bạn">
                <span style="color:red; font-family: 'Bona Nova', serif; display: block;">
                    <?php                       
                        if(isset($emailErr)){echo $emailErr;}
                    ?>
                </span>
                <input type="password" name="password" placeholder="Nhập Mật khẩu của bạn">
                <span style="color:red; font-family: 'Bona Nova', serif;">
                    <?php                            
                        if(isset($passwordErr)){echo $passwordErr;}
                    ?>
                </span>
                <br>
                <button type="submit">Đăng nhập</button>
            </form>
            <br>
            <p>--------- Hoặc đăng nhập bằng ---------</p>
            <button><i class="fa-brands fa-google"></i> Google</button>
            <button><i class="fa-brands fa-facebook-f"></i> FaceBook</button>

            <br></br>
            <div class="social-icons">
                <p>Chưa có tài khoản! <a href="register.php">Đăng ký</a>.</p>
                <p>Quên mật khẩu <a href="forget_password.php">Quên mật khẩu</a>.</p>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(c) {
        $('.alert-close').on('click', function(c) {
            $('.main-mockup').fadeOut('slow', function(c) {
                $('.main-mockup').remove();
            });
        });
    });
    </script>
</body>

</html>
