<?php
    require("../mysqli_connect.php");

    createSession();

    function createSession() {
        session_start();
        $message = '';

        if (isset($_SESSION['username'])) {

            $query = $mysqli->prepare("SELECT user_id FROM user WHERE username= ?");
            $query->bind_param("i", $user_id);
            $query->execute();
            $query->bind_result($result);    //bind result to $result variable
            $query->fetch();                 //gets hash if username found
        }

        else if (isset($_POST['loginButton']) && isset($_POST['username'])
             && isset($_POST['password'])) {

             global $mysqli; // make global $mysqli usable in this function

             $username = mysqli_real_escape_string($mysqli, $_POST['username']);
             $password = mysqli_real_escape_string($mysqli, $_POST['password']);

             $query = $mysqli->prepare("SELECT password FROM user WHERE username= ?");
             $query->bind_param("s", $username);
             $query->execute();
             $query->bind_result($result);    //bind result to $result variable
             $query->fetch();                 //gets hash if username found

             if(empty($result)) {
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
                header('Refresh: 0; URL = ../index.php'); /* Redirect browser */
             }
             else {
                $message = "Wrong username or password";    //wrong password
                echo "<script type='text/javascript'>alert('$message');</script>";
                header('Refresh: 5; URL = ../login/login.php');
             }
             $query->close();
        }
         //echo session_id();
    }
?>
