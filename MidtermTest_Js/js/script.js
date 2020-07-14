//  Data
let staffList = [];     // new arrayList();
const LIMIT = 10;
//const MAX_ID = 999;
let current_page = 1;

function Staff(ID, Name, AvatarLink, Birthday, Email, checkBox) {
    this.checkBox = checkBox;
    this.ID = ID;
    this.Name = Name;
    this.AvatarLink = AvatarLink;
    this.Birthday = Birthday;
    this.Email = Email;
    //this.ActionEdit = Edit;
    //this.ActionDelete = Delete;
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Get start place (Sử dụng để tìm vị trí đầu tiên để in ra màn hình)
function getStartPlace() {
    let startPlace = staffList.length - (current_page - 1)*LIMIT - 1;

    // Find null staff
    for(let i = staffList.length - 1; i >= startPlace; i--) {
        if(staffList[i] == null) {
            startPlace--;
            if(startPlace < 0) break;
        }
    }
    return startPlace;
}

// Get total pages (Sử dụng để tính tổng số trang, dùng trong hàm pagination();)
function getTotalPages() {
    let total_staffs = staffList.length;
    for(let i = 0; i < staffList.length; i++) {
        if(staffList[i] == null)
            total_staffs--;
    }
    return Math.ceil(total_staffs/LIMIT);       // Total pages
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Create Staff List (Tạo random Staff List)
function createRandomStaffList(number) {
    for(let i = 1; i < number + 1; i++) {
        let name = randomName();
        let email = name.replace(/\s+/g, '');
        staffList[i - 1] = new Staff(i, name, randomAvatarLink(), randomDate(new Date(1980, 1, 1), new Date(2005, 1, 1)), email + "@gmail.com", 0);
    }
    showStaffList2();
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Show Staff List (Hiển thị danh sách staffList lên màn hình)
function showStaffList(startPlace) {
    let tableContent = document.getElementById('tableContent');

    for(let i = startPlace; (i > (startPlace - LIMIT)) && i >= 0; i--) {
        if(staffList[i] != null) {
            tableContent.insertAdjacentHTML('beforeend', makeHTML(staffList[i].ID, staffList[i].Name, staffList[i].AvatarLink,
                staffList[i].Birthday, staffList[i].Email));
        } else {
            if(startPlace < 0) break;
            startPlace--;
        }
    }
    removePagination();
    pagination();
}

function showStaffList2() {
    current_page = 1;
    reloadAtCurrentPage();
}

function reloadAtCurrentPage() {
    removeTableContent();
    showStaffList(getStartPlace());
}

function reloadAtFirstPage() {
    removeTableContent();
    showStaffList2();
}

// Remove table's content to reload
function removeTableContent() {
    document.getElementById("tableContent").innerHTML = ``;
}

function makeHTML(ID, Name, Avatar, Birthday, Email) {
    return (`
        <tr>
            <td> <input class="checkBox" type="checkbox" onclick="checkedID(` + ID +`)"/></td>
            <th class="ID" scope="row">` + ID + `</th>
            <td class="Name">` + Name + `</td>
            <td class="Avatar"> <img src="` + Avatar + `" alt="Avatar" id="Avatar` + ID + `"> </td>
            <td class="Birthday">` + Birthday + `</td>
            <td class="Email">` + Email + `</td>
            <td class="Action">
            
                <button id="edit" onclick="edit(` + ID + `)">Edit</button>
                <button class="DeleteRow" onclick="deleteRow(` + ID + `)">Delete</button>
            </td>
        </tr>`
    )
}


//------------------------------------------------------------------------------------------------------------------------------------------------------

// Make random data
const nameList = ["Stasia Kroh", "Stasia Kroh", "Trenton Goto", "Melissa Vinton", "Teofila Steven",
    "Ngo Thu Huyen", "Tran Nhat Thong", "Nguyen Duc Tan", "Do Kim Phong", "Nguyen Quang Anh",
    "Do Manh Ha", "Tran Quang Khoi", "Mau Tien Vinh", "Nguyen Van A"];

function randomName() {
    let randomNumber = Math.floor(Math.random()*nameList.length);
    return nameList[randomNumber];
}

function randomAvatarLink() {
    let randomAvatarlink = "avatar/ava0";
    let randomNumber = Math.floor(Math.random()*10);
    randomNumber.toString();
    randomAvatarlink += randomNumber;
    randomAvatarlink += ".jpg";
    return randomAvatarlink;
}

function randomDate(start, end) {
    let d = new Date(start.getTime() + (end.getTime() - start.getTime())*Math.random());
    return d.toISOString().split('T')[0];
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Pagination
// Show pagination
function pagination() {
    let total_pages = getTotalPages();
    let totalPagesHTML =``;
    for (let i = 0; i < total_pages; i++) {
        totalPagesHTML += `<li class="page-item"><button onclick="goToPage(` + (i + 1) + `);">` + (i + 1) + `</button></li>`;
    }
    document.getElementById("pageNumber").insertAdjacentHTML('beforeend', totalPagesHTML);
}

// Remove to reload pagination
function removePagination() {
    document.getElementById("pageNumber").innerHTML = ``;
}

// Go to page
function goToFirstPage() {
    showStaffList2();
}

function goToPrePage() {
    if (current_page > 1) {
        current_page -= 1;
    reloadAtCurrentPage();
    }
}

function goToNextPage() {
    if(current_page < getTotalPages()) {
        current_page += 1;
    reloadAtCurrentPage();
    }
}

function goToLastPage() {
    current_page = getTotalPages();     // Set current_page = the last page
    reloadAtCurrentPage();
}

function goToPage(number) {
    if (number === 1) {
        goToFirstPage();
    } else if (number === getTotalPages()) {
        goToLastPage();
    } else goToPageN(number);
}

function goToPageN(number) {
    current_page = number;
    reloadAtCurrentPage();
}

//------------------------------------------------------------------------------------------------------------------------------------------------------

// Search data
function search() {
    let input, filter, table, tr, td, cell, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("tableContent");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < LIMIT; i++) {
        // Hide the row initially.
        tr[i].style.display = "none";

        td = tr[i].getElementsByTagName("td");
        for (let j = 0; j < 7; j++) {
            cell = tr[i].getElementsByTagName("td")[j];
            if (cell) {
                if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Validate data
function validateName(name) {
    if(!/^[a-z A-Z]+$/.test(name)) {
        alert("Wrong name's format!");
        return false;
    }
    return true;
}

function validateId(ID) {
    if(isNaN(parseInt(ID))) {
        alert("Please enter ID!")
        return false;
    }
    if(parseInt(ID) < 1) {
        alert("Wrong ID!");
        return false;
    }
    for(let i = 0; i < staffList.length; i++) {     // Check primary key: ID
        if(staffList[i] != null) {
            if(staffList[i].ID == ID) {
                alert("Duplicated ID!");
                return false;
            }
        }
    }
    return true;
}

function validateEmail(email) {
    const emailExtension = ["@gmail.com", "@yahoo.com", "@sis.hust.edu.vn"];
    let slicePlace = email.indexOf("@");

    if(/^[a-zA-Z0-9]+$/.test(email.substring(0, slicePlace))) {
        if(emailExtension.includes(email.substring(slicePlace, email.length))) {
            return true;
        }
    }
    alert("Wrong email's format~");
    return false;
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Add data
function add(event) {
    //event.preventDefault();

    let id = event.target['ID'].value;
    if (!validateId(id)) {
        event.preventDefault();
        return;
    }

    let name = event.target['Name'].value;
    if (!validateName(name)) {
        event.preventDefault();
        return;
    }

    let avatarId = "Avatar";
    avatarId += id.toString();

    id = parseInt(id, 10);
    let avatarLink = "";

    try {
        const input = document.getElementById("Avatar");
        let fReader = new FileReader();
        fReader.readAsDataURL(input.files[0]);
        fReader.onload = function (event) {
            let img = document.getElementById(avatarId);
            img.src = event.target.result;
            avatarLink = img.src;
            delete staffList[staffList.length - 1];
            staffList[staffList.length - 1] = new Staff(id, name, avatarLink, date, email, 0);
        }
    } catch  {}

    let date = event.target['Birthday'].value;
    if (date === null) {
        alert("Please input date!");
        event.preventDefault();
        return;
    }
    let email = event.target['Email'].value;
    if (!validateEmail(email)) {
        event.preventDefault();
        return;
    }

    staffList.push(new Staff(id, name, avatarLink, date, email, 0));
    closeAddPopup(event);

    console.log(staffList);
    event.preventDefault();
    event.stopPropagation();
}

function closeAddPopup(event) {
    event.preventDefault();

    console.log(event);
    if(event != undefined) {
        if(event.target['ID'] != undefined && event.target['ID'] != null) {
            if(event.target['ID'].value != "") {
                event.target['ID'].value = "";
                console.log("Reload value");
            }
        }
        if(event.target['Name'] != undefined && event.target['Name'] != null) {
            if(event.target['Name'].value != "") {
                event.target['Name'].value = "";
                console.log("Reload name");
            }
        }
        if(event.target['Avatar'] != undefined && event.target['Avatar'] != null) {
            if(event.target['Avatar'].value != "") {
                event.target['Avatar'].value = "";
                console.log("Reload avatar");
            }
        }
        if(event.target['Birthday'] != undefined && event.target['Birthday'] != null) {
            if(event.target['Birthday'].value != "") {
                event.target['Birthday'].value ="";
                console.log("Reload birthday");
            }
        }
        if(event.target['Email'] != undefined && event.target['Email'] != null) {
            if(event.target['Email'].value != "") {
                console.log(event.target['Email'].value);
                event.target['Email'].value = "";
                console.log("Reload email");
            }
        }
    }

    $('#exampleModal').modal('hide');
    reloadAtFirstPage();
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Edit data
function edit(id){      // Chỉnh sửa dữ liệu
    let editingStaff;
    for (let i = 0; i < staffList.length; i++) {
        if(staffList[i] != null) {
            if (staffList[i].ID === id) {
                editingStaff = staffList[i];
                console.log("Editing staff " + i)
            }
        }
    }

    try {               // Hiện popup edit
        let container = document.getElementById("edit-modal");
        container.innerHTML = `
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Thông tin cần chinh sua</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="doEdit(event)">
                            <input type="hidden" id="id"  value="` + editingStaff.ID + `">
                            <div class="form-group">
                                <label for="Name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="Name" value="` + editingStaff.Name + `">
                            </div>
                            <div class="form-group">
                                <label for="Avatar" class="col-form-label">Avatar:</label>
                                <input type='file' class="form-control" id="avatar" name="Avatar" value="` + editingStaff.AvatarLink + `" accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="form-group">
                                <label for="Birthday" class="col-form-label">Birthday:</label>
                                <input type="date" class="form-control" id="birthday" name="Birthday" value="` + editingStaff.Birthday + `">
                            </div>
                             <div class="form-group">
                                <label for="Email" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="Email" value="` + editingStaff.Email + `">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `;
        $('#exampleModal2').modal('show');
    } catch {
        alert("Have error.");
    }
}

function doEdit(event){     // Thực hiện sửa dữ liệu
    event.preventDefault();

    let id = event.target['id'].value;
    let name = event.target['name'].value;
    if(!validateName(name)) {
        event.preventDefault();
        return;
    }

    let avatarLink;
    for(let i = staffList.length - 1; i > 0; i--) {
        if(staffList[i] != null) {
            if(staffList[i].ID == id) {
                avatarLink = staffList[i].AvatarLink;
            }
        }
    }

    try {
        let avatarId = "Avatar";
        avatarId += id.toString();

        id = parseInt(id, 10);

        const input = document.getElementById("avatar");
        let fReader = new FileReader();
        fReader.readAsDataURL(input.files[0]);
        fReader.onload = function (event) {
            let img = document.getElementById(avatarId);
            img.src = event.target.result;
            avatarLink = img.src;

            for (let i = 0; i < staffList.length; i++) {
                if(staffList[i] != null) {
                    if (staffList[i].ID == id) {
                        if(avatarLink != staffList[i].AvatarLink) {
                            staffList[i].AvatarLink = avatarLink;
                        }
                    }
                }
            }
        }
    } catch {
        //alert("Error!!!");
    }

    let date = event.target['birthday'].value;
    if(date === null) {
        alert("Please input date!");
        event.preventDefault();
        return;
    }
    let email = event.target['email'].value;
    if(!validateEmail(email)) {
        event.preventDefault();
        return;
    }

    for (let i = 0; i < staffList.length; i++) {
        if(staffList[i] != null) {
            if (staffList[i].ID == id) {
                staffList[i].Name = name;
                staffList[i].Birthday = date;
                staffList[i].Email = email;
            }
        }
    }
    $('#exampleModal2').modal('hide');
    reloadAtCurrentPage();
}

//------------------------------------------------------------------------------------------------------------------------------------------------------

// Delete data
function deleteRow(ID) {   // Xóa bằng nút Delete ở từng dòng
    let startPlace = getStartPlace();
    for (let i = 0; i < staffList.length; i++) {
        if(staffList[i] != null) {
            if (staffList[i].ID === ID) {
                if (confirm("Do you want to delete?")){
                    delete staffList[i];
                    removeTableContent();
                    showStaffList(startPlace);
                }
                return;
            }
        }
    }
    alert("Don't exist!");
}

function checkBoxAll() {        // Chọn hoặc bỏ chọn toàn bộ các ô checkBox đang hiển thị
    let checkBox = document.getElementsByClassName("checkBox");
    let checkBoxAll = document.getElementById("checkBoxAll");

    if(checkBoxAll.checked == null || checkBoxAll.checked === false) {
        for(let i = 0; i < checkBox.length; i++) {
            checkBox[i].checked = false;
        }
        setAllCheckBoxValue(0);
    } else {
        for(let i = 0; i < checkBox.length; i++) {
            checkBox[i].checked = true;
        }
        setAllCheckBoxValue(1);
    }
}

function setAllCheckBoxValue(value) {   // Đặt giá trị của staff[i].checkBox = 0 || 1
    let startPlace = getStartPlace();

    if(value === 1) {
        for(let i = startPlace; i > (startPlace - LIMIT); i--) {
            if(staffList[i] != null) {
                staffList[i].checkBox = 1;
            } else {
                if(startPlace === 0) break;
                startPlace--;
            }
        }
    } else {
        for(let i = startPlace; i > (startPlace - LIMIT); i--) {
            if(staffList[i] != null) {
                staffList[i].checkBox = 0;
            } else {
                if(startPlace === 0) break;
                startPlace--;
            }
        }
    }
}


function deleteByCheckBox() {       // Xóa các ô đã chọn
    let startPlace = getStartPlace();

    if(confirm("Do you want to delete the checked staffs?")) {
        for(let i = startPlace; i > (startPlace - LIMIT); i--) {
            if(staffList[i] != null) {
                if(staffList[i].checkBox === 1)
                    delete staffList[i];
            } else {
                startPlace--;
                if(startPlace < 0) break;
            }
        }

        if(document.getElementById("checkBoxAll").checked === true) {
            document.getElementById("checkBoxAll").checked = false;
        }

    reloadAtCurrentPage();
    }
}

function checkedID(ID) {        // Thay đổi staffList[i].checkBox = 1 || 0 khi được check
    for(let i = 0; i < staffList.length; i++) {
        if(staffList[i] != null) {
            if(staffList[i].ID === ID) {
                if(staffList[i].checkBox === 1) {
                    staffList[i].checkBox = 0;
                } else {staffList[i].checkBox = 1}
            }
        }
    }
}
//------------------------------------------------------------------------------------------------------------------------------------------------------

// Sort data                ( Các hàm sắp xếp dữ liệu)
// Sort by ID
function sortByID() {
    staffList.sort(compareID);
    reloadAtFirstPage();
}

function reverseSortByID() {
    staffList.sort(compareID);
    staffList.reverse();
    reloadAtFirstPage();
}

function sortByName() {
    staffList.sort(compareName);
    reloadAtFirstPage();
}

function reverseSortByName() {
    staffList.sort(compareName);
    staffList.reverse();
    reloadAtFirstPage();
}
function sortByBirthday() {
    staffList.sort(compareBirthday);
    reloadAtFirstPage();
}

function reverseSortByBirthday() {
    staffList.sort(compareBirthday);
    staffList.reverse();
    reloadAtFirstPage();
}
function sortByEmail() {
    staffList.sort(compareEmail);
    reloadAtFirstPage();
}

function reverseSortByEmail() {
    staffList.sort(compareEmail);
    staffList.reverse();
    reloadAtFirstPage();
}

function compareID(a, b) {
    const bandA = a.ID;
    const bandB = b.ID;
    let comparison = 0;

    if(bandA > bandB) {
        comparison = 1;
    } else if(bandA < bandB) {
        comparison = -1;
    }
    return comparison;
}

function compareName(a, b) {
    const bandA = a.Name;
    const bandB = b.Name;
    let comparison = 0;

    if(bandA > bandB) {
        comparison = 1;
    } else if(bandA < bandB) {
        comparison = -1;
    }
    return comparison;
}

function compareBirthday(a, b) {
    const bandA = a.Birthday;
    const bandB = b.Birthday;
    let comparison = 0;

    if(bandA > bandB) {
        comparison = 1;
    } else if(bandA < bandB) {
        comparison = -1;
    }
    return comparison;

}

function compareEmail(a, b) {
    const bandA = a.Email;
    const bandB = b.Email;
    let comparison = 0;

    if(bandA > bandB) {
        comparison = 1;
    } else if(bandA < bandB) {
        comparison = -1;
    }
    return comparison;
}

