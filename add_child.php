<?php
include './conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dateofbirth = $_POST['dateofbirth'];
    $p_id = $_POST['p_id'];

    $sql = "INSERT INTO children(`firstname`, `lastname`, `dateofbirth`, `parent`) VALUES('$firstname', '$lastname', '$dateofbirth', $p_id);";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header("location: parents_dashboard.php?msg=info+added+successfully");
    } else {
        echo mysqli_error($conn);
        // header("location: hospitals.php?msg=an+error+occured");
    }
}
