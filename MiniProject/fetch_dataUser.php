<?php

    include "database_connection.php";
    
    session_start();
    $loggedInUsername = $_SESSION["username"];

    $sql = "SELECT user.id, user.username, user.name, user.surname, user.email, user.role
            FROM user WHERE username='$loggedInUsername'";

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
