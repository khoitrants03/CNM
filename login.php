<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
   
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_EMAIL);  
 
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['phanquyen'] = $row['phanquyen']; 
      header('location:home.php');
      exit;
   } else {
      $message[] = 'Sai tài khoản hoặc mật khẩu!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đăng nhập</title>
   <link rel="shortcut icon" href="./imgs/hospital-solid.svg" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <section class="form-container">

      <form action="" method="post">
         <h3>Đăng nhập</h3>
         <input type="email" name="email" required placeholder="Nhập email của bạn" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="Nhập mật khẩu của bạn" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Đăng nhập" name="submit" class="btn">
         <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
         <!-- <p>Bạn là quản trị viên? <a href="admin/admin_login.php">Admin</a></p> -->

      </form>

   </section>


   <?php include 'components/footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>