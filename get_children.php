<?php
include './conn.php';

if (isset($_GET['parent_id'])) {
   $parentId = trim($_GET['parent_id']);

   $sql = "SELECT * FROM children WHERE parent = $parentId";
   $res = mysqli_query($conn, $sql);

   if ($res) {
      if (mysqli_num_rows($res) > 0) {
         $data = [];
         $i = 0;
         while ($row = mysqli_fetch_assoc($res)) {
            $data[$i] = $row;
            $i++;
         }
         echo json_encode($data);
      } else {
         echo json_encode(['msg' => 'no children']);
      }
   } else {
      echo json_encode(['parentid' => $parentId]);
   }
}

   // echo $_GET['parent_id'];
