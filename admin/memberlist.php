<?php
include "header.php";
include "leftside.php";
// include "class/cartegory_class.php";
// define('__ROOT__', dirname(dirname(__FILE__))); 
// require_once(__ROOT__.'../admin/class/comment_class.php');
$comment = new comment;
$show_member = $comment -> show_member()
?>
<div class="admin-content-right">
    <div class="table-content">
        <table>
            <tr>
                <th>Stt</th>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Status</th>
                <th>Tùy chỉnh</th>
            </tr>
            <?php
                    if($show_member){$i=0; while($result= $show_member->fetch_assoc()){
                        $i++
                   
                    ?>
            <tr>
                <td> <?php echo $i ?></td>
                <td> <?php echo $result['user_id'] ?></td>
                <td> <a
                        href="memberinfo.php?user_id=<?php echo $result['user_id'] ?>"><?php echo $result['user_ten']  ?></a>
                </td>
                <td> <?php echo $result['user_password']  ?></td>
                <td> <?php echo $result['user_email']  ?></td>
                <td>
                    <?php 
                    if($result['status'] == 1){
                        echo '<p><a href="memberstatus.php?user_id='.$result['user_id'].'&status=0"  
                        class="btn btn-success"
                        onclick="return confirm(\'Tài khoản người dùng sẽ bị khóa, bạn có chắc muốn tiếp tục không?\');">Active</a></p>';
                    } else {
                        echo '<p><a href="memberstatus.php?user_id='.$result['user_id'].'&status=1" 
                        class="btn btn-danger" onclick="return confirm(\'Tài khoản người dùng sẽ được mở khóa, bạn có chắc muốn tiếp tục không?\');">Inactive</a></p>';
                    }
                    ?>


                    </td?>
                <td>
                    <?php
                    
                    ?><a href="memberupdate.php?user_id=<?php echo $result['user_id'] ?>">Cập nhật </a>|
                    <a href="memberdelete.php?user_id=<?php echo $result['user_id'] ?>" onclick="return confirm('Tài khoản người dùng sẽ xóa vĩnh viễn, bạn có chắc muốn tiếp tục không?');">Xóa</a></td>
                </td>
            </tr>
            <?php
                     }}
                    ?>

        </table>
    </div>
</div>
</section>
<section>
</section>
<script src="js/script.js"></script>
</body>

</html>
