<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include("class/index_class.php");
    //include("config/config.php");
    Session::init();
    $register = new index();
?>
<?php
    $emailErr = $nameErr = $passwordErr = $cpasswordErr = "";
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){      
        $useremail = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];    

        /**---check email */
        if(empty($useremail)){
            $emailErr = "Email is required.";
        }else{
            if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format.";
            }
        }

        /**---check username */
        if(empty($username)){
            $nameErr = "Username is required.";
        }else{
            $check_register = $register ->check_register($username);
        }        
        /**---check password */
        if(empty($password)){
            $passwordErr = "Password is required.";
        }else{
            if(strlen($password)<6){
                $passwordErr = "Minimum of 6 character in lenght.";
            }
        }
        /**---check password and confirm password */
        if($password!=$cpassword){
            $cpasswordErr = "Password and Confirm Password do not match.";
        }

        /**---insert user */
        if(empty($emailErr) && empty($nameErr) && empty($passwordErr) && empty($cpasswordErr)) {
            $insert_result = $register->insert_user_register($useremail, $username, $password);

            if($insert_result == true) {

                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'motivatorsthe303@gmail.com';                     //SMTP username
                    $mail->Password   = 'eplhzfowrrwnvbhb';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('motivatorsthe303@gmail.com');
                    $mail->addAddress($useremail);     //Add a recipient                    

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'no reply';        
                    $mail->Body = "
                        Hello $username,<br>
                        Thank you for completing your registration at Clothes Shop.<br>
                        This email serves as a confirmation that your account is activated.<br>                
                        Regards,<br>
                        The Motivators team.
                        
                    ";                    

                    $mail->send();                    
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";               
                                
                $msg = "We've sent account activation confirmation to your email address.";
            } else {
                $msg = "Failed to register user.";               
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/account.css">
     <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">    

    <script src="https://kit.fontawesome.com/54f0cb7e4a.js" crossorigin="anonymous"></script>
    <title>Ivy-Register</title>
</head>
<body>
    <div class="login">
        <div class="login-form">         
            <span style="color:red; font-family: 'Bona Nova', serif;">
                    <?php                       
                        if(isset($msg)){echo $msg;}
                    ?>
            </span>                             
            <h1>Ivy - Register</h1>                      
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="text" name="email" placeholder="Enter Your Email" >
                <span style="color:red; font-family: 'Bona Nova', serif; display: block;">
                    <?php                       
                        if(isset($emailErr)){echo $emailErr;}
                    ?>
                </span>               
                <input type="text" name="username" placeholder="Enter Your Name">
                <span style="color:red; font-family: 'Bona Nova', serif; display: block;">
                    <?php
                        if(isset($check_register)){ echo $check_register;}
                        else if(isset($nameErr)){echo $nameErr;}                            
                    ?>
                </span>  
                <input type="password" name="password" placeholder="Enter Your Password">
                <span style="color:red; font-family: 'Bona Nova', serif; display: block;">
                    <?php                            
                        if(isset($passwordErr)){echo $passwordErr;}
                    ?>
                </span>                 
                <input type="password" name="cpassword" placeholder="Enter Your Confirm Password">
                <span style="color:red; font-family: 'Bona Nova', serif; display: block;">
                    <?php                            
                        if(isset($cpasswordErr)){echo $cpasswordErr;}
                    ?>
                </span> 
                <br>
                <button type="submit">Đăng Ký</button>                                
            </form>
            <br>
            <p>--------- Hoặc đăng ký bằng ---------</p>
            <button><i class="fa-brands fa-google"></i> Google</button>
            <button><i class="fa-brands fa-facebook-f"></i> FaceBook</button> 

            <br></br>
            <div class="social-icons">
                <p>Have an account! <a href="loginaccount.php">Login</a>.</p>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>
</body>
</html>
