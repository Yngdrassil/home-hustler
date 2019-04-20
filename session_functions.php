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
        $msg = '';

        if (isset($_SESSION['username'])) {
            $msg= "You are already logged in!";
        }

        else if (isset($_POST['login']) && isset($_POST['username'])
             && isset($_POST['password'])) {

             $username = mysqli_real_escape_string($con, $_POST['username']);
             $password = mysqli_real_escape_string($con, $_POST['password']);

             $password = password_hash($password, PASSWORD_DEFAULT);

             global $con; // make global $con usable in this function
             $get_hash = "SELECT password FROM user WHERE username='$username' AND password='$password'";

             $hash = mysqli_query($con, $get_hash);

             if (password_verify($password, $hash)) {
               session_regenerate_id();
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = 3600;
                $_SESSION['username'] = $username;
                echo 'Login Successful';
                header('Refresh: 1; URL = ../index.php'); /* Redirect browser */
             }
             else {
                $msg = 'Wrong username or password';
             }
        }
         //echo session_id();
    }

 ?>
