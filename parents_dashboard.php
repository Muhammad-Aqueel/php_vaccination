<?php
include './get_name.php';

if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if (!isset($_SESSION['isloggedin']) or $_SESSION['isloggedin'] !== true or $_SESSION['usertype'] !== "parent") {
   header("location: /php-vaccination?msg=please+login+first");
}
if ($_SESSION['usertype'] === 'hospital') {
   header("location: vaccines.php");
}
$p_id = $_SESSION['p_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Welcome <?= $display_name ?></title>
   <link rel="stylesheet" href="./dist/style.css">
   <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
   <div class="min-h-screen text-gunmetal" x-data="{ modal: false, editData: {}, addChild: false }">

      <div class="bg-black/40 transition flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

         <div class="p-8 w-fit rounded-xl shadow-lg bg-white" @keyup.escape.window="modal=false" @click.outside="modal = false" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">

            <template x-if="addChild">
               <form action="add_child.php" method="POST" class="flex flex-col gap-2">
                  <h4 class="text-2xl text-center font-medium mb-2">Add Child</h4>
                  <input type="hidden" name="p_id" value="<?= $p_id ?>">
                  <div class="flex flex-col gap-0.5">
                     <label for="firstname" class="pl-2 capitalize">First Name</label>
                     <input type="text" name="firstname" id="firstname" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="lastname" class="pl-2 capitalize">Last Name</label>
                     <input type="text" name="lastname" id="lastname" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="dateofbirth" class="pl-2 capitalize">Date Of Birth</label>
                     <input type="date" name="dateofbirth" id="dateofbirth" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex items-center justify-end gap-3 mt-2">
                     <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                     </button>
                     <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-3 py-1">
                        <i class="bi bi-check-circle"></i>
                        Add
                     </button>
                  </div>
               </form>
            </template>

            <template x-if="editData.id">
               <form action="edit_child.php" method="POST" class="flex flex-col gap-2">
                  <h4 class="text-2xl text-center font-medium mb-2">Edit Child Info</h4>
                  <input type="hidden" name="id" x-model="editData.id">
                  <div class="flex flex-col gap-0.5">
                     <label for="firstname" class="pl-2 capitalize">first name</label>
                     <input type="text" x-model="editData.firstname" name="firstname" id="firstname" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                  </div>
                  <div class="flex flex-col gap-0.5">
                     <label for="lastname" class="pl-2 capitalize">last name</label>
                     <input type="text" x-model="editData.lastname" name="lastname" id="lastname" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
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

         </div>

      </div>

      <?php include './nav.php' ?>

      <div class="h-full grid grid-cols-6 px-5 gap-5">
         <?php include './sidenav.php' ?>
         <div class="col-span-5 h-full">
            <button @click="modal = true; editData = {}; addChild = true" class="block ml-auto mr-2 px-4 transition active:scale-95 py-1.5 rounded bg-burnt-sienna text-white mb-2.5">
               <i class="bi bi-plus-circle"></i>
               Add Child
            </button>
            <table class="w-full bg-[rgb(252,252,252)] rounded-lg">
               <thead>
                  <th class="p-2">First Name</th>
                  <th class="p-2">Last Name</th>
                  <th class="p-2">Date Of Birth</th>
                  <th class="p-2">Actions</th>
               </thead>
               <tbody class="rounded-b-md">
                  <?php
                  include './conn.php';

                  $sql = "SELECT * FROM children WHERE parent = $p_id;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr class="last:rounded-b-md">
                                    <td class="text-center p-1">' . $row['firstname'] . '</td>
                                    <td class="text-center p-1">' . $row['lastname'] . '</td>
                                    <td class="text-center p-1">' . $row['dateofbirth'] . '</td>
                                    <td class="text-center p-1">
                                       <button @click="
                                       modal = true;
                                       addChild = false;
                                       editData = {
                                          id: \'' . $row['id'] . '\',
                                          firstname: \'' . $row['firstname'] . '\',
                                          lastname: \'' . $row['lastname'] . '\',
                                       };
                                       " class="text-sm bg-light-cyan hover:bg-cyan-200 px-2 py-0.5 rounded-md transition">
                                          <i class="bi bi-pencil-square"
                                       </button>
                                    </td>
                                 </tr>';
                        }
                     } else {
                        echo '<tr>
                                 <td colspan="4" class="bg-yellow-50 rounded-b-lg px-3 py-2 text-center text-lg font-medium text-yellow-600">
                                    No children data found
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