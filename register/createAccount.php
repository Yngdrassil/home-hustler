<?php
    require("../mysqli_connect.php");

    createAccount();

    function createAccount() {
        $message = '';

        if (isset($_POST['registerButton'])) {
              global $mysqli;

              $username = mysqli_real_escape_string($mysqli, $_POST['username']);
              $password = mysqli_real_escape_string($mysqli, $_POST['password']);
              $email = mysqli_real_escape_string($mysqli, $_POST['email']);

              $query = $mysqli->prepare("SELECT email,username FROM user WHERE email= ? OR username = ?");
              $query->bind_param("ss", $email, $username);
              $query->execute();
              $result = $query->get_result();    //get username,email

              if($result->fetch_assoc()[0] == $email) {
                  $message = "Email address already in use";    //Email already in database
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  header('Refresh: 0; URL = ../login/login.php');
                  exit();
              }

              else if ($result->fetch_assoc()[1] == $username) {
                  $message = "Username already in use";    //username already in database
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  header('Refresh: 0; URL = ../login/login.php');
                  exit();
              }

              else {
                  $password = password_hash($password, PASSWORD_DEFAULT);
                  $query = $mysqli->prepare("INSERT INTO user(email, username, password) VALUES(?,?,?)");
                  $query->bind_param("sss", $email, $username, $password);
                  $query->execute();    //send validated information to database

                  firstSession($username);

              }
              $query->close();
        }
    }

    function firstSession($username) {
        session_start();

        if (isset($_SESSION['username'])) {
            $message= "You are already logged in!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header('Refresh: 0; URL=../index.php');
        }
        else {
          $_SESSION['timeout'] = 3600;            //you get one hour, have fun
          $_SESSION['username'] = $username;

          $message = "Account Creation Successful. Welcome to Home Hustler $username!";
          echo "<script type='text/javascript'>alert('$message');</script>";
          header('Refresh: 0; URL = ../index.html'); /* Redirect browser */
        }
    }
?>
