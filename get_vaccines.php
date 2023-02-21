<?php
include './conn.php';

if (isset($_GET['h_id'])) {
    $h_id = trim($_GET['h_id']);

    $sql = "SELECT * FROM vaccines WHERE hospital_id = $h_id;";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            $data = [];
            $i = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $data[$i] = $row;
                $i++;
            }
            echo json_encode($data);
        } else {
            echo json_encode(['msg' => 'no children']);
        }
    } else {
        echo json_encode(['h_id' => $h_id]);
    }
}
