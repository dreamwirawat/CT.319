<?php

    include "database_connection.php";

    session_start();

        $sql = "SELECT location.id, location.name_location, location.province, location.details, user.username, location.img_data
                FROM location
                INNER JOIN user ON location.user_id = user.id
                ORDER BY location.id DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = array();

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "ไม่พบข้อมูล";
        }

        $conn->close();
?>