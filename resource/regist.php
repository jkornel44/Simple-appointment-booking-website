<?php

require_once('../database/dataHandling.php');
$errors = [
        "nameRequired" =>  false,
        "tajRequired" =>  false,
        "tajNotNumber" => false,
        "tajLength" => false,
        "addresRequired" => false,
        "emailRequired" => false,
        "emailExists" => false,
        "emailFormat" => false,
        "passwordRequired" => false,
        "passwordMatch" => false, 
];


function code($e){
    $errors[$e] = true;
}



session_start();

$name = trim($_POST['name']);
$taj = trim($_POST['taj']);
$address = trim($_POST['address']);
$email = trim($_POST['email']);
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);


if($name =="") {
    $errors["nameRequired"] = true;
    $hasError = true;
} 

if($email =="") {
    $errors["emailRequired"] = true;
    $hasError = true;
} else if(!preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i",$email)) {
    $errors["emailFormat"] = true;
    $hasError = true;
} else if(userExists($email)) {
    $errors["emailExists"] = true;
    $hasError = true;
}

if($address =="") {
    $errors['addressRequired'] = true;
    $hasError = true;
}

if($taj =="") {
    $errors["tajRequired"] = true;
    $hasError = true;
} else if(!preg_match("/[0-9]/", $taj)) {
    $errors["tajNotNumber"] = true;
    $hasError = true;
} else if(strlen($taj) != 9) {
    $errors["tajLength"] = true;
    $hasError = true;
}


if($password1 =="") {
    $errors["passwordRequired"] = true;
    $hasError = true;
} else if($password2 != $password1 ) {
    $errors["passwordMatch"] = true;
    $hasError = true;
}
    

if($hasError) {
    $e =  serialize($errors);
    header('Location: ../registration.php?error=' . $e);
}
else {
    registration($name, $taj, $address,  $email, $password1);
    $_SESSION['email'] = $email;
    header('Location: ../login.php');
}
