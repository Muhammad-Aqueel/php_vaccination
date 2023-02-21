<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   $id = $_POST['id'];

   $sql = "DELETE FROM vaccines WHERE id = $id;";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: vaccines.php?msg=deleted+successfully");
   } else {
      // header("location: vaccines.php?msg=an+error+occurred");
      echo mysqli_error($conn);
   }
}
