<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $vaccine_name = $_POST['vaccine_name'];
   $quantity = $_POST['quantity'];
   $hpt_id = $_POST['hpt_id'];

   $sql = "INSERT INTO vaccines (`vaccine_name`, `quantity`, `hospital_id`) VALUES('$vaccine_name', '$quantity', $hpt_id);";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: vaccines.php?msg=inserted+successfully");
   } else {
      echo mysqli_error($conn);
      // header("location: hospitals.php?msg=an+error+occured");
   }
}
