<?php
    include "database_connection.php";

    session_start();

    $nameLocation = $_POST['nameLocation'];
    $province = $_POST['province'];
    $details = $_POST['details'];
    $user_id = $_SESSION['user_id'];  
    $imgData = '';  

    if (isset($_FILES['imgFile']) && $_FILES['imgFile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; 
        $uploadPath = $uploadDir . basename($_FILES['imgFile']['name']);
        
        if (move_uploaded_file($_FILES['imgFile']['tmp_name'], $uploadPath)) {
            $imgData = $uploadPath;
        } else {
            echo "อัพโหลดรูปภาพล้มเหลว";
        }
    }

    $sql = "INSERT INTO location (name_location, province, details, user_id, img_data)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("sssis", $nameLocation, $province, $details, $user_id, $imgData);
        
        if ($stmt->execute()) {
            header("Location: homepage.php");
        } else {
            echo "การเพิ่มข้อมูลล้มเหลว: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "เตรียมคำสั่ง SQL ล้มเหลว: " . $conn->error;
    }

    $conn->close();
?>
