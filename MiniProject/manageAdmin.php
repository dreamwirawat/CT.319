<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/manageStylesAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="js/index.js"></script>    
    <script src="https://kit.fontawesome.com/2dad7caf54.js" crossorigin="anonymous"></script>
    <title>โบราณสถาน</title>
</head>

<body>
    <?php

        include "database_connection.php";

        session_start();

        if (!isset($_SESSION["username"])) {
            
            header("Location: login.php");
            exit();
        }

        $loggedInUsername = $_SESSION["username"];

        $query = "SELECT username,id FROM user WHERE username='$loggedInUsername'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $usernameFromDatabase = $row["username"];
            $id_user = $row["id"];
        }
   
        mysqli_close($conn);
    ?>

    <main>

        <div class="top_bar_manage">
            <div class="allbut">
                <div class="back">
                    <button id="backButton" onclick="window.location.href = 'homepage.php';">กลับ</button>
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
            <h4>จัดการข้อมูล</h4>
            <div class="selectType">
                <select name="typeSelect" id="typeSelect" onchange="">
                    <option value="0" selected>โบราณสถาน</option>
                    <option value="1" >ผู้ใช้งาน</option>
                </select>
            </div>
            <div class="manage">
                <table id="dataLocation">
                    <thead>
                        <th><b>ชื่อโบราณสถาน</b></th>
                        <th><b>จังหวัด</b></th>
                        <th><b>เพิ่มโดย</b></th>
                        <th><b>รายละเอียด</b></th>
                        <th><b>รูปภาพ</b></th>
                        <th><b>แก้ไข</b></th>
                        <th><b>ลบ</b></th>
                    </thead>
                    <tbody>
                    </tbody>
                    
                </table>

                <table id="dataUser">
                    <thead>
                        <th><b>ชื่อผู้ใช้งาน</b></th>
                        <th><b>ชื่อ</b></th>
                        <th><b>นามสกุล</b></th>
                        <th><b>อีเมล</b></th>
                        <th><b>สถานะ</b></th>
                        <th><b>แก้ไข</b></th>
                    </thead>
                    <tbody>
                    </tbody>
                    
                </table>
            </div>
        </div>

        <div id="modalEditData" class="modalEditData" >
            <div id="modalEdit" class="modalEdit">
                <div class="modalTop">
                    <span class="closeHidden">&times;</span>
                    <a>แก้ไขข้อมูล</a>
                    <span class="close" onclick="closeModalEdit()">&times;</span>
                </div>
                <div class="modalContent">
                    <form id="updateDataForm" action="update_data.php" method="post">
                    <div class="nameLocationEdit">
                            <a>ชื่อโบราณสถาน</a><br>
                            <input name="nameEdit" id="nameEdit" class="form-control" type="text" >
                        </div>
                        <div class="provinceEdit">
                            <a>จังหวัด</a><br>
                            <input name="provEdit" id="provEdit" class="form-control" type="text">
                        </div>
                        <div class="detailsEdit">
                            <a>รายละเอียด</a><br>
                            <textarea name="detEdit" id="detEdit" class="form-control" type="text" rows="6"></textarea>
                        </div>
                        <div class="imgBoxEdit">
                                <a>รูป :</a><br>
                                <input type="file" name="imgFileEdit" id="imgFileEdit" accept="image/*">
                            </div>
                        <div class="modalFooter">
                            <div class="editButton">
                                <button id="editButton" type="button" onclick="updateData()">แก้ไขข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="modalEditDataUser" class="modalEditDataUser" >
            <div id="modalEditUser" class="modalEditUser">
                <div class="modalTop">
                    <span class="closeHidden">&times;</span>
                    <a>แก้ไขข้อมูล</a>
                    <span class="close" onclick="closeModalEditUser()">&times;</span>
                </div>
                <div class="modalContent">
                    <form id="updateUserForm" action="update_datauser.php" method="post">
                        <div class="nameUserEdit">
                            <a>ชื่อผู้ใช้งาน</a><br>
                            <input name="nameUsername" id="nameUsername" class="form-control" type="text">
                        </div>
                        <div class="nameUser">
                            <a>ชื่อ</a><br>
                            <input name="nameUser" id="nameUser" class="form-control" type="text">
                        </div>
                        <div class="surnameEdit">
                            <a>นามสกุล</a><br>
                            <input name="surnameEdit" id="surnameEdit" class="form-control" type="text">
                        </div>
                        <div class="emailEdit">
                            <a>อีเมล</a><br>
                            <input name="emailEdit" id="emailEdit" class="form-control" type="email">
                        </div>
                        <div class="roleEdit">
                            <a>สถานะ</a><br>
                            <select name="roleEdit" id="roleEdit" class="form-select">
                                <option value="user">user</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                        <div class="passwordEdit">
                            <a>รหัสผ่าน</a><br>
                            <input name="passwordEdit" id="passwordEdit" class="form-control" type="password">
                        </div>
                        <div class="modalFooter">
                            <div class="editDataButton">
                                <button id="editDataButton" type="button" onclick="updateDataUser()">แก้ไขข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('typeSelect');
            const dataLocationTable = document.getElementById('dataLocation');
            const dataUserTable = document.getElementById('dataUser');

            typeSelect.addEventListener('change', function () {
                const selectedValue = typeSelect.value;

                if (selectedValue === '0') {
                    dataLocationTable.style.display = 'table';
                    dataUserTable.style.display = 'none';
                }
                else if (selectedValue === '1') {
                    dataLocationTable.style.display = 'none';
                    dataUserTable.style.display = 'table';
                }
            });
        });
    </script>
    <script>

        let selectedRowId;
        
        function fetchData() {
            fetch('fetch_dataAdmin.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#dataLocation tbody');
                    tableBody.innerHTML = '';

                    data.forEach(row => {
                        const newRow = tableBody.insertRow();
                        newRow.insertCell(0).textContent = row.name_location;
                        newRow.insertCell(1).textContent = row.province;
                        newRow.insertCell(2).textContent = row.username;
                        newRow.insertCell(3).textContent = row.details;

                        const imgCell = newRow.insertCell(4);
                        const img = document.createElement('img');
                        img.src = row.img_data;
                        img.alt = 'รูปภาพ';
                        imgCell.appendChild(img);

                        const editCell = newRow.insertCell(5);
                        const editButton = document.createElement('button');
                        editButton.textContent = 'แก้ไข';

                        editButton.addEventListener('click', () => {
                            var modalEdit = document.getElementById("modalEditData");
                            modalEdit.style.display = "block";
                            selectedRowId = row.id;
                            console.log(selectedRowId)
                        });
                        editCell.appendChild(editButton);


                        const deleteCell = newRow.insertCell(6);
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'ลบ';
                        deleteButton.addEventListener('click', () => {
                            if (confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')) {
                                selectedRowId = row.id;

                                fetch('delete_data.php?id=' + selectedRowId, {
                                    method: 'GET'
                                })
                                .then(response => response.text())
                                .then(result => {
                                    fetchData();
                                    window.location.reload();
                                })
                                .catch(error => console.error('เกิดข้อผิดพลาดในการลบ: ' + error));
                            }
                            console.log(selectedRowId)
                        });
                        deleteCell.appendChild(deleteButton);
                    });
                })
                .catch(error => console.error('เกิดข้อผิดพลาด: ' + error));
        }
        document.addEventListener('DOMContentLoaded', fetchData);

        function fetchDataUser() {
            fetch('fetch_dataUserAdmin.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#dataUser tbody');
                    tableBody.innerHTML = '';

                    data.forEach(row => {
                        const newRow = tableBody.insertRow();
                        newRow.insertCell(0).textContent = row.username;
                        newRow.insertCell(1).textContent = row.name;
                        newRow.insertCell(2).textContent = row.surname;
                        newRow.insertCell(3).textContent = row.email;
                        newRow.insertCell(4).textContent = row.role;

                        const editCell = newRow.insertCell(5);
                        const editButton = document.createElement('button');
                        editButton.textContent = 'แก้ไข';

                        editButton.addEventListener('click', () => {
                            var modalEdit = document.getElementById("modalEditDataUser");
                            modalEdit.style.display = "block";
                            selectedRowId = row.id;
                            console.log(selectedRowId)
                        });
                        editCell.appendChild(editButton);
                    });
                })
                .catch(error => console.error('เกิดข้อผิดพลาด: ' + error));
        }
        document.addEventListener('DOMContentLoaded', fetchDataUser);

        function updateData() {
            const nameEdit = document.getElementById("nameEdit").value;
            const provEdit = document.getElementById("provEdit").value;
            const detEdit = document.getElementById("detEdit").value;

            const formData = new FormData();
            if (nameEdit) formData.append("nameEdit", nameEdit);
            if (provEdit) formData.append("provEdit", provEdit);
            if (detEdit) formData.append("detEdit", detEdit);

            const imgFileEdit = document.getElementById("imgFileEdit");
            if (imgFileEdit.files.length > 0) {
                formData.append("imgFileEdit", imgFileEdit.files[0]);
            }

            formData.append("rowId", selectedRowId);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_data.php", true);

            xhr.send(formData);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log("อัปเดตข้อมูลสำเร็จ");
                    window.location.reload();
                } else {
                    console.error("เกิดข้อผิดพลาดในการอัปเดตข้อมูล");
                }
            };
        }

        function updateDataUser() {
            const nameUsername = document.getElementById("nameUsername").value;
            const nameUser = document.getElementById("nameUser").value;
            const surnameEdit = document.getElementById("surnameEdit").value;
            const emailEdit = document.getElementById("emailEdit").value;
            const roleEdit = document.getElementById("roleEdit").value;
            const passwordEdit = document.getElementById("passwordEdit").value;

            const formData = new FormData();
            if (nameUsername) formData.append("nameUsername", nameUsername);
            if (nameUser) formData.append("nameUser", nameUser);
            if (surnameEdit) formData.append("surnameEdit", surnameEdit);
            if (emailEdit) formData.append("emailEdit", emailEdit);
            if (roleEdit) formData.append("roleEdit", roleEdit);
            if (passwordEdit) formData.append("passwordEdit", passwordEdit);

            formData.append("rowId", selectedRowId);

            console.log(nameUsername)
            console.log(nameUser)
            console.log(surnameEdit)
            console.log(emailEdit)
            console.log(roleEdit)
            console.log(passwordEdit)

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_datauser.php", true);

            xhr.send(formData);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log("อัปเดตข้อมูลสำเร็จ");
                    window.location.reload();
                } else {
                    console.error("เกิดข้อผิดพลาดในการอัปเดตข้อมูล");
                }
            };
        }

    </script>

</body>

</html>