<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Number ex01</title>
</head>
<body>
<?php
    $nameErr = $emailErr = $genderErr = '';
    $name = $email = $gender = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(empty($_POST['name'])) {
            $nameErr = 'Name is required!';
        } else {
            $name = test_input($_POST['name']);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }
        if(empty($_POST['email'])) {
            $emailErr = 'Email is required!';
        } else {
            $email = test_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST['gender'])) {
            $genderErr = 'Gender is required!';
        } else {
            $gender = test_input($_POST['gender']);
            if (!(strtolower($gender) == 'male' || strtolower($gender) == 'female')) {
                $genderErr = 'Invalid gender!';
            }
        }
    }

    function test_input ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<div class="content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <div class="form-group">
            <label class="label-content">Name</label>
            <input type="text" name="name" value="<?php echo $name?>">
            <label class="error"><?php echo $nameErr; ?></label>
        </div>
        <div class="form-group">
            <label class="label-content">Email</label>
            <input type="text" name="email" value="<?php echo $email?>">
            <label class="error"><?php echo $emailErr; ?></label>
        </div>
        <div class="form-group">
            <label class="label-content">Gender</label>
            <input type="text" name="gender" placeholder="(male/female)" value="<?php echo $gender?>">
            <label class="error"><?php echo $genderErr; ?></label>
        </div>
        <input class="submit" type="submit">
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($nameErr == '' && $emailErr == '' && $genderErr == '') {
                    echo '<label style="text-align: center; color: green; display: block; margin-top: 20px;">Successfully!</label>';
                }
            }
        ?>
    </form>
</div>
</body>