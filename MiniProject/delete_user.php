<?php

    include "database_connection.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM user WHERE id=$id";

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
