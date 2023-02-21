<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $id = $_POST['id'];
   $quantity = $_POST['quantity'];

   $sql = "UPDATE vaccines SET `quantity`='$quantity' WHERE id = $id";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: vaccines.php?msg=updated+successfully");
   } else {
      echo mysqli_error($conn);
      // header("location: hospitals.php?msg=an+error+occured");
   }
}
