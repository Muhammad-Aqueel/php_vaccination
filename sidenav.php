<?php
if (!isset($_SESSION))
   session_start();
$server_filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

?>

<div class="bg-gray-100 p-2 sticky rounded-lg">
   <ul class="flex flex-col gap-1 justify-center">
      <?php
      if ($_SESSION['isloggedin'] === true && $_SESSION['usertype'] === 'admin') {
         echo '<li class="rounded active:scale-95 transition ' . ($server_filename === 'dashboard.php' ? 'bg-burnt-sienna text-white' : 'hover:bg-gray-100') . '">
                  <a href="dashboard.php" class="w-full h-full px-3 py-2 inline-block">
                     <i class="bi bi-people' . ($server_filename === 'dashboard.php' ? '-fill' : '') . ' inline-block mr-2"></i>
                     All Parents
                  </a>
               </li>';
      }
      if ($_SESSION['isloggedin'] === true && $_SESSION['usertype'] === 'admin') {
         echo '<li class="rounded active:scale-95 transition ' . ($server_filename === 'hospitals.php' ? 'bg-burnt-sienna text-white' : 'hover:bg-gray-100') . '">
                  <a href="hospitals.php" class="w-full h-full px-3 py-2 inline-block">
                     <i class="bi bi-hospital' . ($server_filename === 'hospitals.php' ? '-fill' : '') . ' inline-block mr-2"></i>
                     Hospitals
                  </a>
               </li>';
      }
      if ($_SESSION['isloggedin'] === true && $_SESSION['usertype'] === 'admin' || $_SESSION['usertype'] === 'hospital') {
         echo '<li class="rounded active:scale-95 transition ' . ($server_filename === 'requests.php' ? 'bg-burnt-sienna text-white' : 'hover:bg-gray-100') . '">
                  <a href="requests.php" class="w-full h-full px-3 py-2 inline-block">
                     <i class="bi bi-file-earmark-medical' . ($server_filename === 'requests.php' ? '-fill' : '') . ' inline-block mr-2"></i>
                     Requests
                  </a>
               </li>';
      }
      if ($_SESSION['isloggedin'] === true && ($_SESSION['usertype'] === 'admin' || $_SESSION['usertype'] === 'hospital')) {
         echo '<li class="rounded active:scale-95 transition ' . ($server_filename === 'vaccines.php' ? 'bg-burnt-sienna text-white' : 'hover:bg-gray-100') . '">
                  <a href="vaccines.php" class="w-full h-full px-3 py-2 inline-block">
                     <i class="bi bi-capsule ' . ($server_filename === 'vaccines.php' ? 'rotate-180' : '') . ' inline-block mr-2"></i>
                     Vaccines
                  </a>
               </li>';
      }
      if ($_SESSION['isloggedin'] === true && ($_SESSION['usertype'] === 'parent')) {
         echo '<li class="rounded active:scale-95 transition ' . ($server_filename === 'parents_dashboard.php' ? 'bg-burnt-sienna text-white' : 'hover:bg-gray-100') . '">
                  <a href="parents_dashboard.php" class="w-full h-full px-3 py-2 inline-block">
                     <i class="bi ' . ($server_filename === 'parents_dashboard.php' ? 'bi-emoji-smile-fill' : 'bi-emoji-frown') . ' inline-block mr-2"></i>
                     Children
                  </a>
               </li>';
      }
      if ($_SESSION['isloggedin'] === true && ($_SESSION['usertype'] === 'parent')) {
         echo '<li class="rounded active:scale-95 transition ' . ($server_filename === 'bookings.php' ? 'bg-burnt-sienna text-white' : 'hover:bg-gray-100') . '">
                  <a href="bookings.php" class="w-full h-full px-3 py-2 inline-block">
                     <i class="bi ' . ($server_filename === 'bookings.php' ? 'bi-card-text' : 'bi-card-list') . ' inline-block mr-2"></i>
                     Bookings
                  </a>
               </li>';
      }
      ?>
   </ul>
</div>