<?php

    require("mysqli_connect.php");

    function getIp(){
        $ip = $_SERVER['REMOTE_ADDR'];
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $ip;
    }

    function isLoggedIn() {

        //if logged in, change navbar headers

        if(!isset($_SESSION)) {
            session_start();
        }
        if(isset($_SESSION['username'])) {
            echo " <li><a href='#'>My Account</a></li>
                   <li><a href='logout.php'>Logout</a></li> ";
        }
        else {
            echo " <li><a href='../registration/registration.php'>Signup</a></li>
                   <li><a href='login.php'>Login</a></li> ";
        }
    }

    function createSession() {
        $message = '';

        if (isset($_SESSION['username'])) {
            $message= "You are already logged in!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        else if (isset($_POST['login']) && isset($_POST['username'])
             && isset($_POST['password'])) {

             $username = mysqli_real_escape_string($_POST['username']);
             $password = mysqli_real_escape_string($_POST['password']);

             global $mysqli; // make global $mysqli usable in this function

             $query = $mysqli->prepare("SELECT password FROM user WHERE username= ?");
             $query->bind_param("s", $username);
             $query->execute();
             $result = $query->get_result();    //get hash if found

             if($result->num_rows === 0) {
               $message = "User account does not exist";    //username not in database
               echo "<script type='text/javascript'>alert('$message');</script>";
               exit();
             }

             if (password_verify($password, $result)) {
                $_SESSION['timeout'] = 3600;            //you get one hour, have fun
                $_SESSION['username'] = $username;
                echo 'Login Successful';
                header('Refresh: 1; URL = ../index.php'); /* Redirect browser */
             }
             else {
                $message = "Wrong username or password";    //wrong password
                echo "<script type='text/javascript'>alert('$message');</script>";
             }
             $query->close();
        }
         //echo session_id();
    }

 ?>
