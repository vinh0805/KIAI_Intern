<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Number ex02</title>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
<!--    <script src="js/script.js"></script>-->
    <script>
        $(function() {
            $( "#datepicker" ).datepicker({
                dateFormat: "dd/mm/yy",
                defaultDate: "0d",
                changeYear: true,
                changeMonth: true,
                yearRange: "1980:2020"
            });
        });
    </script>

</head>
<body>
<?php
    // Validate data
    $nameErr = $emailErr = $genderErr = '';
    $name = $email = $gender = '';
    $interest = '';
    $target_file = '';
    $keyErr = 0;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(empty($_POST['name'])) {
            $nameErr = 'Name is required!';
            $keyErr = 1;
        } else {
            $name = test_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and space are allowed!";
                $keyErr = 1;
            }
        }
        if(empty($_POST['email'])) {
            $emailErr = 'Email is required!';
            $keyErr = 1;
        } else {
            $email = test_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format!";
                $keyErr = 1;
            }
        }
        if (empty($_POST['gender'])) {
            $genderErr = 'Gender is required!';
            $keyErr = 1;
        } else {
            $gender = test_input($_POST['gender']);
            if (!(strtolower($gender) == 'male' || strtolower($gender) == 'female')) {
                $genderErr = 'Invalid gender!';
                $keyErr = 1;
            }
        }
        if(!empty($_POST['Interests'])) {
            $interest = $_POST['Interests'];
        }


        if($keyErr == 0) {
            $target_file = "uploads/" . basename($_FILES["fileToUpload"]["name"]);
            echo $target_file;
            echo '<br>';
            //include_once 'upload.php';
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            //if (file_exists($target_file)) {
            //    echo "Sorry, file already exists.";
            //    $uploadOk = 0;
            //}

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        $date = $_POST["datepicker"];
        //isset($name) && isset($email) && isset($gender) && isset($_POST["active"]) && isset($date)
        if(isset($name) && isset($email) && isset($gender) && isset($_POST["active"]) && isset($date) && isset($_POST["Interests"]) && isset($_POST["Interests"])) {
            echo  '<br>' . $name . '<br>';
            echo $email . '<br>';
            echo $gender . '<br>';
            echo $_POST["active"] . '<br>';
            //$date = $_POST["datepicker"];
            echo $date . '<br>';
            echo $_POST["Interests"] . '<br>';
            echo $target_file;
            $arrayData = [$name, $email, $gender, $date, $_POST["active"], $_POST["Interests"], $target_file];
            session_start();
            $_SESSION['arrayData'] = $arrayData;
            $jsonData = json_encode($arrayData);
            $fh = fopen("data_out.json", 'w') or die("Error opening output file.");
            fwrite($fh, $jsonData);
            fwrite($fh, "\n");

            $jsonData2 = file_get_contents("data_out.json");
            $jsonDecodedData = json_decode($jsonData2);
            echo '</br>' . '</br>' . 'Data onfile json: ' . '</br>';
            echo '<pre>';
            print_r($jsonDecodedData);
            echo '</pre>';
            fclose($fh);

            include_once 'dataBase.php';

        } else echo "Have something wrong here!";
    }

    function test_input ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Create selectBox
    function createSelectBox($arrData, $name, $value) {
        $str = "";
        if(!empty($arrData)) {
            $str .= '<select name="' .$name. '" id="' .$name. '" class="label-content">';
            for($i = 0; $i < count($arrData); $i++) {
                if($arrData[$i] == $value) {
                    $str .= '<option value="' .$arrData[$i]. '" selected >' .$arrData[$i]. '</option>';
                } else {
                    $str .= '<option value="' .$arrData[$i]. '">' .$arrData[$i]. '</option>';
                }
            }
            $str .= '</select>';
        }
        return $str;
    }

?>
<div class="content">
    <form action="index.php" method="post" name="main-form" id="main-form" enctype="multipart/form-data">
        <div class="form-group">
            <label class="label-left">Name</label>
            <label>
                <input class="label-content" type="text" id="name" name="name" value="<?php echo $name?>">
            </label>
            <label class="error"><?php echo $nameErr; ?></label>
        </div>

        <div class="form-group">
            <label class="label-left">Email</label>
            <label>
                <input class="label-content" type="text" id="email" name="email" value="<?php echo $email?>">
            </label>
            <label class="error"><?php echo $emailErr; ?></label>
        </div>

        <div class="form-group">
            <label class="label-left">Gender</label>
            <label>
                <input class="label-content" type="text" id="gender" name="gender" placeholder="(male/female)" value="<?php echo $gender?>">
            </label>
            <label class="error"><?php echo $genderErr; ?></label>
        </div>

        <div class="form-group">
            <label class="label-left">Birthday</label>
            <?php
            $date = (isset($_POST["datepicker"])) ? $_POST["datepicker"] : "";
            ?>
<!--            <form action="#" method="post" name="mainForm" id="mainForm">-->
                <input class="label-content" readonly="readonly" type="text" id="datepicker" name="datepicker" value="<?php echo $date; ?>">
<!--            </form>-->

        </div>

        <div class="form-group">
            <label class="label-left">Status</label>
            <label class="label-content" id="activeRadio">
                <input id="r1" type="radio" name="active" value="active" <?php if(isset($_POST["active"])) if ($_POST["active"] == 'active') echo 'checked'; ?> />
                <label>Active</label>
                <input id="r2" type="radio" name="active" value="unactive" <?php if(isset($_POST["active"])) if ($_POST["active"] == 'unactive') echo 'checked';?> />
                <label>Unactive</label>
            </label>
        </div>

        <div class="form-group">
            <label class="label-left">Interest</label>
            <?php
                $arrData = ['None', 'Football', 'Reading Book', 'Watching movie', 'Listen to music', 'Camping', 'Travel', 'Other...'];
                echo createSelectBox($arrData, 'Interests', $interest);
            ?>
        </div>

        <div class="form-group">
            <label class="label-left">Avatar:</label>
            <input class="label-content" type="file" id="fileToUpload" name="fileToUpload"/>
            <div id="fileUpload_domTarget" style="display: none"><?php echo htmlspecialchars($target_file);?></div>
        </div>

        <input class="submit" type="submit">

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($nameErr == '' && $emailErr == '' && $genderErr == '') {
                    echo '<label id="successAnnoucement">Successfully!</label>';
                }
            }
        ?>
    </form>

</div>
</body>
<!---->
<?php
//    echo '<script src="js\script.js"></script>';
//?>