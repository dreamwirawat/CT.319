<?php
    include "database_connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nameUsername = $_POST["nameUsername"];
        $nameUser = $_POST["nameUser"];
        $surnameEdit = $_POST["surnameEdit"];
        $emailEdit = $_POST["emailEdit"];
        $passwordEdit = $_POST["passwordEdit"];
        $idUser = $_POST["idUser"];

        if ($conn->connect_error) {
            die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
        }

        if (isset($nameUsername) && $nameUsername !== null) {

            $sql = "UPDATE user SET username='$nameUsername' WHERE id='$idUser'";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($nameUser) && $nameUser !== null) {
            $sql = "UPDATE user SET name='$nameUser' WHERE id='$idUser'";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($surnameEdit) && $surnameEdit !== null) {
            $sql = "UPDATE user SET surname='$surnameEdit' WHERE id='$idUser'";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($emailEdit) && $emailEdit !== null) {
            $sql = "UPDATE user SET email='$emailEdit' WHERE id='$idUser'";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($passwordEdit) && $passwordEdit !== null) {
            $hashedPassword = password_hash($passwordEdit, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET password='$hashedPassword' WHERE id='$idUser'";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "ไม่พบข้อมูลสำหรับการอัปเดต";
    }
?>
