<?php
include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // { ["id"]=> string(1) "2" ["username"]=> string(5) "admin" ["password"]=> string(60) "$2y$10$2iWiXgQdMU7A2Zhw7sjlZeUkuu1Eq9JQLccLxSKCcCiJj.E3.4MoS" ["usertype"]=> string(5) "admin" ["isactive"]=> string(1) "1" }
    
    // { ["id"]=> string(1) "1" ["hospital_name"]=> string(19) "New Street Hospital" ["address"]=> string(16) "1234, Old Street" ["city"]=> string(6) "Munich" ["country"]=> string(7) "Germany" ["user_id"]=> string(1) "4" }
    $usertype = $_POST['usertype'];

    if ($usertype === "parent" or $usertype === "hospital") {
        $username = $_POST['username'];
        $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "SELECT username FROM users WHERE username = '$username';";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            if (mysqli_num_rows($res) === 0) {
                $sql2 = "INSERT INTO users(`username`, `password`, `usertype`) VALUES('$username', '$password_hash', '$usertype');";
                $res2 = mysqli_query($conn, $sql2);

                if ($res2) {
                    $user_id = mysqli_insert_id($conn);

                    session_start();
                    $_SESSION['step_one'] = true;
                    $_SESSION['register_usertype'] = $usertype;
                    $_SESSION['user_id'] = $user_id;

                    header("location: ../register_redirect.php");
                } else {
                    header("location: ../index.php?msg=something+went+wrong");
                }
            } else {
                header("location: ../index.php?msg=username+already+exists");
            }
        }
    }
}
