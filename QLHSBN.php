<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bác Sĩ</title>
    <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../WebHopital-master/css/style.css">
    <link rel="stylesheet" href="../WebHopital-master/css/QLHSBN.css">
</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

    <div class="heading">
    <h3>Quản Lý Hồ Sơ Bệnh Nhân</h3>
    <p><a href="home.php">Trang chủ</a> <span> / Quản Lý Hồ Sơ Bệnh Nhân</span></p>
    </div>
<div class="appointment-section">
   <div class="">
   <?php
// Quản Lý Hồ Sơ Bệnh Nhân
include_once("Controller/cQLHS.php");
echo "<h2 class='tieu-de'>Danh Sách Hồ Sơ Bệnh Nhân</h2>";

$p = new controllQLHS();

// Xác định trang hiện tại và từ khóa tìm kiếm
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; // Số lượng hồ sơ mỗi trang
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : ''; // Lấy từ khóa tìm kiếm từ URL

// Lấy dữ liệu với phân trang và tìm kiếm
$searchResult = $p->searchHSBN($keyword, $page, $limit);

if ($searchResult['success']) {
    if (count($searchResult['data']) > 0) {
        // Thanh tìm kiếm
        echo "<div class='search-bar'>
        <form method='GET' action=''>
         <div class='search-wrapper'>
            <input type='text' name='keyword' id='searchInput' placeholder='Tìm kiếm hồ sơ...' value='$keyword'>
            <button type='submit'>&#128269;</button>
        </div>
        </form>
    </div>";


        // Nút thêm hồ sơ
        echo "<h2><a href='themHSBN.php' class='add-HSBN-btn'>Thêm Hồ Sơ</a></h2>";

        // Bảng dữ liệu
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>Mã Bệnh Nhân</th>
                    <th>Tên Bệnh Nhân</th>
                    <th>Ngày Sinh</th>
                    <th>Giới Tính</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                    <th>Thông Tin Bảo Hiểm</th>
                    <th>Thao tác</th>
                </tr>
              </thead>";
        echo "<tbody>";

        // Hiển thị các bản ghi trong bảng
        foreach ($searchResult['data'] as $row) {
            echo "<tr>";
            echo "<td>" . $row["MaBN"] . "</td>";
            echo "<td>" . $row["Ten"] . "</td>";
            echo "<td>" . $row["NgaySinh"] . "</td>";
            echo "<td>" . $row["GioiTinh"] . "</td>";
            echo "<td>" . $row["DiaChi"] . "</td>";
            echo "<td>" . $row["SoDienThoai"] . "</td>";
            echo "<td>" . $row["ThongTinBaoHiem"] . "</td>";
            echo "<td>
                    <a href='SuaHSBN.php?MaBN=" . $row["MaBN"] . "' class='update'>Sửa</a>
                    <a href='xoaHSBN.php?id=" . $row["MaBN"] . "' class='delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa hồ sơ này không?\");'>Xóa</a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Phân trang
        $totalPages = ceil($searchResult['total'] / $limit);
        echo "<div class='pagination'>";

        // Thêm các nút phân trang
        if ($page > 1) {
            echo "<a href='?page=1&keyword=$keyword' class='first-page'>Trang đầu</a>";
            echo "<a href='?page=" . ($page - 1) . "&keyword=$keyword' class='page-link prev-page'>Trang trước</a>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $page) ? 'class="active"' : '';
            echo "<a href='?page=$i&keyword=$keyword' $activeClass class='page-link'>$i</a>";
        }

        if ($page < $totalPages) {
            echo "<a href='?page=" . ($page + 1) . "&keyword=$keyword' class='page-link next-page'>Trang sau</a>";
            echo "<a href='?page=$totalPages&keyword=$keyword' class='last-page'>Trang cuối</a>";
        }

        echo "</div>";
    } else {
        // Nếu không có kết quả, hiển thị thông báo và nút quay lại
        echo "<p>Không có kết quả tìm kiếm phù hợp.</p>";
        echo "<a href='QLHSBN.php' class='back-btn'>Trở lại</a>";
    }
} else {
    // Nếu có lỗi trong việc tìm kiếm
    echo "<p>" . $searchResult['message'] . "</p>";
}
?>
    </div>
</div>


   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->=

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            700: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>