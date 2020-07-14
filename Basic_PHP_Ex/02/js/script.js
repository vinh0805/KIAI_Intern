
window.onload = function () {
    console.log(document.getElementById("name"));
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let gender = document.getElementById("gender").value;
    let birthday = document.getElementById("datepicker").value;

    let activeRadio = "";
    if(document.getElementById("r1").checked) {
        console.log("r1 is checked");
        activeRadio = document.getElementById("r1").value;
    } else if (document.getElementById("r2").checked) {
        console.log("r2 is checked");
        activeRadio = document.getElementById("r2").value;
    } else console.log(">??????");

    let interests = document.getElementById("Interests").value;
//    let avatar = document.getElementById("fileToUpload").files[0];
    //let avatar = $('input[type=file]').val();

    let avatar = document.getElementById("fileUpload_domTarget").textContent;

    console.log(avatar);
    let data = [];
    data.push(name);
    data.push(email);
    data.push(gender);
    data.push(birthday);
    data.push(activeRadio);
    data.push(interests);
    data.push(avatar);

    console.log(data);
    let jsonData = JSON.stringify(data);
    console.log(jsonData);
    //
    // let fs = require('fs');
    // fs.writefile("data/data.json", jsonData, function (err) {
    //     if(err) {
    //         return console.log(err);
    //     } else console.log("The file was saved.");
    // });

    localStorage.setItem("testJSON", jsonData);

}