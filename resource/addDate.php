<?php

require_once('../database/dataHandling.php');

$errors = [
        "dateRequired" =>  false,
        "dateFormat" =>  false,
        "pastDate" => false,
        "timeRequired" => false,
        "timeFormat" => false,
        "maxRequired" => false,
        "maxFormat" => false,
        "maxGreater" => false
];

session_start();

$email = $_SESSION['email'];
$date = trim($_POST['date']);
$time = trim($_POST['time']);
$max = trim($_POST['max']);

$year = (int)date('Y', strtotime($date));
$month = (int)date('m', strtotime($date));
$day = (int)date('d', strtotime($date));
list($y, $m, $d) = explode('-', $date);

if($date == "") {
    $errors["dateRequired"] = true;
    $hasError = true;
} else if(!checkdate($m, $d, $y)) {
    $errors["dateFormat"] = true;
    $hasError = true;
} else if(date("Y-m-d") > $date) {
    $errors["pastDate"] = true;
    $hasError = true;
}

if($time == "") {
    $errors["timeRequired"] = true;
    $hasError = true;
} else if(!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $time)) {
    $errors["timeFormat"] = true;
    $hasError = true;
}

if($max =="") {
    $errors['maxRequired'] = true;
    $hasError = true;
} else if(!preg_match("/^\d+$/",$max)) {
    $errors['maxFormat'] = true;
    $hasError = true;
} else if($max <= 0) {
    $errors["maxGreater"] = true;
    $hasError = true;
}


if($hasError) {
    $e =  serialize($errors);
    header('Location: ../adminpage.php?error=' . $e);
}else {
    $dateTime = $date . " " . $time;
    addDate($dateTime, $max, $month);
    $_SESSION['email'] = $email;
    header('Location: ../index.php');
}