<?php

    include "database_connection.php";

    $selectedProvince = $_GET["province"];

    $query = "SELECT location.*, user.username 
          FROM location 
          LEFT JOIN user ON location.user_id = user.id"; 

    if ($selectedProvince != "0") {
        $query .= " WHERE province = '$selectedProvince'";
    }

    $result = mysqli_query($conn, $query);


    if ($result) {
        $resultsArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resultsArray[] = $row;
        }
        echo json_encode($resultsArray);
    } else {
        echo json_encode(array()); 
    }

    mysqli_close($conn);
?>
