<?php
    $servername = "localhost";
    $username = "username";
    $password = "password";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Create database
    $sql = "USE mydb";
    if (mysqli_query($conn, $sql)) {
        echo "You are using mydb." . '</br>';
    } else {
        echo "Error using database: " . mysqli_error($conn);
    }

    $sql = "CREATE TABLE User (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    gender VARCHAR(6) NOT NULL,
    birthday VARCHAR(10) NOT NULL,
    active VARCHAR (10) NOT NULL,
    interest VARCHAR(30) NOT NULL,
    avatar VARCHAR(30) 
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table User created successfully." . '</br>';
    } else if(mysqli_errno($conn) != 1050){                     // 1050: error code of Table 'user' already exists.
        echo "Error creating table: " . mysqli_error($conn);
    }

    $data = $_SESSION['arrayData'];
    $sql = "INSERT INTO User (name, email, gender, birthday, active, interest, avatar) VALUES ('$data[0]', '$data[1]' , '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]')";

    if (mysqli_query($conn, $sql)) {
        echo "Insert data successfully." . '</br>';
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }

    // Read data from table
    $sql = "SELECT * FROM User";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        echo '</br>'. '</br>' . "The data in table: " . '</br>';
        while($row = mysqli_fetch_assoc($result)) {
            echo 'id: ' . $row['id'] . ' - Name: ' . $row['name'] . ' - Email: ' . $row['email'] . ' - Gender: ' . $row['gender'] . ' - Birthday: ' . $row['birthday'] . ' - Active status: ' . $row['active'] . ' - Interest: ' . $row['interest'] . ' - Avatar: ' . $row['avatar'] . '</br>';
        }
    } else echo '0 result.' . '</br>';

    // Delete last record in the table
//    $sql = "DELETE FROM User
//            WHERE id = (SELECT MAX(id) FROM User)";
//    if(mysqli_query($conn, $sql)) {
//        echo '</br>' . "Delete successfully!" . '</br>';
//    } else echo '</br>' . "Cannot delete!" . '</br>';
//    mysqli_close($conn);
