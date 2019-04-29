<?php
    require("../mysqli_connect.php");

    createSession();

    function createSession() {
        session_start();
        $message = '';

        if (isset($_SESSION['username'])) {
            $message= "You are already logged in!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header('Refresh: 0; URL = ../index.html');
        }

        else if (isset($_POST['loginButton']) && isset($_POST['username'])
             && isset($_POST['password'])) {

             global $mysqli; // make global $mysqli usable in this function

             $username = mysqli_real_escape_string($mysqli, $_POST['username']);
             $password = mysqli_real_escape_string($mysqli, $_POST['password']);

             $query = $mysqli->prepare("SELECT password FROM user WHERE username= ?");
             $query->bind_param("s", $username);
             $query->execute();
             $result = $query->get_result();    //get hash if found

             if($result->num_rows === 0) {
               $message = "User account does not exist";    //username not in database
               echo "<script type='text/javascript'>alert('$message');</script>";
               header('Refresh: 0; URL = ../login/login.php');
               exit();
             }

             if (password_verify($password, $result)) {
                $_SESSION['timeout'] = 3600;            //you get one hour, have fun
                $_SESSION['username'] = $username;
                $message = "Login Successful. Welcome back $username!";
                echo "<script type='text/javascript'>alert('$message');</script>";
                header('Refresh: 0; URL = ../index.html'); /* Redirect browser */
             }
             else {
                $message = "Wrong username or password";    //wrong password
                echo "<script type='text/javascript'>alert('$message');</script>";
                header('Refresh: 0; URL = ../login/login.php');
             }
             $query->close();
        }
         //echo session_id();
    }
?>
