<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

function get_name($usertype)
{
   switch ($usertype) {
      case 'hospital':
         return $_SESSION['hospital_name'];
      case 'parent':
         return $_SESSION['parent_name'];
      case 'admin':
         return $_SESSION['username'];
   }
}

$display_name = get_name($_SESSION['usertype']);
