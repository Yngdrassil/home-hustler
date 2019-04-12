<?php

function googleDistanceMatrix($originAddress, $originCity, $originState, $originZip) {

    $key = 'AIzaSyAdiSl1Nxhu1AhJM5jdrcgswUrAZrXUNOI';
    $origin = $originAddress . " " . $originCity . " " . $originState . " " . $originZip;
    $origin = str_replace(" ", "+", $origin);

    $destAddress = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $destCity = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $destState = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
    $destZip = filter_var($_POST['zipcode'], FILTER_SANITIZE_STRING);

    $destination = $destAddress . " " . $destCity . " " . $destState . " " . $destZip;
    $destination = str_replace(" ", "+", $destination);

    $result = @file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?key=$key&units=imperial&origins=$origin&destinations=$destination");

    // Convert JSON string to Object
    $distanceTime = json_decode($result);

    $distance = $distanceTime->rows[0]->elements[0]->distance->value;     //gets distance in meters
    $time = $distanceTime->rows[0]->elements[0]->duration->value;         //gets time in seconds

    $hours = floor($time / 3600);
    $mins = floor($time / 60 % 60);
    $secs = floor($time % 60);

    $distance = round((($distance / 1000) * 0.621371), 1);                //convert to miles
    $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);              //convert to time format

    $commuteDistanceTime = [
        "distance" => $distance,    //in miles
        "time" => $time,            //in time format
    ];

    return $commuteDistanceTime;
}

function googleStreetImage($address, $city, $state, $zipcode) {
    $key = 'AIzaSyAdiSl1Nxhu1AhJM5jdrcgswUrAZrXUNOI';
    $location = $address . " " . $city . " " . $state . " " . $zipcode;
    $size = '1080x720';
    $image = "https://maps.googleapis.com/maps/api/streetview?key=$key&location=$location&size=$size";

    if(isset($image)) {
        return $image;
    }
    else {
        return "";
    }
}

function getHoursFromTime($time) {
    $timeArray = explode(':', $time);
    $hours = ($timeArray[0] + $timeArray[1] / 60.0 + $timeArray[2] / 3600.0);
    return $hours;
}

?>
