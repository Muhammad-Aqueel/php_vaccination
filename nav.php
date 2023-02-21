<?php include_once './get_name.php' ?>
<nav class="flex items-center justify-between bg-bdazzled-blue text-white px-8 py-4 mb-4">
   <h1 class="text-2xl font-bold">
      <a href="/php-vaccination">Vaccinate Me</a>
   </h1>
   <div class="relative" x-data="{ open: false }">
      <button :class="open ? 'bg-[#e5e7eb] text-bdazzled-blue' : 'bg-bdazzled-blue/40 hover:bg-bdazzled-blue-2 text-[#e5e7eb]'" class="rounded-full active:scale-95 border flex items-center justify-center w-fit h-8 px-4 transition-transform outline-none" x-on:click="open = !open">
         <?= $display_name ?>
         <i class="bi bi-chevron-down leading-3 ml-1.5"></i>
      </button>
      <div @click.outside="open = false" @keyup.escape.window="open = false" class="absolute top-[110%] p-2 right-0 rounded-md shadow-xl border-t border-[rgb(70,100,139)] bg-bdazzled-blue" x-show="open" x-transition>
         <ul class="flex flex-col gap-1 min-w-[10rem]">
            <li class="px-3 py-1 bg-bdazzled-blue hover:bg-bdazzled-blue-2 transition capitalize rounded cursor-pointer">
               <i class="bi bi-house-door"></i>
               Home
            </li>
            <!-- <li class="px-3 py-1 bg-bdazzled-blue hover:bg-bdazzled-blue-2 transition capitalize rounded cursor-pointer">
               <i class="bi bi-person"></i>
               Account
            </li> -->
            <li class="bg-bdazzled-blue hover:bg-bdazzled-blue-2 transition capitalize rounded cursor-pointer">
               <a class="inline-block px-3 py-1 w-full" href="handle_logout.php">
                  <i class="bi bi-box-arrow-left"></i>
                  Logout
               </a>
            </li>
         </ul>
      </div>
   </div>
</nav>