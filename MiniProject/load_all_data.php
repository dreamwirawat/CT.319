<?php

    include "database_connection.php";

    $query = "SELECT location.*, user.username 
            FROM location 
            INNER JOIN user ON location.user_id = user.id
            ORDER BY location.id DESC"; 

    $result = mysqli_query($conn, $query);

    if ($result) {
        $allResults = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $allResults[] = $row;
        }
        echo json_encode($allResults);
    } else {
        echo json_encode(array()); 
    }

    mysqli_close($conn);
?>

