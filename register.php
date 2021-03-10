<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>Register Page</title>
</head>
<?php
    require_once 'connection.php';
    require 'functions.php';
    $msg = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // The Parameter data from connection file
        $conn = new mysqli($server, $user_name, $password, $database);
        if ($conn->connect_error) die($msg = "Database NOT Found!");

        $fname = $_POST['first_name'];
        $lname = $_POST['last_name'];
        $email = $_POST['email'];
        $pword = $_POST['password'];

        $fname = mysql_entities_fix_string($conn, $fname);
        $lname = mysql_entities_fix_string($conn, $lname);
        $email = mysql_entities_fix_string($conn, $email);
        $pword = mysql_entities_fix_string($conn, $pword);
        $hash = password_hash($pword, PASSWORD_DEFAULT);

        //Checking if Email exists
        $query = "SELECT * FROM users";

        $result = $conn->query($query);
        if (!$result) die($conn->error);

        $rows = $result->num_rows;
        
        for ($i = 0 ; $i < $rows ; ++$i){
            $result->data_seek($i);
            if($result->fetch_assoc()['email'] === $email){
                $msg = "Email already exists";
                exit();
            }else {
                $query = "INSERT INTO tb_form (first_name, last_name, email, password) VALUES ('$fname', '$lname', '$email', '$hash')";
                //$query = "INSERT INTO tb_form (first_name, last_name, email, password) VALUES" ."('$fname', '$lname', '$email', '$pword')";
                $result = $conn->query($query);

                if(!$result) $msg = "Record Insert failed!";
                else {
                    $msg = "Records added to the database"; 
                } 
                    }
                }
        //Checking ends here

        //$result->close();
        $conn->close();
    }
?>
<body>
    <div class="container">
        <form method="POST" action="register.php">
        <div class="message"><?php print $msg ?></div>
            <div class="input">
                <label for="fName">First Name</label>
                <input type="text" name="first_name" id="fName">
                <small id="first-name-error" class="error-message"></small>
            </div>
            <div class="input">
                <label for="lName">Lastst Name</label>
                <input type="text" name="last_name" id="lName">
                <small id="last-name-error" class="error-message"></small>
            </div>
            <div class="input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
                <small id="email-error" class="error-message"></small>
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <small id="password-error" class="error-message"></small>
            </div>
            <div class="input">
                <label for="confirm-password">Password</label>
                <input type="password" name="confirm_password" id="confirm-password">
                <small id="confirm-password-error" class="error-message"></small>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
    <script src="./app.js"></script>
</body>
</html>