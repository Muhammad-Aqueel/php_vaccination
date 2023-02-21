<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $id = $_POST['id'];
   $hospital_name = $_POST['hpt_name'];
   $address = $_POST['address'];
   $city = $_POST['city'];
   $country = $_POST['country'];

   $sql = "UPDATE hospitals SET `hospital_name`='$hospital_name', `address`='$address', `city`='$city', `country`='$country' WHERE id = $id";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: hospitals.php?msg=updated+successfully");
   } else {
      echo mysqli_error($conn);
      // header("location: hospitals.php?msg=an+error+occured");
   }
}
?>