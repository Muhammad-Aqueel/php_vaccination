<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PHP Vaccination System</title>
   <link rel="stylesheet" href="./dist/style.css">
   <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="text-gunmetal" :class="modal ? 'overflow-y-scroll fixed' : 'overflow-y-auto static'" x-data="{ modal: false, register: false, login: false, isAlert: '<?= isset($_GET['msg']) ?>' }">
   <div class="bg-black/40 backdrop-blur-sm transition flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

      <div class="p-8 w-fit rounded-xl shadow-lg bg-white" @keyup.escape.window="modal = false" @click.outside="modal = false" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">
         <template x-if="login">
            <form action="handle_login.php" method="POST" class="flex flex-col items-center justify-center gap-3">
               <h2 class="font-bold text-4xl text-center mb-6">Login</h2>
               <input type="text" name="username" placeholder="Username" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
               <input type="password" name="password" placeholder="Password" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">

               <button type="submit" class="outline-none bg-bdazzled-blue/90 text-light-cyan w-1/4 px-3 py-1.5 rounded-full focus:bg-bdazzled-blue hover:bg-bdazzled-blue transition">
                  Login
               </button>
            </form>
         </template>

         <template x-if="register">
            <form action="register/st1.php" method="POST" class="flex flex-col items-center justify-center gap-3">
               <h2 class="font-bold text-4xl text-center mb-6">Register</h2>
               <div class="flex flex-col gap-1">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" placeholder="Username" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
               </div>
               <div class="flex flex-col gap-1">
                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" placeholder="Password" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
               </div>
               <div class="flex flex-col gap-1">
                  <label for="usertype">User Type</label>
                  <select name="usertype" id="usertype" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                     <option value="parent">Parent</option>
                     <option value="hospital">Hospital</option>
                  </select>
               </div>

               <button type="submit" class="outline-none bg-bdazzled-blue/90 text-light-cyan w-1/4 px-3 py-1 rounded-full focus:bg-bdazzled-blue hover:bg-bdazzled-blue transition">
                  Continue
               </button>
            </form>
         </template>
      </div>

   </div>
