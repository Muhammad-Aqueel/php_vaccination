<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   $user_id = $_POST['id'];
   $hospital_name = $_POST['hospital_name'];
   $address = $_POST['address'];
   $city = $_POST['city'];
   $country = $_POST['country'];

   $sql = "INSERT INTO hospitals(`hospital_name`, `address`, `city`, `country`, `user_id`) VALUES('$hospital_name', '$address', '$city', '$country', $user_id);";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: /php-vaccination?msg=Your+account+has+been+created");
   } else {
      header("location: /php-vaccination?msg=something+went+wrong");
   }
}
