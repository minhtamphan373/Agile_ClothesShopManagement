<?php
include "header.php";
include "leftside.php";
// include "class/cartegory_class.php";
// define('__ROOT__', dirname(dirname(__FILE__))); 
// require_once(__ROOT__.'../admin/class/cartegory_class.php');
 ?>
 
<?php
$comment = new comment();
if (!isset($_GET['user_id']) || $_GET['user_id'] == NULL) {
    echo "<script>window.location = 'memberlist.php'</script>";
} else {
    $user_id = $_GET['user_id'];
    $comment = $comment->delete_member($user_id);
    header('Location: memberlist.php');
}
?>
