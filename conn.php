<?php
$conn = mysqli_connect("localhost", "root", "", "defaultdb");

if (!$conn) {
    die("Unable to connect");
}
