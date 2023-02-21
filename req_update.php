<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   $time = $_POST['time'];
   $date = $_POST['date'];
   $id = $_POST['id'];
   
   $sql = "UPDATE bookings SET `responded` = 1, `booking_time`='$time', `booking_date`='$date' WHERE id = $id;";
   $res = mysqli_query($conn, $sql);

   if ($res)
      header("location: requests.php?msg=yes");
   else
      echo mysqli_error($conn);
}
?>