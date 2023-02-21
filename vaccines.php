<?php
include './conn.php';
include './login_logic.php';

if (!isset($_SESSION['isloggedin']))
   session_start();
if (isset($_SESSION['h_id']))
   $h_id = $_SESSION['h_id'];
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
   <div class="min-h-screen" x-data="{ modal: false, editData: {}, deleteData: {}, newVaccine: false }">

      <div class="bg-black/40 transition flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

         <div class="p-8 w-fit rounded-xl shadow-lg bg-white" @keyup.escape.window="modal=false" @click.outside="modal = false" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">

            <template x-if="newVaccine">
               <form action="new_vaccine.php" method="POST" class="flex flex-col gap-2">
                  <h4 class="text-2xl text-center font-medium mb-2">New Vaccine</h4>
                  <input type="hidden" name="id" x-model="editData.id">
                  <div class="flex flex-col gap-0.5">
                     <label for="vaccine_name" class="pl-2 capitalize">vaccine name</label>
                     <input type="text" name="vaccine_name" id="vaccine_name" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="quantity" class="pl-2 capitalize">quantity</label>
                     <input type="number" min="1" max="10000" name="quantity" id="quantity" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <?php
                  if ($_SESSION['usertype'] === "hospital") {
                     echo '<input type="hidden" name="hpt_id" value="' . $h_id . '">';
                  } else {
                  ?>
                     <div class="flex flex-col gap-0.5">
                        <label for="hpt_id" class="pl-2 capitalize">Hospital</label>

                        <select name="hpt_id" id="hpt_id" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                           <option value="0">Select hospital</option>
                           <?php

                           $sql = "SELECT * FROM hospitals;";
                           $res = mysqli_query($conn, $sql);

                           if ($res) {
                              if (mysqli_num_rows($res) > 0) {
                                 while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['hospital_name'] . '</option>';
                                 }
                              }
                           }
                           ?>
                        </select>
                     </div>
                  <?php } ?>
                  <div class="flex items-center justify-end gap-3 mt-2">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Create
                     </button>
                  </div>
               </form>
            </template>


            <template x-if="editData.id">
               <form action="edit_vaccine.php" method="POST" class="flex flex-col gap-2">
                  <h4 class="text-2xl text-center font-medium mb-2">Update Vaccine Quantity</h4>
                  <input type="hidden" name="id" x-model="editData.id">
                  <div class="flex flex-col gap-0.5">
                     <label for="quantity" class="pl-2 capitalize">quantity</label>
                     <input type="number" x-model="editData.quantity" min="1" max="10000" name="quantity" id="quantity" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex items-center justify-end gap-3 mt-2">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Update
                     </button>
                  </div>
               </form>
            </template>

            <template x-if="deleteData.id">
               <div class="flex gap-3.5 flex-col max-w-md">
                  <h4 class="text-2xl font-medium text-center">Delete Vaccine</h4>
                  <p class="text-gray-800">
                     Are you sure you want to delete <span class="font-semibold" x-text="deleteData.vaccine_name"></span> of <span class="font-semibold" x-text="deleteData.hospital_name"></span>?
                  </p>
                  <form class="flex items-center justify-end gap-3" action="delete_vaccine.php" method="POST">
                     <input type="hidden" name="id" x-model="deleteData.id">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <button type="submit" class="rounded bg-red-500 hover:bg-red-600 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-trash3"></i>
                        Yes, Delete
                     </button>
                  </form>
               </div>
            </template>
         </div>

      </div>
      <?php include './nav.php' ?>
      <div class="h-full grid grid-cols-6 px-5 gap-5">
         <?php include './sidenav.php' ?>
         <div class="col-span-5 h-full">
            <button @click="modal=true; editData = {}; deleteData = {}; newVaccine=true" class="block ml-auto mr-2 px-4 transition active:scale-95 py-1.5 rounded bg-burnt-sienna text-white mb-2.5">
               <i class="bi bi-plus-circle"></i>
               New Vaccine
            </button>
            <table class="w-full bg-[rgb(252,252,252)] rounded-lg">
               <thead>
                  <th class="p-2">Id</th>
                  <th class="p-2">Vaccine Name</th>
                  <th class="p-2">Quantity</th>
                  <?php
                  if ($_SESSION['usertype'] === "admin") {
                  ?>
                     <th class="p-2">Hospital</th>
                  <?php } ?>
                  <th class="p-2">Actions</th>
               </thead>
               <tbody class="rounded-b-md">
                  <?php
                  include './conn.php';

                  $sql = '';
                  if ($_SESSION['usertype'] === 'admin')
                     $sql = "SELECT vaccines.id, vaccines.vaccine_name, vaccines.quantity, hospitals.hospital_name, hospitals.id AS h_id FROM vaccines JOIN hospitals ON vaccines.hospital_id = hospitals.id;";
                  else
                     $sql = "SELECT * FROM vaccines WHERE hospital_id = $h_id;";

                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo
                           '<tr class="last:rounded-b-md">
                              <td class="text-center p-1">' . $row['id'] . '</td>
                              <td class="text-center p-1">' . $row['vaccine_name'] . '</td>
                              <td class="text-center p-1">' . $row['quantity'] . '</td>';
                           if ($_SESSION['usertype'] === "hospital")
                              $row['hospital_name'] = "";
                           if ($_SESSION['usertype'] === "admin") {
                              echo '<td class="text-center p-1">
                                       <a class="text-blue-500 underline" href="hospitals.php?hl=' . $row['h_id'] . '">' . $row['hospital_name'] . '</a>
                                    </td>';
                           }
                           echo '<td class="text-center p-1">
                                 <button title="Edit" class="px-2 py-0.5 mr-2 rounded-md bg-light-cyan transition hover:bg-cyan-200" @click="
                                    modal = true;
                                    newVaccine = false;
                                    deleteData = {};
                                    editData = {
                                       id: ' . $row['id'] . ',
                                       vaccine_name: \'' . $row['vaccine_name'] . '\',
                                       quantity: \'' . $row['quantity'] . '\'
                                    };
                                 ">
                                    <i class="bi bi-pencil-square"></i>
                                 </button>
                                 <button class="px-2 py-0.5 rounded-md bg-red-100 transition hover:bg-red-300" title="Delete"
                                 @click="
                                 modal = true;
                                 newVaccine = false;
                                 editData = {};
                                 deleteData = {
                                    id: ' . $row['id'] . ',
                                    vaccine_name: \'' . $row['vaccine_name'] . '\',
                                    hospital_name: \'' . $row['hospital_name'] . '\'
                                 }
                                 ">
                                    <i class="bi bi-trash3"></i>
                                 </button>
                              </td>
                           </tr>';
                        }
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