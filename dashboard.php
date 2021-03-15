<?php
    session_start();

    if (isset($_SESSION['first_name'])){
        $fname = htmlspecialchars($_SESSION['first_name']);
        $lname = htmlspecialchars($_SESSION['last_name']);

        destroy_session_and_data();
        ini_set('session.gc_maxlifetime', 60 * 60 * 24); //To destroy session after 24hrs

        echo "Welcome back $fname.<br>
            Your full name is $fname $lname.<br>";
    }
    else echo "Please <a href=authenticate2.php>click here</a> to log in.";

    function destroy_session_and_data(){
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }

    echo ini_get('session.gc_maxlifetime');
?>