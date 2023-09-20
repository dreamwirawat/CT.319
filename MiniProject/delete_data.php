<?php

    include "database_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "miniprojectct319";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
        }

        $sql = "DELETE FROM location WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "ลบข้อมูลสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "ไม่พบข้อมูลสำหรับการลบ";
    }
?>
