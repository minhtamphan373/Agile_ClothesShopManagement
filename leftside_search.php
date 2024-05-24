<?php
$loaisanpham_id = null; // Đảm bảo rằng biến $loaisanpham_id đã được định nghĩa

if (isset($_GET['loaisanpham_id']) && $_GET['loaisanpham_id'] != NULL) {
    $loaisanpham_id = $_GET['loaisanpham_id'];
}
?>

<!-- -----------------------CARTEGPRY---------------------------------------------- -->
<section class="cartegory">
    <div class="container">
        <div class="cartegory-top row">
            <?php  
             $get_loaisanphamA = $index->get_loaisanphamA($loaisanpham_id);
            if($get_loaisanphamA) {
                $resultA = $get_loaisanphamA->fetch_assoc();
            } 
            ?>
            <p><a style="color:#000000;" href="index.php">Trang chủ</a></p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="cartegory-left">
                <ul>
                <?php
                    $show_danhmuc = $index->show_danhmuc();
                    if($show_danhmuc) {
                        while($resultB = $show_danhmuc->fetch_assoc()) {
                ?>
                    <li class="cartegory-left-li"><a href="#"><?php echo $resultB['danhmuc_ten'] ?></a>
                        <ul>
                        <?php
                            $danhmuc_id = $resultB['danhmuc_id'];
                            $show_loaisanpham = $index->show_loaisanpham($danhmuc_id);
                            if($show_loaisanpham) {
                                while($resultC = $show_loaisanpham->fetch_assoc()) {
                        ?>
                            <li><a href="cartegory.php?loaisanpham_id=<?php echo $resultC['loaisanpham_id'] ?>"><?php echo $resultC['loaisanpham_ten'] ?></a></li>
                        <?php
                                }
                            }
                        ?>
                        </ul>
                    </li>    
                <?php
                        }
                    }
                ?>                  
                </ul>
            </div>
