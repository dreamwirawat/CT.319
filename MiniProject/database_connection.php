<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "miniprojectct319";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }
?>
