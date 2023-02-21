<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $child = $_POST['child'];
   $parent = $_POST['parent'];
   $hospital = $_POST['hospital'];
   $vaccine = $_POST['vaccine'];
   $date = $_POST['date'];
   $time = $_POST['time'];

   $sql = "INSERT INTO bookings(`vaccine_id`, `hospital_id`, `child_id`, `booking_date`, `booking_time`, `parent_id`) VALUES($vaccine, $hospital, $child, '$date', '$time', $parent);";
   $res = mysqli_query($conn, $sql);
   if ($res) {
      // echo 'success';
      header("location: bookings.php?msg=booked+successfully");
   } else {
      echo mysqli_error($conn);
   }
}
