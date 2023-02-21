<?php
session_start();
if (!isset($_SESSION['isloggedin']) or $_SESSION['isloggedin'] !== true or !($_SESSION['usertype'] === "admin" or $_SESSION['usertype'] === "hospital" or $_SESSION['usertype'] === "parent")) {
   header("location: /php-vaccination/?msg=login+first");
   exit;
}
?>