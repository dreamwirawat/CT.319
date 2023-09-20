<?php

    include "database_connection.php";

    session_start();

        $user_id = $_SESSION['user_id']; 

        $sql = "SELECT id, name_location, province, details, img_data FROM location
                WHERE user_id = $user_id
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