<?php
@ob_start();
session_start();
$session_id = session_id();

?>

<?php
if(isset($_GET['user_id'])){
    Session::destroyAdmin();
}
?>

<style>
    .user-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.user-button:focus {
    outline: none;
}

.user-button i {
    font-size: 24px;
}
.icon-link {
        color: inherit; /* Giữ màu icon không thay đổi */
        text-decoration: none; /* Xóa gạch chân mặc định của liên kết */
    }
    .search-form input[type="text"] {
    padding-right: 40px; /* Để chừa không gian cho nút tìm kiếm */
}

.search-form button {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    padding: 0 10px;
    background: none;
    border: none;
    cursor: pointer;
}

</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "class/index_class.php";
Session::init();
$index = new index;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/54f0cb7e4a.js" crossorigin="anonymous"></script>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="css/mainstyle.css">
    
    <title>Website - Ivy</title>
</head>
<body>
    
    <secsion class="top">
        <div class="container">
            <div class="row">
                <div class="menu-bar">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="top-logo">
                    <a href="index.php"><img src="image/logo.png" alt=""></a>
                </div>
                <div class="top-menu-items">
                    <ul>
                        <!-- CSM-51:[Customer]Category List - hiện thị danh mục sản phẩm -->
                        <?php
                        $show_danhmuc = $index ->show_danhmuc();
                        if($show_danhmuc){while($result = $show_danhmuc ->fetch_assoc()) {
                        ?> 
                        <li><?php echo $result['danhmuc_ten'] ?> 
                            <ul class="top-menu-item">
				<!-- Product Type List -->
                                    <?php
                                      $danhmuc_id = $result['danhmuc_id'];
                                      $show_loaisanpham = $index ->show_loaisanpham($danhmuc_id);
                                      if($show_loaisanpham){while($result = $show_loaisanpham ->fetch_assoc()) {
                                    ?>
                                    <li><a href="cartegory.php?loaisanpham_id=<?php echo $result['loaisanpham_id'] ?>"><?php echo $result['loaisanpham_ten'] ?></a></li>
                                    <?php
                                     }}
                                    ?>
                            </ul>
                            <i class="fas fa-chevron-down"></i>
                        </li>
                        <?php
                        } }
                        ?>
                    </ul>
                </div>
                <div class="top-menu-icons">
                    <ul>
                        <li>
                            <?php
                                
                                // Kiểm tra xem người dùng đã đăng nhập hay chưa
                                if(isset($_SESSION['user_ten']) ) {
                                    if(isset($_SESSION['status']) && $_SESSION['status'] == 1){
                                        echo '<p>Chào: <span style="color: blueviolet; font-size: 22px">' . $_SESSION['user_ten'] . '</span></p>';
                                    } else {
                                        echo '<p><></p>';
                                    }
                                } else {
                                    echo '<p><></p>';
                                }

                                
                            ?>
                        </li>
                        <li>
                            <form method="GET" action="search.php"> <!-- Tạo form và gửi dữ liệu tìm kiếm đến trang "search.php" -->
                                <div class="search-form">
                                <input type="text" name="keyword" placeholder="Tìm kiếm">
                                <button type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </li>
                        <li>
                            <!-- <button class="user-button">
                            <a href="trang_dang_nhap.php"><i class="fas fa-user-secret"></i></a>
                            </button> -->
                            <?php
                                // Kiểm tra xem người dùng đã đăng nhập hay chưa
                                if(isset($_SESSION['user_ten'])) {
                                    if(isset($_SESSION['status']) && $_SESSION['status'] == 1){
                                        // Nếu đã đăng nhập, hiển thị nút "Đăng xuất" và "Xem thông tin"
                                        echo '<a href="logout.php" class="icon-link"> <i class="fa-solid fa-right-from-bracket"></i> </a>';
                                        echo '<li><a href="userinfo.php" class="icon-link"> <i class="fa-solid fa-circle-info"></i> </a></li>';
                                    } else {
                                        // Nếu chưa đăng nhập, hiển thị nút đăng nhập hoặc thông báo khác
                                        echo '<a href="loginaccount.php" class="icon-link"><i class="fas fa-user-secret"></i></a>';
                                    }
                                }else{
                                    echo '<a href="loginaccount.php" class="icon-link"><i class="fas fa-user-secret"></i></a>';
                                }

                            ?>
                            
                            <!-- <a href="loginaccount.php" class="icon-link"><i class="fas fa-user-secret"></i></a> -->

                        </li>
                        <li>
                            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span><?php  if(Session::get('SL'))  {echo Session::get('SL'); } ?></span></a>
                            <div class="cart-content-mini">
                                <div class="cart-content-mini-top">
                                    <P>Giỏ hàng</P>
                                </div>
                                <?php 
                                $session_id = session_id();
                                $show_cartF = $index -> show_cartF($session_id);
                                if($show_cartF){while($result = $show_cartF->fetch_assoc()){
                                
                                 ?>
                                <div class="cart-content-mini-item">
                                    <img style="width:50px" src="<?php echo $result['sanpham_anh']  ?>" alt="">
                                    <div class="cart-content-item-text">
                                    <h1><?php echo $result['sanpham_tieude']  ?></h1> 
                                    <p>Màu: <img src="<?php echo $result['color_anh'] ?>" alt="" width="12" height="12"> </p>
                                    <p>Size: <?php echo $result['sanpham_size']  ?></p>
                                    <p>SL: <?php echo $result['quantitys']  ?></p>
                                    </div>
                                </div>
                                    <?php
                                    
                                        
                                            }}
                                ?>
                                
                                <div class="cart-content-mini-bottom">
                                    <p><a href="cart.php">...Xem chi tiết</a></p>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </secsion>
