<?php
include './login_logic.php';

$h_id = 0;

if ($_SESSION['usertype'] === "hospital") {
   $h_id = $_SESSION['h_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Welcome <?= $_SESSION['username'] ?></title>
   <link rel="stylesheet" href="./dist/style.css">
   <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
   <div class="min-h-screen" x-data="{ modal: false, editData: {}, deleteData: {}, approveData: {}, completed: {} }">
      <div class="bg-black/40 transition flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

         <div class="p-8 w-fit rounded-xl shadow-lg bg-white" @keyup.escape.window="modal = false" @click.outside="modal = false" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">

            <template x-if="editData.id">
               <form action="req_update.php" method="POST" class="flex flex-col gap-2">
                  <h4 class="text-2xl text-center font-medium mb-2">Update Booking Date</h4>
                  <input type="hidden" name="id" x-model="editData.id">
                  <div class="flex flex-col gap-0.5">
                     <label for="time" class="pl-2 capitalize">time</label>
                     <input type="time" x-model="editData.time" min="1" max="10000" name="time" id="time" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                     <label for="date" class="pl-2 capitalize">date</label>
                     <input type="date" x-model="editData.date" min="1" max="10000" name="date" id="date" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex items-center justify-end gap-3 mt-2">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Edit & Approve
                     </button>
                  </div>
               </form>
            </template>

            <template x-if="completed.id">
               <div class="flex gap-2 flex-col max-w-md">
                  <h4 class="text-2xl font-medium text-center mb-1">Approve Request</h4>
                  <h6 class="font-medium -mb-1">Vaccinated Report Status:</h6>
                  <div class="flex gap-3 items-center">
                     <div class="flex gap-1 items-center">
                        <input type="radio" id="positive" x-model="completed.report" class="checked:accent-red-600" value="positive" name="vaccinated_report">
                        <label for="positive">Positive</label>
                     </div>
                     <div class="flex gap-1 items-center">
                        <input type="radio" id="negative" x-model="completed.report" class="checked:accent-green-600" value="negative" name="vaccinated_report">
                        <label for="negative">Negative</label>
                     </div>
                  </div>
                  <p class="text-gray-800">
                     Are you sure you want to approve <span class="font-bold">request no. <span x-text="completed.id"></span></span>?
                  </p>
                  <div class="flex items-center justify-end gap-3">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <a x-bind:href="`req_actions.php?id=${completed.id}&act=3&st=${completed.report}`" type="submit" class="inline-block rounded bg-green-600 hover:bg-green-700 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Complete
                     </a>
                  </div>
               </div>
            </template>

            <template x-if="approveData.id">
               <div class="flex gap-3.5 flex-col max-w-md">
                  <h4 class="text-2xl font-medium text-center">Approve Request</h4>
                  <p class="text-gray-800">
                     Are you sure you want to approve <span class="font-bold">request no. <span x-text="approveData.id"></span></span>?
                  </p>
                  <div class="flex items-center justify-end gap-3">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <a x-bind:href="`req_actions.php?id=${approveData.id}&act=1`" type="submit" class="inline-block rounded bg-green-500 hover:bg-green-600 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Approve
                     </a>
                  </div>
               </div>
            </template>

            <template x-if="deleteData.id">
               <div class="flex gap-3.5 flex-col max-w-md">
                  <h4 class="text-2xl font-medium text-center">Reject Request</h4>
                  <p class="text-gray-800">
                     Are you sure you want to reject <span class="font-bold">request no. <span x-text="deleteData.id"></span></span>?
                  </p>
                  <div class="flex items-center justify-end gap-3">
                     <button type="button" @click="modal = false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <a x-bind:href="`req_actions.php?id=${deleteData.id}&act=2`" type="submit" class="rounded bg-red-500 hover:bg-red-600 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-trash3"></i>
                        Yes, Reject
                     </a>
                  </div>
               </div>
            </template>
         </div>

      </div>
      <?php include './nav.php' ?>
      <div class="h-full grid grid-cols-6 px-5 gap-5">
         <?php include './sidenav.php' ?>
         <div class="col-span-5 h-full">
            <h3 class="text-2xl font-semibold mt-4">
               <i class="bi bi-check-circle-fill"></i>
               Completed
            </h3>
            <table class="w-full bg-gray-100 rounded-lg mt-2">
               <thead>
                  <th class="p-2">Req Id.</th>
                  <th class="p-2">Child Name</th>
                  <th class="p-2">Vaccine Name</th>
                  <th class="p-2">Vaccinated Status</th>
                  <th class="p-2">Time</th>
                  <th class="p-2">Date</th>
               </thead>
               <tbody class="rounded-b-md max-h-12">
                  <?php
                  include_once './conn.php';
                  include './get_vaccinated_status.php';

                  if ($_SESSION['usertype'] === 'hospital')
                     $sql = "SELECT bookings.id, bookings.vaccinated_status, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 3 AND bookings.hospital_id = $h_id;";
                  else if ($_SESSION['usertype'] === 'admin')
                     $sql = "SELECT bookings.id, bookings.vaccinated_status, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 3;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr class="last:rounded-b-md">
                                    <td class="text-center p-1">' . $row['id'] . '</td>
                                    <td class="text-center p-1">' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                    <td class="text-center p-1">' . $row['vaccine_name'] . '</td>
                                    <td class="text-center p-1 ' .
                              ($row['vaccinated_status'] == 0 ?
                                 'bg-green-100' : ($row['vaccinated_status'] == 1 ? 'bg-red-100' : '')) .
                              '">' . get_vaccinated_status($row['vaccinated_status']) . '<i class="' . ($row['vaccinated_status'] == 0 ? 'text-green-600 bi-check-circle-fill' : ($row['vaccinated_status'] == 1 ? 'text-red-600 bi-exclamation-circle-fill' : '')) . ' bi ml-2"></i></td>
                                    <td class="text-center p-1">' . $row['booking_time'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_date'] . '</td>
                                 </tr>';
                        }
                     } else {
                        echo '<tr class="">
                                 <td colspan="5" class="py-4 px-1 text-center text-yellow-600 bg-[rgb(255,254,241)] rounded-b-md">
                                    <i class="bi bi-info-circle mr-1"></i>
                                    No bookings
                                 </td>
                              </tr>';
                     }
                  }
                  ?>
               </tbody>
            </table>

            <h3 class="text-2xl font-semibold mt-4">
               <i class="bi bi-check-circle"></i>
               Approved
            </h3>
            <table class="w-full bg-gray-100 rounded-lg mt-2">
               <thead>
                  <th class="p-2">Req Id.</th>
                  <th class="p-2">Child Name</th>
                  <th class="p-2">Vaccine</th>
                  <th class="p-2">Time</th>
                  <th class="p-2">Date</th>
                  <th class="p-2">Actions</th>
               </thead>
               <tbody class="rounded-b-md max-h-4 overflow-y-auto">
                  <?php
                  include_once './conn.php';

                  if ($_SESSION['usertype'] === 'hospital')
                     $sql = "SELECT bookings.id, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 1 AND bookings.hospital_id = $h_id;";
                  else if ($_SESSION['usertype'] === 'admin')
                     $sql = "SELECT bookings.id, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 1;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr class="last:rounded-b-md">
                                    <td class="text-center p-1">' . $row['id'] . '</td>
                                    <td class="text-center p-1">' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                    <td class="text-center p-1">' . $row['vaccine_name'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_time'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_date'] . '</td>
                                    <td class="text-center p-1">
                                       <button @click="
                                       modal = true;
                                       deleteData = {};
                                       editData = {};
                                       approveData = {};
                                       completed = {
                                          id: ' . $row['id'] . '
                                       }
                                       " class="text-sm px-2.5 py-1 rounded-md bg-green-100 hover:bg-green-200 transition">
                                          <i class="bi bi-check-circle-fill text-green-800"></i>
                                          Mark as completed
                                       </button>
                                    </td>
                                 </tr>';
                        }
                     } else {
                        echo '<tr class="">
                                 <td colspan="6" class="py-4 px-1 text-center text-yellow-600 bg-[rgb(255,254,241)] rounded-b-md">
                                    <i class="bi bi-info-circle mr-1"></i>
                                    No bookings
                                 </td>
                              </tr>';
                     }
                  }
                  ?>
               </tbody>
            </table>

            <h3 class="text-2xl font-semibold mt-8">
               <i class="bi bi-x-circle"></i>
               Rejected
            </h3>
            <table class="w-full bg-gray-100 rounded-lg mt-2">
               <thead>
                  <th class="p-2">Req Id.</th>
                  <th class="p-2">Child Name</th>
                  <th class="p-2">Vaccine</th>
                  <th class="p-2">Time</th>
                  <th class="p-2">Date</th>
               </thead>
               <tbody class="rounded-b-md">
                  <?php
                  include_once './conn.php';
                  if ($_SESSION['usertype'] === 'hospital')
                     $sql = "SELECT bookings.id, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 2 AND bookings.hospital_id = $h_id;";
                  else if ($_SESSION['usertype'] === 'admin')
                     $sql = "SELECT bookings.id, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 2;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr class="last:rounded-b-md">
                                    <td class="text-center p-1">' . $row['id'] . '</td>
                                    <td class="text-center p-1">' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                    <td class="text-center p-1">' . $row['vaccine_name'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_time'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_date'] . '</td>
                                 </tr>';
                        }
                     } else {
                        echo '<tr class="">
                                 <td colspan="5" class="py-4 px-1 text-center text-yellow-600 bg-[rgb(255,254,241)] rounded-b-md">
                                    <i class="bi bi-info-circle mr-1"></i>
                                    No bookings
                                 </td>
                              </tr>';
                     }
                  }
                  ?>
               </tbody>
            </table>

            <h3 class="text-2xl font-semibold mt-8">
               <i class="bi bi-app-indicator"></i>
               Pending
            </h3>
            <table class="w-full bg-gray-100 rounded-lg mt-2">
               <thead>
                  <th class="p-2">Req Id.</th>
                  <th class="p-2">Child Name</th>
                  <th class="p-2">Vaccine</th>
                  <th class="p-2">Time</th>
                  <th class="p-2">Date</th>
                  <th class="p-2">Actions</th>
               </thead>
               <tbody class="rounded-b-md">
                  <?php
                  include_once './conn.php';
                  if ($_SESSION['usertype'] === 'hospital')
                     $sql = "SELECT bookings.id, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 0 AND bookings.hospital_id = $h_id;";
                  else if ($_SESSION['usertype'] === 'admin')
                     $sql = "SELECT bookings.id, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE bookings.responded = 0;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr class="last:rounded-b-md">
                                    <td class="text-center p-1">' . $row['id'] . '</td>
                                    <td class="text-center p-1">' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                    <td class="text-center p-1">' . $row['vaccine_name'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_time'] . '</td>
                                    <td class="text-center p-1">' . $row['booking_date'] . '</td>
                                    <td class="text-center">
                                       <button @click="
                                       modal = true;
                                       deleteData = {};
                                       editData = {};
                                       completed = {};
                                       approveData = {
                                          id: ' . $row['id'] . '
                                       }
                                       " href="req_actions.php?act=1&id=' . $row['id'] . '" class="inline-block text-center text-sm px-2.5 mr-1 py-1 rounded-md bg-green-100 hover:bg-green-200 transition">
                                          <i class="bi bi-check-circle mr-0.5 inline-block"></i>
                                          Approve
                                       </button>
                                       <button @click="
                                       modal = true;
                                       deleteData = {};
                                       approveData = {};
                                       completed = {};
                                       editData = {
                                          id: ' . $row['id'] . ',
                                          time: \'' . $row['booking_time'] . '\',
                                          date: \'' . $row['booking_date'] . '\'
                                       };
                                       " class="text-sm px-2.5 mr-1 py-1 rounded-md bg-light-cyan hover:bg-cyan-200 transition">
                                          <i class="bi bi-pencil-square mr-0.5 inline-block"></i>
                                          Edit Timings
                                       </button>
                                       <button @click="
                                       modal = true;
                                       approveData = {};
                                       editData = {};
                                       deleteData = {
                                          id: ' . $row['id'] . '
                                       }
                                       " class="text-sm px-2.5 py-1 rounded-md bg-red-100 hover:bg-red-200 transition">
                                          <i class="bi bi-x-circle mr-0.5 inline-block"></i>
                                          Reject
                                       </button>
                                    </td>
                                 </tr>';
                        }
                     } else {
                        echo '<tr class="">
                                 <td colspan="6" class="py-4 px-1 text-center text-yellow-600 bg-[rgb(255,254,241)] rounded-b-md">
                                    <i class="bi bi-info-circle mr-1"></i>
                                    No pending bookings
                                 </td>
                              </tr>';
                     }
                  }
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <script>

   </script>
</body>

</html>