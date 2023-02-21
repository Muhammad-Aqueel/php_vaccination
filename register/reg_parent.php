<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   $fullname = $_POST['fullname'];
   $user_id = $_POST['id'];
   $dateofbirth = $_POST['dateofbirth'];

   $sql = "INSERT INTO parents(`parent_name`, `dateofbirth`, `user_id`) VALUES('$fullname', '$dateofbirth', $user_id);";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: /php-vaccination?msg=Your+account+has+been+created");
   } else {
      header("location: /php-vaccination?msg=something+went+wrong");
   }
}
