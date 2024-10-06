<?php

function getCurrentDate() {

    date_default_timezone_set("Asia/Kolkata"); // Set timezone to India
    $date = date("Y-m-d");
    return $date;

}

function getCurrentTime() {

    date_default_timezone_set("Asia/Kolkata"); // Set timezone to India
    $time = date("H:i:s");
    return $time;
    
}

function getCurrentHour() {

    date_default_timezone_set("Asia/Kolkata"); // Set timezone to India
    $hour = date("h");
    return $hour;
    
}

?>