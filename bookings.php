<?php
include './conn.php';
include './get_vaccinated_status.php';
include './get_name.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['isloggedin']) or $_SESSION['isloggedin'] !== true or $_SESSION['usertype'] !== "parent") {
    header("location: index.php");
}
if (!isset($_SESSION))
    session_start();
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
    <div class="min-h-screen text-gunmetal" x-data="{ modal: false, dataLoad: false, hospitalId: 0, vaccineData: [] }">

        <div class="bg-black/40 transition flex items-center justify-center h-screen w-screen fixed z-50 top-0 left-0" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="p-8 w-fit rounded-xl shadow-lg bg-white" @keyup.escape.window="modal = false" @click.outside="modal = false" x-show="modal" x-transition:enter="transition ease-out" x-transition:enter-start="scale-90" x-transition:enter-end="scale-100" x-transition:leave="transition ease-in" x-transition:leave-start="scale-100" x-transition:leave-end="scale-90">

                <form action="new_booking.php" method="POST" class="flex flex-col gap-3">
                    <h4 class="text-2xl text-center font-medium mb-2">New Booking</h4>
                    <input type="hidden" name="parent" value="<?= $p_id ?>">
                    <div class="flex flex-col gap-1">
                        <label for="child" class="pl-2 capitalize text-sm text-gray-700">Select Child</label>
                        <select required name="child" id="child" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                            <option value="0">Select</option>
                            <?php

                            $sql = "SELECT * FROM children WHERE parent = $p_id;";
                            $res = mysqli_query($conn, $sql);

                            if ($res) {
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo '<option value="' . $row['id'] . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="hospital" class="pl-2 capitalize text-sm text-gray-700">Select Hospital</label>
                        <select required x-bind:disabled="dataLoad" name="hospital" x-model="hospitalId" id="hospital" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition" x-on:change="
                            if (hospitalId > 0) {
                                dataLoad = true;
                                axios.get(`/php-vaccination/get_vaccines.php?h_id=${hospitalId}`)
                                    .then(res => {
                                        if (res.data?.length > 0) {
                                            vaccineData = res.data
                                        }
                                    })
                                dataLoad = false;
                            } else {
                                vaccineData = []
                            }
                        ">
                            <option value="0">Select</option>
                            <?php
                            include './conn.php';

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
                    <div class="flex flex-col gap-1" x-show="vaccineData?.length > 0">
                        <label for="vaccine" class="pl-2 capitalize text-sm text-gray-700">Choose Vaccine</label>
                        <select required x-bind:disabled="(vaccineData?.length === 0) || (dataLoad === true)" name="vaccine" id="vaccine" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 disabled:opacity-60 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                            <template x-for="vaccine in vaccineData">
                                <option x-bind:value="vaccine.id" x-text="vaccine.vaccine_name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="date" class="pl-2 capitalize text-sm text-gray-700">Choose date and time</label>
                        <input type="date" name="date" id="date" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 disabled:opacity-60 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                        <input type="time" name="time" id="time" class="w-[28rem] block px-4 py-2 rounded-t border-b-2 disabled:opacity-60 bg-light-cyan/60 focus:border-bdazzled-blue outline-none transition">
                    </div>
                    <div class="flex items-center justify-end gap-3 mt-2">
                        <button type="button" @click="modal=false" class="rounded active:scale-95 transition text-bdazzled-blue hover:bg-gray-100 px-3 py-1">
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </button>
                        <button type="submit" class="rounded bg-bdazzled-blue hover:bg-bdazzled-blue-2 active:scale-95 transition text-white px-3 py-1">
                            <i class="bi bi-check-circle"></i>
                            Book
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <?php include './nav.php' ?>

        <div class="h-full grid grid-cols-6 px-5 gap-5">
            <?php include './sidenav.php' ?>
            <div class="col-span-5 h-full">
                <button @click="modal = true; console.log('abcd')" class="block ml-auto mr-2 px-4 transition active:scale-95 py-1.5 rounded bg-burnt-sienna text-white mb-2.5">
                    <i class="bi bi-plus-circle"></i>
                    New Booking
                </button>
                <table class="w-full bg-[rgb(252,252,252)] rounded-lg">
                    <thead>
                        <th class="p-2">Child Name</th>
                        <th class="p-2">Vaccine</th>
                        <th class="p-2">Time</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Status</th>
                        <th class="p-2">Vaccination Report</th>
                    </thead>
                    <tbody class="rounded-b-md">
                        <?php
                        function giveStatus($no)
                        {
                            switch ($no) {
                                case 0:
                                    return 'pending';
                                case 1:
                                    return 'approved';
                                case 2:
                                    return 'rejected';
                                case 3:
                                    return 'completed';
                            }
                        }

                        $sql3 = "SELECT bookings.vaccinated_status, bookings.responded, bookings.booking_date, bookings.booking_time, vaccines.vaccine_name, children.firstname, children.lastname FROM bookings JOIN vaccines ON vaccines.id = bookings.vaccine_id JOIN children ON bookings.child_id = children.id WHERE parent_id = $p_id;";
                        $res3 = mysqli_query($conn, $sql3);

                        if ($res3) {
                            if (mysqli_num_rows($res3) > 0) {
                                $i = 0;
                                while ($row = mysqli_fetch_assoc($res3)) {
                                    $i++;
                                    echo '<tr class="last:rounded-b-md">
                                            <td class="text-center p-1">' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                                            <td class="text-center p-1">' . $row['vaccine_name'] . '</td>
                                            <td class="text-center p-1">' . $row['booking_time'] . '</td>
                                            <td class="text-center p-1">' . $row['booking_date'] . '</td>
                                            <td class="text-center p-1 capitalize">' . giveStatus((int)$row['responded']) . '</td>
                                            <td class="text-center p-1 ' .
                                        ($row['vaccinated_status'] == 0 ? 'bg-green-100' : ($row['vaccinated_status'] == 1 ? 'bg-red-100' : ($row['vaccinated_status'] == -1 ? 'bg-yellow-50' : ''))) .
                                        '">' . get_vaccinated_status($row['vaccinated_status']) . '<i class="' . ($row['vaccinated_status'] == 0 ? 'text-green-600 bi-check-circle-fill' : ($row['vaccinated_status'] == 1 ? 'text-red-600 bi-exclamation-circle-fill' : '')) . ' bi ml-2"></i></td>
                                        </tr>';
                                }
                            } else {
                                echo '<tr>
                                        <td colspan="6" class="px-3 py-2 text-lg text-center font-medium bg-yellow-50 text-yellow-600">
                                            No bookings
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