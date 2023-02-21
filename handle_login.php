<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
   $username = $_POST['username'];
   $password = $_POST['password'];
   $sql = "SELECT * FROM users WHERE username='$username';";
   $res = mysqli_query($conn, $sql);
   if ($res) {
      if (mysqli_num_rows($res) > 0) {
         $row = mysqli_fetch_assoc($res);
         if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['usertype'] = $row['usertype'];
            $_SESSION['isloggedin'] = true;
            if ($row['usertype'] === 'admin'){
               
               header("location: ./dashboard.php");
               
            }
            else if ($row['usertype'] === 'hospital') {
               $sql2 = "SELECT * FROM hospitals WHERE user_id={$row['id']}";
               $res2 = mysqli_query($conn, $sql2);
               if ($res2) {
                  if (mysqli_num_rows($res2) > 0) {
                     $row2 = mysqli_fetch_assoc($res2);
                     $_SESSION['h_id'] = $row2['id'];
                     $_SESSION['hospital_name'] = $row2['hospital_name'];
                     header("location: ./dashboard.php");
                  }
               }
            } else if ($row['usertype'] == 'parent') {
               $sql2 = "SELECT * FROM parents WHERE user_id={$row['id']}";
               $res2 = mysqli_query($conn, $sql2);
               if ($res2) {
                  echo $row['usertype'];
                  if (mysqli_num_rows($res2) > 0) {
                     $row2 = mysqli_fetch_assoc($res2);
                     $_SESSION['p_id'] = $row2['id'];
                     $_SESSION['parent_name'] = $row2['parent_name'];
                     header("location: ./parents_dashboard.php");
                  }
               }
            }
         } else {
            header("location: ./index.php?msg=incorrect+username+or+password");
         }
      } else {
         header("location: ./index.php?msg=incorrect+username+or+password");
      }
   }
}
