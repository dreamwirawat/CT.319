<?php
    include "database_connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nameEdit = $_POST["nameEdit"];
        $provEdit = $_POST["provEdit"];
        $detEdit = $_POST["detEdit"];
        $rowId = $_POST["rowId"];

        if (isset($nameEdit) && $nameEdit !== null) {
            $sql = "UPDATE location SET name_location='$nameEdit' WHERE id=$rowId";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($provEdit) && $provEdit !== null) {
            $sql = "UPDATE location SET province='$provEdit' WHERE id=$rowId";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($detEdit) && $detEdit !== null) {
            $sql = "UPDATE location SET details='$detEdit' WHERE id=$rowId";
            if ($conn->query($sql) !== TRUE) {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
            }
        }

        if (isset($_FILES['imgFileEdit']) && $_FILES['imgFileEdit']['error'] === UPLOAD_ERR_OK) {
            $uploadPath = $uploadDir . basename($_FILES['imgFileEdit']['name']);
                
            if (move_uploaded_file($_FILES['imgFileEdit']['tmp_name'], $uploadPath)) {
                $sql = "UPDATE location SET img_data='$uploadPath' WHERE id=$rowId";
                if ($conn->query($sql) !== TRUE) {
                    echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
                }
            } else {
                echo "อัพโหลดรูปภาพล้มเหลว";
            }
        }

        $conn->close();
        
    } else {
        echo "ไม่พบข้อมูลสำหรับการอัปเดต";
    }
?>
