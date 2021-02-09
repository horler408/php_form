<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" herf="./style.css" />
    <title>Register Page</title>
</head>
<?php
    require_once 'connection.php';
    $msg = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['first_name'];
        $lname = $_POST['last_name'];
        $email = $_POST['email'];
        $pword = $_POST['password'];

        // The Parameter data from connection file
        $conn = new mysqli($server, $user_name, $password, $database);
    
        if ($conn->connect_error) die($msg = "Database NOT Found!");

        $query = "INSERT INTO tb_form (first_name, last_name, email, password) VALUES ('$fname', '$lname', '$email', '$pword')";
        //$query = "INSERT INTO tb_form (first_name, last_name, email, password) VALUES" ."('$fname', '$lname', '$email', '$pword')";
        $result = $conn->query($query);

        if(!$result) $msg = "Record Insert failed!";
        else {
            $msg = "Records added to the database"; 
        } 

        //$result->close();
        $conn->close();
    }
?>
<body>
    <div class="container">
        <form method="POST" action="register.php">
        <div class="message"><?php print $msg ?></div>
            <div>
                <label for="fName">First Name</label>
                <input type="text" name="first_name" id="fName">
            </div>
            <div>
                <label for="lName">Lastst Name</label>
                <input type="text" name="last_name" id="lName">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="pword">Password</label>
                <input type="password" name="password" id="pword">
            </div>
            <div>
                <label for="cpword">Password</label>
                <input type="password" name="confirm_password" id="cpword">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>