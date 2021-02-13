<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<?php
    require_once 'connection.php';
    require 'functions.php';

    $msg = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // The Parameter data from connection file
        $conn = new mysqli($server, $user_name, $password, $database);
        if ($conn->connect_error) die($msg = "Database NOT Found!");

        $email = $_POST['email'];
        $pword = $_POST['password'];

        //The function to sanitise the inputs comes from functions.php
        if (isset($_POST['email']) && isset($_POST['password'])){
            $em_temp = mysql_entities_fix_string($conn, $email);
            $pw_temp = mysql_entities_fix_string($conn, $pword);

            $query = "SELECT * FROM tb_form WHERE email='$em_temp'";
            $result = $conn->query($query);
    
            if (!$result) die($msg = "User not found");
            else if ($result->num_rows){
                $row = $result->fetch_array(MYSQLI_NUM);
                $result->close();
    
                if (password_verify($pw_temp, $row[3])) {
                    session_start();
                    $_SESSION['first_name'] = $row[1];
                    $_SESSION['last_name'] = $row[2];
                    echo htmlspecialchars("$row[1] $row[2] : Hi $row[0],
                    you are now logged in as '$row[2]'");
                    die ("<p><a href='dashboard.php'>Click here to continue</a></p>");
                }
                else die("Invalid username/password combination");
            }
            else die("Invalid username/password combination");
        }
        else{
            header('WWW-Authenticate: Basic realm="Restricted Area"');
            header('HTTP/1.0 401 Unauthorized');
            die ("Please enter your username and password");
        }
    
        $conn->close();
    }

?>
<body>
    <div class="login-container">
    <form method="POST" action="login.php">
        <pre>
            <div class="message"><?php print $msg ?></div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="pword">Password</label>
                <input type="password" name="password" id="pword">
            </div>
            <button type="submit">Submit</button>
        </pre>    
    </form>
    </div>
</body>
</html>