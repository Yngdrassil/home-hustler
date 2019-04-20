<?php
    // this file will go behind public_html folder on the hosting server
    // to prevent database credentials from being compromised
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    set_exception_handler(function($e) {
      error_log($e->getMessage());
      exit('Error connecting to database'); //Should be a message a typical user could understand
    });

    $mysqli = new mysqli("localhost", "root", "", "home-hustler");
    //modify later to match bluehost domain & credentials

    $mysqli->set_charset("utf8mb4");

?>
