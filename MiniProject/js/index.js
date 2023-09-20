function LoginButton(){
    var modalLog = document.getElementById("modalLog");
    var modalRegister = document.getElementById("modalRegister");
    modalRegister.style.display = "none";
    modalLog.style.display = "block";
}

function registerButton(){
    var modalLog = document.getElementById("modalLog");
    var modalRegister = document.getElementById("modalRegister");
    modalLog.style.display = "none";
    modalRegister.style.display = "block";
}

function addNewData(){
    var modalAddnew = document.getElementById("modalAddnew");
    modalAddnew.style.display = "block";
}

function closeModal() {
    var modalLog = document.getElementById("modalLog");
    var modalRegister = document.getElementById("modalRegister");
    modalLog.style.display = "none";
    modalRegister.style.display = "none";
}

function closeModalAddnew(){
    var modalAddnew = document.getElementById("modalAddnew");
    modalAddnew.style.display = "none";
}

function closeModalEdit(){
    var modalEdit = document.getElementById("modalEditData");
    modalEdit.style.display = "none";
}

function closeModalEditUser(){
    var modalEditUser = document.getElementById("modalEditDataUser");
    modalEditUser.style.display = "none";
}

function submitForm() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    if (username === "" || password === "") {
        alert("กรุณากรอกชื่อผู้ใช้และรหัสผ่าน");
    } else {
        document.getElementById("loginForm").submit();
    }
}

window.addEventListener("load", function () {
    loadAllDataAndDisplay();
    loadAllData();
});

function loadAllDataAndDisplay() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "load_all_data.php", true); // สร้างไฟล์ PHP สำหรับดึงข้อมูลทั้งหมด
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var allResults = JSON.parse(xhr.responseText);
            displaySearchResults(allResults);
        }
    };
    xhr.send();
}

function loadAllData() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var allResults = JSON.parse(xhr.responseText);
            displaySearchResults(allResults);
        }
    };
    xhr.send();
}

function displaySearchResults(results) {
    var resultsContainer = document.getElementById("searchResultsContainer");
    resultsContainer.innerHTML = "";

    if (results.length === 0) {
        resultsContainer.innerHTML = "ไม่พบข้อมูล";
    } else {
        for (var i = 0; i < results.length; i++) {
            var result = results[i];
            var resultHTML = '<div class="dataLists">';
            resultHTML += '<div class="boxImg">';
            resultHTML += '<img class="imgData" src="' + result.img_data + '">';
            resultHTML += '</div>';
            resultHTML += '<div class="boxData">';
            resultHTML += '<div class="nameTopic">' + result.name_location + '</div>';
            resultHTML += '<div class="nameCW"><b>จังหวัด : ' + result.province + '</b></div>';
            resultHTML += '<div class="nameUser">เพิ่มข้อมูลโดย : ' + result.username + '</div>';
            resultHTML += '<br>';
            resultHTML += '<div class="details">';
            resultHTML += '<textarea class="dataDetails">'+ result.details + '</textarea>';
            resultHTML += '</div>';
            resultHTML += '<br>';
            resultHTML += '<div class="seemoreButton">';
            resultHTML += '<button id="seemore" type="button" onclick="displayDetails(this)">ดูเพิ่มเติม</button>';
            resultHTML += '</div>';
            resultHTML += '</div>';
            resultHTML += '</div>';

            resultsContainer.innerHTML += resultHTML;
        }
    }
}

function searchInDatabase(searchText) {

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php?query=" + searchText, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var searchResults = JSON.parse(xhr.responseText);

            displaySearchResults(searchResults);
        }
    };
    xhr.send();
}

function loadAllData() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "load_provinces.php", true); // สร้างไฟล์ PHP สำหรับดึงข้อมูลจังหวัด
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var provinces = JSON.parse(xhr.responseText);
            populateProvinceSelect(provinces);
        }
    };
    xhr.send();
}

function populateProvinceSelect(provinces) {
    var selectElement = document.getElementById("typeCW");
    selectElement.innerHTML = '<option value="0" selected>ทุกจังหวัด</option>';

    for (var i = 0; i < provinces.length; i++) {
        var province = provinces[i];
        var option = document.createElement("option");
        option.value = province;
        option.textContent = province; 
        selectElement.appendChild(option);
    }
}

function filterByProvince() {
    var selectedProvince = document.getElementById("typeCW").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "filter_location.php?province=" + selectedProvince, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var searchResults = JSON.parse(xhr.responseText);
            displaySearchResults(searchResults);
        }
    };
    xhr.send();
}


function displayDetails(button) {
    var parentElement = button.closest(".dataLists"); 
    if (parentElement) {
        var name_location = extractValue(parentElement.innerHTML, 'nameTopic');
        var province = extractValue(parentElement.innerHTML, 'nameCW');
        var username = extractValue(parentElement.innerHTML, 'nameUser');
        var details = extractValue(parentElement.innerHTML, 'dataDetails');
        var img_data = extractValue(parentElement.innerHTML, 'imgData'); 

        var modal = document.getElementById("modalDetailsLocation");
        var modalDetails = modal.querySelector(".modalDetails");

        modalDetails.querySelector(".province").innerHTML = province;
        modalDetails.querySelector(".user a").textContent = username;
        modalDetails.querySelector(".modalTop b").textContent = name_location;
        modalDetails.querySelector(".imgBox img").src = img_data; 
        modalDetails.querySelector(".details textarea").value = details;
        modal.style.display = "block";
    }
}

function extractValue(html, className) {
    var regex = new RegExp('<div class="' + className + '">(.*?)</div>|<textarea class="' + className + '">(.*?)</textarea>|<img class="' + className + '" src="(.*?)">');
    var match = html.match(regex);
    return match ? (match[1] || match[2] || match[3] || '') : '';
}

function closeModalDetails() {
    var modal = document.getElementById("modalDetailsLocation");
    modal.style.display = "none";
}






