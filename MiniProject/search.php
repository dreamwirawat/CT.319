<?php

include "database_connection.php";

$searchText = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT location.*, user.username FROM location
        INNER JOIN user ON location.user_id = user.id
        WHERE location.name_location LIKE '%$searchText%'
        OR location.province LIKE '%$searchText%' 
        ORDER BY location.id DESC";

$result = mysqli_query($conn, $sql);

$searchResults = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $searchResults[] = [
            'name_location' => $row["name_location"],
            'province' => $row["province"],
            'username' => $row["username"],
            'details' => $row["details"],
            'img_data' => $row["img_data"]
        ];
    }
}

mysqli_close($conn);

echo json_encode($searchResults);
?>

