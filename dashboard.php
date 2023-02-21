<?php
include './login_logic.php';
if (!isset($_SESSION))
   session_start();
if ($_SESSION['usertype'] === 'hospital') {
   header("location: vaccines.php");
}
if ($_SESSION['usertype'] === 'parent') {
   header("location: parents_dashboard.php");
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
   <div class="min-h-screen text-gunmetal" x-data="{ loading: false, childDetailBar: false, parentId: 0, childrenData: [] }" x-effect="if (parentId > 0) {
         loading = true;
         axios.get(`/php-vaccination/get_children.php?parent_id=${parentId}`).then(res => {
            childrenData = res.data;
            loading = false;
         })
      }">

      <div class="bg-black/40 transition flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="childDetailBar" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

         <div class="h-[40%] p-5 w-2/5 rounded-lg shadow-lg bg-slate-100" @keyup.escape.window="childDetailBar=false; parentId = 0" @click.outside="childDetailBar = false; parentId = 0" x-show="childDetailBar" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">

            <template x-if="loading">
               <div class="flex flex-col gap-2.5">
                  <div class="h-10 mx-20 mb-2 rounded-md bg-slate-300 animate-pulse"></div>
                  <div class="h-8 rounded-md bg-slate-300 animate-pulse"></div>
                  <div class="h-8 rounded-md bg-slate-300 animate-pulse"></div>
                  <div class="h-8 rounded-md bg-slate-300 animate-pulse"></div>
               </div>
            </template>

            <template x-if="!loading && childrenData.msg">
               <div class="flex items-center justify-center h-full">
                  <h4 class="text-3xl font-light text-gray-800 capitalize">
                     No children data found
                  </h4>
               </div>
            </template>

            <template x-if="!loading && !childrenData.msg">
               <div>
                  <h4 class="text-2xl mb-4 font-semibold capitalize text-center">
                     Children Details
                  </h4>
                  <table class="w-full">
                     <thead>
                        <tr>
                           <th>Firstname</th>
                           <th>Lastname</th>
                           <th>Date of birth</th>
                        </tr>
                     </thead>
                     <tbody>
                        <template x-for="child in childrenData">
                           <tr class="">
                              <td x-text="child.firstname" class="text-center px-4 py-1"></td>
                              <td x-text="child.lastname" class="text-center px-4 py-1"></td>
                              <td x-text="child.dateofbirth" class="text-center px-4 py-1"></td>
                           </tr>
                        </template>
                     </tbody>
                  </table>
               </div>
            </template>
         </div>

      </div>
      <?php include './nav.php' ?>
      <div class="h-full grid grid-cols-6 px-5 gap-5">
         <?php include './sidenav.php' ?>
         <div class="col-span-5 h-full">
            <h3 class="text-3xl font-semibold mt-5 mb-2">All Parents</h3>
            <table class="w-full bg-gray-100 rounded-md">
               <thead>
                  <th class="p-2">Id</th>
                  <th class="p-2">Parent Name</th>
                  <th class="p-2">Date Of Birth</th>
               </thead>
               <tbody class="rounded-b-md">
                  <?php
                  include './conn.php';

                  $sql = "SELECT * FROM parents;";
                  $res = mysqli_query($conn, $sql);

                  if ($res) {
                     if (mysqli_num_rows($res) > 0) {
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                           $i++;
                           echo '<tr :class="parentId === ' . $row['id'] . ' ? \'bg-gray-100\' : \'\'" x-on:click="childDetailBar = true; parentId = ' . $row['id'] . '" class="cursor-pointer last:pb-1">
                                    <td class="text-center p-1">' . $row['id'] . '</td>
                                    <td class="text-center p-1">' . $row['parent_name'] . '</td>
                                    <td class="text-center p-1">' . $row['dateofbirth'] . '</td>
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