<?php
include "header.php";
include "leftside.php";
require_once "class/cartegory_class.php"; // Include file chứa lớp cartegoty

if (!isset($_GET['danhmuc_id']) || $_GET['danhmuc_id'] == NULL) {
    // Nếu không có danh mục hoặc danh mục là null, chuyển hướng người dùng đến trang cartegorylist.php
    header('Location: cartegorylist.php');
    exit; // Kết thúc script
}

// Lấy danh mục ID từ tham số GET
$danhmuc_id = $_GET['danhmuc_id'];

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // Nếu người dùng đã xác nhận xóa
    $cartegory = new cartegoty(); // Tạo một đối tượng cartegoty
    $delete_cartegory = $cartegory->delete_cartegory($danhmuc_id); // Gọi phương thức xóa danh mục
    if ($delete_cartegory) {
        // Nếu xóa thành công, chuyển hướng với thông báo thành công
        header('Location: cartegorylist.php?success=1');
        exit; // Kết thúc script
    } else {
        // Nếu xóa không thành công, chuyển hướng với thông báo lỗi
        header('Location: cartegorylist.php?error=1');
        exit; // Kết thúc script
    }
} else {
    // Nếu không xác nhận xóa, chuyển hướng người dùng đến trang cartegorylist.php
    header('Location: cartegorylist.php');
    exit; // Kết thúc script
}
?>
