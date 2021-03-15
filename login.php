<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Login Page</title>
</head>
<?php
    session_start();

    require_once 'connection.php';
    require_once 'functions.php';

    $msg = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // The Parameter data from connection file
        $conn = new mysqli($server, $user_name, $password, $database);
        if ($conn->connect_error) die($msg = "Database NOT Found!");

        $email = $_POST['email'];
        $pword = $_POST['password'];

        if(empty($email)){
            header("Location: login.php?error=Email is required");
            exit();
        }else if(empty($pword)) {
            header("Location: login.php?error=Password is required");
            exit();
        } else {
            //The function to sanitise the inputs comes from functions.php
            if (isset($_POST['email']) && isset($_POST['password'])){
                $email = mysql_entities_fix_string($conn, $email);
                $pass = mysql_entities_fix_string($conn, $pword);
    
                $query = "SELECT * FROM tb_form WHERE email='$email'";
                $result = $conn->query($query);
        
                if (!$result) die($msg = "User not found");
                else if ($result->num_rows){
                    $row = mysqli_fetch_assoc($result);
                    $result->close();
        
                    if (password_verify($pass, $row['password'])) {
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        die ("<p><a href='dashboard.php'>Click here to continue</a></p>");
                    }
                    else {
                        header("Location: login.php?error=Invalid email/password");
                        exit();
                    }
                }
                else {
                    header("Location: login.php?error=Incorrect email/password");
                    exit();
                }
            }
            else{
                header('WWW-Authenticate: Basic realm="Restricted Area"');
                header('HTTP/1.0 401 Unauthorized');
                die ("Please enter your username and password");
            }
        }
    
        $conn->close();
    }

?>
<body>
    <div class="login-container">
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error'] ?></p>
        <?php } ?>
        <?php if(isset($_GET['msg'])) { ?>
            <p class="success"><?php echo $_GET['msg'] ?></p>
        <?php } ?>    

        <div class="message"><?php print $msg ?></div>
        <div class="input">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="input">
            <label for="pword">Password</label>
            <input type="password" name="password" id="pword">
        </div>
        <button type="submit">Submit</button>  
    </form>
    </div>
</body>
</html>