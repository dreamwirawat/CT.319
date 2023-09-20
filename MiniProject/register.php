<?php

    include "database_connection.php";

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["usernameRegis"];
        $name = $_POST["nameRegis"];
        $surname = $_POST["surnameRegis"];
        $email = $_POST["emailRegis"];
        $password = password_hash($_POST["passwordRegis"], PASSWORD_DEFAULT);
        $role = "user";

        $sql = "INSERT INTO user (username, name, surname, email, password, role) VALUES ('$username', '$name', '$surname', '$email', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $username;

            header('Location: index.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>

