<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $id = $_POST['id'];
   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];

   $sql = "UPDATE children SET `firstname`='$firstname', `lastname`='$lastname' WHERE id = $id";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      header("location: parents_dashboard.php?msg=updated+successfully");
   } else {
      echo mysqli_error($conn);
      // header("location: hospitals.php?msg=an+error+occured");
   }
}
