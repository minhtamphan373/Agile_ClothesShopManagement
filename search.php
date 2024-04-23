<?php
// Kết nối đến cơ sở dữ liệu và các tác vụ khác cần thiết
include "header.php"; // Include header của trang
include "leftside_search.php"; // Nếu có
require_once "class/index_class.php"; // Thay đổi include thành require_once để tránh lỗi trùng lặp

// Kiểm tra xem có từ khóa tìm kiếm được cung cấp hay không
if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    
    // Hiển thị tiêu đề tìm kiếm
    echo "<h2>Kết quả tìm kiếm cho: '$keyword'</h2>";
    
    // Thực hiện tìm kiếm trong cơ sở dữ liệu
    function performSearch($keyword) {
        $index = new index(); // Tạo một thể hiện của class index
        return $index->searchProducts($keyword); // Gọi phương thức searchProducts từ class index
    }
    
    // Gọi hàm performSearch với từ khóa và lưu kết quả vào biến $searchResults
    $searchResults = performSearch($keyword);
    
    // Hiển thị phần danh sách sản phẩm nếu có kết quả tìm kiếm
    if($searchResults->num_rows > 0) {
        echo "<div class='cartegory-right-content row'>";
        while($result = $searchResults->fetch_assoc()) {
            // Hiển thị sản phẩm từ kết quả tìm kiếm
            echo "<div class='cartegory-right-content-item'>";
            echo "<a href='product.php?sanpham_id=".$result['sanpham_id']."'><img src='admin/uploads/".$result['sanpham_anh']."' alt='".$result['sanpham_tieude']."'></a>";
            echo "<a href='product.php?sanpham_id=".$result['sanpham_id']."'><h1>".$result['sanpham_tieude']."</h1></a>";
            echo "<p>".number_format($result['sanpham_gia'])."<sup>đ</sup></p>";
            echo "<span>_new_</span>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        // Hiển thị thông báo khi không có kết quả tìm kiếm
        echo "Không tìm thấy sản phẩm nào phù hợp với từ khóa '$keyword'.";
    }
} else {
    // Hiển thị thông báo khi không có từ khóa tìm kiếm
    echo "Vui lòng nhập từ khóa để tìm kiếm sản phẩm.";
}
?>
</section>

<!-- -------------------------Footer -->
<?php
include "footer.php"
?>