<!-- x-effect="window.history.pushState('home', document.title, '/php-vaccination/');" -->
   <div x-transition x-show="isAlert" class="<?= isset($_GET['msg']) ? '' : 'hidden' ?> fixed bottom-8 right-8 rounded-md shadow-md text-xl px-6 py-3 bg-green-500 text-white capitalize">
      <?= htmlspecialchars($_GET['msg']) ?>
      <i class="bi bi-x-lg text-lg cursor-pointer ml-4" @click="isAlert = false"></i>
   </div>

   <nav class="px-8 py-4 shadow-md sticky z-40 top-0 bg-bdazzled-blue/80 text-white backdrop-blur-sm md:text-lg flex items-center justify-between">
      <div class="flex items-center">
         <div class="bg-gray-200 mr-2 h-10 rounded-full inline-block w-10 p-1">
            <img src="./img/logo.png" class="w-full h-full" alt="">
         </div>
         <a href="#" class="font-semibold text-xl">
            Vaccinate me
         </a>
      </div>
      <div class="flex items-center gap-3 font-medium">
         <a href="#about" class="inline-block">About Us</a>
         <?php if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) { ?>
            <a href="./dashboard.php" class="inline-block">Dashboard</a>
         <?php } else { ?>
            <button @click="modal = true; register = false; login = true;" class="cursor-pointer" id="loginBtn">
               Login
            </button>
            <button @click="modal = true; register = true; login = false;" class="cursor-pointer">
               Register
            </button>
         <?php } ?>
      </div>
   </nav>

   <div class="grid grid-cols-2">
      <div class="py-32 pl-20">
         <h1 class="font-black text-5xl">Vaccinate Smartly</h1>
         <h5 class="mt-1 text-lg text-gray-800 w-4/5">See vaccination reports, book you appointments according to your time and more...</h5>
         <div class="mt-4 flex gap-5 items-center">
            <button @click="modal = true; register = true; login = false;" class="bg-burnt-sienna transition text-white px-4 py-2 rounded hover:bg-burnt-sienna-2">
               Get Started
            </button>
            <span class="text-lg">OR</span>
            <button @click="modal = true; register = false; login = true;" class="bg-bdazzled-blue transition text-white px-4 py-2 rounded hover:bg-bdazzled-blue-2">
               Login
            </button>
         </div>
      </div>
      <div class="bg-[url(/php-vaccination/img/vaccine-image.png)] bg-contain bg-center bg-no-repeat h-full w-full" alt="Image"></div>
   </div>

   <div class="flex items-center px-20">
      <div class="bg-burnt-sienna/90 w-4 h-4 rounded-full"></div>
      <div class="flex-grow h-1 rounded-r-md bg-gradient-to-r from-burnt-sienna-2/80 -ml-1"></div>
   </div>

   <div class="px-20 py-28">
      <h3 class="text-3xl font-black">How it works</h3>
      <h6 class="text-gray-700 mb-5">Simple and easy 5-step process</h6>
      <div class="flex items-center justify-around relative mb-3.5">
         <div class="absolute top-1/2 -translate-y-1/2 bg-burnt-sienna/30 -z-10 left-1/2 -translate-x-1/2 h-1 w-[80%]"></div>
         <div class="bg-burnt-sienna w-7 flex items-center justify-center font-bold text-white text-sm h-7 rounded-full">1</div>
         <div class="bg-burnt-sienna w-7 flex items-center justify-center font-bold text-white text-sm h-7 rounded-full">2</div>
         <div class="bg-burnt-sienna w-7 flex items-center justify-center font-bold text-white text-sm h-7 rounded-full">3</div>
         <div class="bg-burnt-sienna w-7 flex items-center justify-center font-bold text-white text-sm h-7 rounded-full">4</div>
         <div class="bg-burnt-sienna w-7 flex items-center justify-center font-bold text-white text-sm h-7 rounded-full">5</div>
      </div>
      <ol class="grid grid-cols-5 gap-4 text-lg">
         <li class="bg-burnt-sienna-2/10 p-3 rounded-md">
            <span class="text-burnt-sienna underline cursor-pointer" @click="modal = true; register = true; login = false;">Register</span> or <span class="text-burnt-sienna underline cursor-pointer" @click="modal = true; register = false; login = true;">Login</span> to your account
         </li>
         <li class="bg-burnt-sienna-2/30 p-3 rounded-md">
            Add your children details
         </li>
         <li class="bg-burnt-sienna-2/50 px-3 pt-3 pb-12 rounded-md">
            Book an appointment for vaccination
         </li>
         <li class="bg-burnt-sienna-2/70 p-3 rounded-md">
            Get your child vaccinated on the approved date
         </li>
         <li class="bg-burnt-sienna-2/90 p-3 rounded-md">
            Check vaccine report
         </li>
      </ol>
   </div>

   <div class="flex items-center px-20">
      <div class="flex-grow h-1 rounded-r-md bg-gradient-to-l from-burnt-sienna-2/80 -ml-1"></div>
      <div class="bg-burnt-sienna/90 w-4 h-4 rounded-full"></div>
   </div>

   <div class="grid grid-cols-2 scroll-mt-4" id="about">
      <div class="bg-[url(/php-vaccination/img/about-us.png)] bg-center bg-[length:80%] bg-no-repeat h-full w-full" alt="Image"></div>
      <div class="py-20 pr-20">
         <h2 class="font-black text-4xl text-burnt-sienna">About Us</h2>
         <div class="mt-1 text-gray-800 w-4/5">
            <p class="mb-1">
               Welcome to Vaccinate Me, the leading e-vaccination system designed to make the vaccination process as convenient and efficient as possible.
            </p>
            <p class="mb-1">
               At Vaccinate Me, we understand the importance of getting vaccinated to protect yourself and your community. That's why we have developed a platform that allows school going and other children to easily schedule and receive their vaccinations online in the safest way. Our platform streamlines the scheduling process and provides real-time updates on vaccine availability and appointment availability, so you can get vaccinated as soon as possible.
            </p>
            <p class="mb-1">
               But we don't just stop at providing a convenient scheduling system. We are also committed to ensuring that our users have access to the most up-to-date information on vaccines and the vaccination process. Our team of experts is constantly working to provide you with the latest information and resources to help you make informed decisions about your health.
            </p>
            <p class="mb-1">
               Thank you for choosing Vaccinate Me for your vaccination needs. We look forward to serving you and helping to keep you healthy and safe.
            </p>
         </div>
      </div>
   </div>

   <div class="mx-4">
      <footer class="flex items-center justify-between gap-3 py-6 px-8 rounded-lg bg-light-cyan mb-2">
         <a href="#" class="bg-gray-50 mr-2 h-12 w-12 rounded-full inline-block p-1">
            <img src="./img/logo.png" class="w-full h-full" alt="">
         </a>
         <div>
            <i class="bi bi-c-circle"></i> Vaccinate Me | All Rights Reserved.
         </div>
         <div class="flex gap-4 items-center">
            <i class="bi text-lg bi-facebook cursor-pointer"></i>
            <i class="bi text-lg bi-instagram cursor-pointer"></i>
            <i class="bi text-lg bi-twitter cursor-pointer"></i>
         </div>
      </footer> This website is made by talha

   </div>
</body>

</html>