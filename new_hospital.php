<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $username = $_POST['hpt_username'];
   $password = password_hash($_POST['hpt_password'], PASSWORD_BCRYPT);
   $hospital_name = $_POST['hpt_name'];
   $address = $_POST['address'];
   $city = $_POST['city'];
   $country = $_POST['country'];

   $sql = "INSERT INTO users (`username`, `password`, `usertype`) VALUES('$username', '$password', 'hospital');";
   $res = mysqli_query($conn, $sql);
   if ($res) {
      $user_id = mysqli_insert_id($conn);
      $sql2 = "INSERT INTO hospitals (`hospital_name`, `address`, `city`, `country`, `user_id`) VALUES('$hospital_name', '$address', '$city', '$country', $user_id);";
      $res2 = mysqli_query($conn, $sql2);
      if ($res2) {
         header("location: hospitals.php?msg=inserted+successfully");
      } else {
         echo mysqli_error($conn);
         // header("location: hospitals.php?msg=an+error+occured");
      }
   } else {
      echo mysqli_error($conn);
      // header("location: hospitals.php?msg=an+error+occured");
   }
}
