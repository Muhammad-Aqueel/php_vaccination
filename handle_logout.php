<?php
session_start();

if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
   try {
      session_unset();
      session_destroy();
      header("location: ./index.php?msg=Logged+out+successfully");
   } catch (Exception $e) {
      header("location: ./index.php?msg=Failed+to+logout");
   }
}
