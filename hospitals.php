<?php
include './login_logic.php';

if ($_SESSION['usertype'] === 'hospital')
   header("location: vaccines.php");

$hl = '';
if (isset($_GET['hl'])) {
   $hl = $_GET['hl'];
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
   <div class="min-h-screen" x-data="{ modal: false, editData: {}, deleteData: {}, newHospital: false }">
      <div class="bg-black/40 transition overflow-y-auto flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

         <div class="p-8 w-fit rounded-xl shadow-lg bg-white" @keyup.escape.window="modal=false" @click.outside="modal = false" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">
            <template x-if="newHospital">
               <form action="new_hospital.php" method="POST" class="flex flex-col gap-2">
                  <h4 class="text-2xl text-center font-medium mb-2">Create Hospital</h4>
                  <div class="flex flex-col gap-0.5">
                     <label for="hpt_username" class="pl-2 capitalize">username</label>
                     <input type="text" name="hpt_username" id="hpt_username" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="hpt_password" class="pl-2 capitalize">password</label>
                     <input type="password" name="hpt_password" id="hpt_password" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="hpt_name" class="pl-2 capitalize">name</label>
                     <input type="text" name="hpt_name" id="hpt_name" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="address" class="pl-2 capitalize">address</label>
                     <input type="text" name="address" id="address" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="city" class="pl-2 capitalize">city</label>
                     <input type="text" name="city" id="city" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="country" class="pl-2 capitalize">Country</label>
                     <input type="text" name="country" id="country" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-8 py-2 mx-auto">
                     Create
                  </button>
               </form>
            </template>
            <template x-if="editData.id">
               <form action="edit_hospital.php" method="POST" class="flex flex-col gap-2">
                  <h4 x-text="editData.hospital_name" class="text-2xl text-center font-medium mb-2"></h4>
                  <input type="hidden" name="id" x-model="editData.id">
                  <div class="flex flex-col gap-0.5">
                     <label for="hospital_name" class="pl-2 capitalize">name</label>
                     <input type="text" name="hpt_name" id="hospital_name" x-model="editData.hospital_name" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="address" class="pl-2 capitalize">address</label>
                     <input type="text" name="address" id="address" x-model="editData.address" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="city" class="pl-2 capitalize">city</label>
                     <input type="text" name="city" id="city" x-model="editData.city" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="country" class="pl-2 capitalize">Country</label>
                     <input type="text" name="country" id="country" x-model="editData.country" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex items-center justify-end gap-3 mt-2">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Edit
                     </button>
                  </div>
               </form>
            </template>
            <template x-if="deleteData.id">
               <div class="flex gap-3.5 flex-col max-w-lg">
                  <h4 class="text-2xl font-medium text-center">Delete Hospital</h4>
                  <p class="text-gray-800">
                     Are you sure you want to delete <span class="font-semibold" x-text="deleteData.hospital_name"></span>? All vaccines associated with this hospital will also be deleted.
                  </p>
                  <form class="flex items-center justify-end gap-3" action="delete_hospital.php" method="POST">
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
            <button @click="modal=true; editData = {}; deleteData = {}; newHospital=true" class="block ml-auto mr-2 px-4 py-1.5 rounded bg-burnt-sienna text-white mb-2.5 active:scale-95 transition">
               <i class="bi bi-plus-circle"></i>
               New Hospital
            </button>
            <table class="w-full bg-[rgb(252,252,252)] rounded-lg">
               <thead>
                  <th class="p-2">Id</th>
                  <th class="p-2">Hospital Name</th>
                  <th class="p-2">Address</th>
                  <th class="p-2">City</th>
                  <th class="p-2">Country</th>
                  <th class="p-2">Actions</th>
               </thead>
               <tbody class="rounded-b-md">
                  <?php
                  include './conn.php';

                  $sql = "SELECT * FROM hospitals;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr class="last:rounded-b-md ' . ($hl === $row['id'] ? 'bg-gray-100' : '') . '">
                                    <td class="text-center py-2 px-1">' . $row['id'] . '</td>
                                    <td class="text-center py-2 px-1">' . $row['hospital_name'] . '</td>
                                    <td class="text-center py-2 px-1">' . $row['address'] . '</td>
                                    <td class="text-center py-2 px-1">' . $row['city'] . '</td>
                                    <td class="text-center py-2 px-1">' . $row['country'] . '</td>
                                    <td class="text-center">
                                       <button title="Edit" class="px-2 mr-2 py-0.5 rounded-md bg-light-cyan hover:bg-cyan-200 transition" @click="modal = true;
                                       deleteData = {};
                                       newHospital = false;
                                       editData = {
                                          id: ' . htmlspecialchars($row['id']) . ',
                                          hospital_name: \'' . htmlspecialchars($row['hospital_name']) . '\',
                                          address: \'' . htmlspecialchars($row['address']) . '\',
                                          city: \'' . htmlspecialchars($row['city']) . '\',
                                          country: \'' . htmlspecialchars($row['country']) . '\'
                                       }">
                                          <i class="bi bi-pencil-square"></i>
                                       </button>
                                       <button title="Delete" class="px-2 py-0.5 rounded-md bg-red-100 hover:bg-red-300 transition" @click="modal=true; newHospital=false; editData={}; deleteData={ id: ' . $row['id'] . ' , hospital_name: \'' . $row['hospital_name'] . '\'}">
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