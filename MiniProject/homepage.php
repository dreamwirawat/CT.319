<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/modalDetails.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="js/index.js"></script>    
    <script src="https://kit.fontawesome.com/2dad7caf54.js" crossorigin="anonymous"></script>
    <title>โบราณสถาน</title>
</head>

<body>
    <?php
        include 'database_connection.php'; 

        session_start();

        if (!isset($_SESSION["username"])) {
            header("Location: login.php");
            exit();
        }

        $loggedInUsername = $_SESSION['username']; 

        $query = "SELECT username FROM user WHERE username='$loggedInUsername'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $usernameFromDatabase = $row["username"];
        }

        $sql = "SELECT role FROM user WHERE username = '$loggedInUsername'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $role = $row['role'];
        } else {
            $role = 'unknown';
        }

        mysqli_close($conn);
    ?>

    <main>

        <div class="top_bar">
            <div class="allbut">
                <div class="manage">
                    <?php if ($role === 'user'): ?>
                        <button id="manageData" onclick="window.location.href = 'manage.php';">จัดการข้อมูล</button>
                    <?php elseif ($role === 'admin'): ?>
                        <button id="manageDataAdmin" onclick="window.location.href = 'manageAdmin.php';">จัดการข้อมูล (Admin)</button>
                    <?php endif; ?>
                </div>
                <div class="search">
                    <div class="searchBox">
                        <div class="searhIn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input id="searchInput" type="text" placeholder="ค้นหาทั้งหมด">
                        </div>
                        <button id="searchButton" type="button">ค้นหา</button>
                    </div>
                    <div id="searchResults"></div>
                    <div class="selectTypeBox">
                        <select name="provinceSelect" id="typeCW" onchange="filterByProvince()">
                            <option value="0" selected>ทุกจังหวัด</option>
                        </select>
                    </div>

                </div>
                <div class="login">
                    <div class="shownameLog"><b><?php echo $usernameFromDatabase; ?></b></div>
                    <form id="logoutForm" action="logout.php" method="post">
                        <button id="logoutButton" type="submit">ออกจากระบบ</button>
                        <input type="hidden" name="logout" value="1">
                    </form>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="bar">
                <div class="buttonAdd">
                    <button type="button" id="addNewButton" onclick="addNewData()">เพิ่มข้อมูลโบราณสถาน</button>
                </div>
                <div class="valueDatas">
                    <a>ทั้งหมด</a>
                    <a id="valueLocation"></a>
                    <a>สถานที่</a>
                </div>
            </div>

            <div id="modalAddnew" class="modalAddnew">
                <div id="modalAddData" class="modalAddData">
                    <div class="modalTop">
                        <span class="closeHidden">&times;</span>
                        <a>เพิ่มข้อมูลโบราณสถาน</a>
                        <span class="close" onclick="closeModalAddnew()">&times;</span>
                    </div>
                    <div class="modalContent">
                        <form id="addLocationForm" action="insert_location.php" method="post" enctype="multipart/form-data">
                            <div class="nameBox">
                                <a>ชื่อโบราณสถาน :</a><br>
                                <input name="nameLocation" id="nameLocation" class="form-control" type="text" required>
                            </div>
                            <div class="provinceBox">
                                <a>จังหวัด :</a><br>
                                <input name="province" id="province" class="form-control" type="text" required>
                            </div>
                            <div class="detailsBox">
                                <a>รายละเอียด :</a><br>
                                <textarea name="details" id="details" class="form-control"></textarea>
                            </div>
                            <div class="imgBox">
                                <a>รูป :</a><br>
                                <input type="file" name="imgFile" id="imgFile" accept="image/*" required>
                            </div>
                            <div class="modalFooter">
                                <div class="addnewButton">
                                    <button id="addnewButton" type="submit">เพิ่มข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="dataBox" id="searchResultsContainer">

            </div>

            <div id="modalDetailsLocation" class="modalDetailsLocation" >
                <div id="modalDetails" class="modalDetails">
                    <div class="modalTop">
                        <b>ชื่อโบราณสถาน</b>
                        <span class="close" onclick="closeModalDetails()">&times;</span>
                    </div>
                    <div class="province">
                        <b id="provinceDetails">จังหวัด :</b>
                    </div>
                    <div class="user">
                        <a id="userDetails">เพิ่มข้อมูลโดย :</a>
                    </div>
                    <div class="imgBox">
                        <img src="" alt="">
                    </div>
                    <div class="details">
                        <textarea class="dataDetail" id="dataDetail" rows="7" disabled></textarea>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php

        include 'database_connection.php'; 

        $sql = "SELECT COUNT(*) as count FROM location";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $rowCount = $row["count"];
            echo '<script>document.getElementById("valueLocation").textContent = "' . $rowCount . '";</script>';
        } else {
            echo "ไม่พบข้อมูลในตาราง location";
        }

        $conn->close();
    ?>
    <script>
        document.getElementById("searchButton").addEventListener("click", function () {
            var searchText = document.getElementById("searchInput").value;
            searchInDatabase(searchText);
        });
    </script>
</body>
</html>