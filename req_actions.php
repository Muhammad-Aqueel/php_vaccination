<?php
include './conn.php';

if (isset($_GET['id']) and isset($_GET['act'])) {
   $id = $_GET['id'];
   $act = (int)$_GET['act'];
   $st = $_GET['st'];

   if ($act === 3 and $st === 'positive' or $st === 'negative') {
      if ($st === 'positive')
         {$st = 1;}
      if ($st === 'negative')
         {$st = 0;}
         $sql = "UPDATE bookings SET responded = $act, vaccinated_status = $st WHERE id = $id";
      } else if ($act !== 3){
         $sql = "UPDATE bookings SET responded = $act WHERE id = $id";
      } else {
         header("location: requests.php");
      }
   $res = mysqli_query($conn, $sql);
   if ($res)
      {header("location: requests.php");}
   else{
      // echo mysqli_error($conn);
      header("location: requests.php");
   }
}
