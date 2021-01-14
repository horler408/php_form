<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
<?php
    $msg = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['first_name'];
        $lName = $_POST['last_name'];
        $email = $_POST['email'];
        $pword = $_POST['password'];
        $cpword = $_POST['confirm_password'];

        $user_name = "root";
        $password = "";
        $database = "form_data";
        $server = "localhost";
        $db_handle = mysql_connect($server, $user_name, $password);
        $db_found = mysql_select_db($database, $db_handle);
        if ($db_found) {
            $SQL = "INSERT INTO tb_form (first_name, last_name, email, password) VALUES ($fname,
            $lName, $email, $pword)";
            $result = mysql_query($SQL);
            mysql_close($db_handle);
            $msg = "Records added to the database"; 
        }
        else {
            $msg = "Database NOT Found ";
            mysql_close($db_handle);
        }
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