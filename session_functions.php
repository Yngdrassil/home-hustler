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
            echo " <li><a class='nav-link js-scroll-trigger' href='#'>My Account</a></li>
                   <li><a class='nav-link js-scroll-trigger' href='logout.php'>Logout</a></li> ";
        }
        else {
            echo " <li><a class='nav-link js-scroll-trigger' href='register/register.php'>Sign Up</a></li>
                   <li><a class='nav-link js-scroll-trigger' href='login/login.php'>Login</a></li> ";
        }
    }

 ?>
