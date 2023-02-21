<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   $id = $_POST['id'];

   $sql = "DELETE FROM hospitals WHERE id = $id;";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: hospitals.php?msg=deleted+successfully");
   } else {
      // header("location: hospitals.php?msg=an+error+occurred");
      echo mysqli_error($conn);
   }
}
