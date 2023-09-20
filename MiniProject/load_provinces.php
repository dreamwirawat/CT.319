<?php

    include "database_connection.php";

    $query = "SELECT DISTINCT province FROM location
            ORDER BY location.id DESC";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $provinces = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $provinces[] = $row["province"];
        }
        echo json_encode($provinces);
    } else {
        echo json_encode(array()); 
    }

    mysqli_close($conn);
?>
