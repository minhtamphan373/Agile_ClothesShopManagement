<?php
include "header.php";
include "leftside.php";

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $comment = new comment;
    $member = $comment->get_member($user_id);
    if($member){
        $result = $member->fetch_assoc();
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = $_POST['user_id'];
    $user_ten = $_POST['user_ten'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $status = $_POST['status'];
    $update_member = $comment->update_member($user_id, $user_ten, $user_password, $user_email, $status);
}

?>

<div class="admin-content-right">
            <div class="cartegory-add-content"> 
            <form form action="" method="POST" enctype="multipart/form-data">
            <label for="user_ten">Tên người dùng</label> <br> </br> 
            <input type="text" name="user_ten" value="<?php echo $result['user_ten']; ?>" required> <br> </br> 
            
            <label for="user_password">Mật khẩu</label> </br> </br> 
            <input type="text" name="user_password" value="<?php echo $result['user_password']; ?>" required> </br> </br> 
            
            <label for="user_email">Email</label> </br> </br> 
            <input type="email" name="user_email" value="<?php echo $result['user_email']; ?>" required> </br> </br> 
            
            <label for="status">Trạng thái</label> </br> </br> 
            <select name="status"> </br> </br> 
                <option value="1" <?php if($result['status'] == 1) echo 'selected'; ?>>Hoạt động</option>
                <option value="0" <?php if($result['status'] == 0) echo 'selected'; ?>>Không hoạt động</option>
            </select>
            </br> </br> 
            <input type="hidden" name="user_id" value="<?php echo $result['user_id']; ?>">
            <input type="submit" value="Cập nhật Thành viên">
        </form>
            </div>           
        </div>
    </section>
    <section>
    </section>
    <script src="js/script.js"></script>
</body>
</html>
