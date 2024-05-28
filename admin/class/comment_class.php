<?php
// include "../lib/database.php";
// include "../helper/format.php"
?>

<?php
class comment
{

   private $db;
   private $fm;

    public function __construct()
    {
        $this ->db = new Database();
        $this ->fm = new Format();
    }

    public function show_comment(){
        $query = "SELECT * FROM tbl_comment ORDER BY comment_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }
    public function show_question(){
        $query = "SELECT * FROM tbl_question ORDER BY question_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }
    public function show_answer() {
        $query = "SELECT * FROM tbl_question_answer ORDER BY question_answer_id  DESC";
        $result = $this -> db ->select($query);
        return $result;
    }
    public function show_member(){
        $query = "SELECT * FROM tbl_user ORDER BY user_id DESC";
        $result = $this -> db ->select($query);
        return $result;
    }
    public function delete_comment($comment_id){
        $query = "DELETE  FROM tbl_comment WHERE comment_id = '$comment_id'";
        $result = $this -> db ->delete($query);
        return $result;
        // if($result) {$alert = "<span class = 'alert-style'> Delete Thành công</span> "; return $alert;}
        // else {$alert = "<span class = 'alert-style'> Delete Thất bại</span>"; return $alert;}
    
    }
    public function delete_question($question_id) {
        $query = "DELETE  FROM tbl_question WHERE question_id = '$question_id'";
        $result = $this -> db ->delete($query);
        return $result;
    }
    public function delete_answer($question_answer_id){
        $query = "DELETE  FROM tbl_question_answer WHERE question_answer_id = '$question_answer_id'";
        $result = $this -> db ->delete($query);
        return $result;
    }
    
    public function insert_member($user_ten,$user_password,$user_img){
        $query = "INSERT INTO tbl_user (user_ten,user_password,user_img) VALUES ('$user_ten','$user_password','$user_img')";
        $result = $this ->db ->insert($query);
        // header('Location:memberlist.php');
        return $result;
    }
        
    // public function delete_member($user_id){
    //     $query = "DELETE  FROM tbl_user WHERE user_id = '$user_id'";
    //     $result = $this -> db ->delete($query);
    //     return $result;
    //     // if($result) {$alert = "<span class = 'alert-style'> Delete Thành công</span> "; return $alert;}
    //     // else {$alert = "<span class = 'alert-style'> Delete Thất bại</span>"; return $alert;}
    // }     
    
    public function delete_user_info($user_id) {
        $query_user_info = "DELETE FROM user_info WHERE user_id_ref = '$user_id'";
        $result_user_info = $this->db->delete($query_user_info);
        return $result_user_info;
    }
    
    public function delete_member($user_id) {
        // Gọi hàm để xóa dữ liệu từ bảng user_info trước
        $result_user_info = $this->delete_user_info($user_id);
    
        // Nếu xóa dữ liệu từ bảng user_info thành công, tiếp tục xóa dữ liệu từ bảng tbl_user
        if ($result_user_info) {
            $query_tbl_user = "DELETE FROM tbl_user WHERE user_id = '$user_id'";
            $result_tbl_user = $this->db->delete($query_tbl_user);
            return $result_tbl_user; // Trả về kết quả từ việc xóa dữ liệu từ bảng tbl_user
        } else {
            return false; // Trả về false nếu không thể xóa dữ liệu từ bảng user_info
        }
    }
    
    

    public function status_member($user_id, $status){
        $query = "UPDATE tbl_user SET status = '$status' WHERE user_id = '$user_id'";
        $result = $this -> db -> update($query);
        //header('location:memberlist.php');
    }

    public function get_member($user_id){
        $query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function update_member($user_id, $user_ten, $user_password, $user_email, $status){
        $user_ten = $this->db->link->real_escape_string($user_ten);
        $user_password = $this->db->link->real_escape_string($user_password);
        $user_email = $this->db->link->real_escape_string($user_email);
        $status = $this->db->link->real_escape_string($status);
    
        $query = "UPDATE tbl_user SET user_ten = '$user_ten', user_password = '$user_password', user_email = '$user_email', status = '$status' WHERE user_id = '$user_id'";
        $update_row = $this->db->update($query);
        if($update_row){
            header("Location: memberlist.php");
        } else {
            $msg = "<span class='error'>Cập nhật Thành viên thất bại.</span>";
            return $msg;
        }
    }

    
}
  

?>
