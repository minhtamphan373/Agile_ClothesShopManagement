<?php
include "header.php";
include "leftside.php";
// include "class/cartegory_class.php";
// define('__ROOT__', dirname(dirname(__FILE__))); 
// require_once(__ROOT__.'../admin/class/comment_class.php');
?>

<?php
$comment = new comment();
if (isset($_GET['user_id'])|| $_GET['user_id']!=NULL){
 
    $user_id = $_GET['user_id'];

    if(isset($_GET['status']) || $_GET['status']!= NULL){
        $status = $_GET['status'];
    }
    $status_member = $comment  -> status_member($user_id, $status);

    // if($status_member) {
    //     echo "Cập nhật trạng thái thất bại!";
    // } else {
    //     echo "Cập nhật trạng thái thành công!";
    // }
    header('Location:memberlist.php');
}
 
?>