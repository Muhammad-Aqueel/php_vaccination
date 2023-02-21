<?php
include './conn.php';
session_start();
if ($_SESSION['step_one'] !== true) {
    header("location: index.php?msg=complete+step+one");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="./dist/style.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div class="h-screen flex items-center justify-center bg-bdazzled-blue">
        <?php if ($_SESSION['register_usertype'] === "parent") { ?>
            <form action="/php-vaccination/register/reg_parent.php" method="POST" class="bg-slate-200 p-8 rounded-xl flex flex-col gap-2 items-center shadow-xl">
                <h1 class="text-2xl font-semibold w-full mb-2">One more step...</h1>
                <input type="hidden" name="id" value="<?= $_SESSION['user_id'] ?>">
                <div class="flex flex-col gap-1">
                    <label for="fullname">Full Name</label>
                    <input type="text" name="fullname" id="fullname" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="dateofbirth">Date Of Birth</label>
                    <input type="date" name="dateofbirth" id="dateofbirth" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                </div>

                <button type="submit" class="outline-none bg-bdazzled-blue/90 text-light-cyan w-1/4 px-3 py-1.5 rounded-full focus:bg-bdazzled-blue hover:bg-bdazzled-blue transition">
                    Register
                </button>
            </form>
        <?php } ?>
        <?php if ($_SESSION['register_usertype'] === "hospital") { ?>
            <form action="/php-vaccination/register/reg_hospital.php" method="POST" class="bg-slate-50 p-8 rounded-md flex flex-col gap-2 items-center">
                <h1 class="text-2xl font-semibold w-full mb-2">One more step...</h1>
                <input type="hidden" name="id" value="<?= $_SESSION['user_id'] ?>">
                <div class="flex flex-col gap-1">
                    <label for="hospital_name">Hospital Name</label>
                    <input type="text" name="hospital_name" id="hospital_name" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/70 focus:border-bdazzled-blue outline-none transition">
                </div>

                <button type="submit" class="outline-none bg-bdazzled-blue/90 text-light-cyan w-1/4 px-3 py-1.5 rounded-full focus:bg-bdazzled-blue hover:bg-bdazzled-blue transition">
                    Register
                </button>
            </form>
        <?php } ?>
    </div>
</body>

</html>