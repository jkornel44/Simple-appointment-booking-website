<?php

require_once('../database/dataHandling.php');
session_start();

$user = $_SESSION['email'];

if(isset($_POST['term']) && $_POST['term']) {
        $_SESSION['email'] = $user;
        if(apply($_POST['date'], $user, (int)date('m', strtotime($_POST['date'])))) header('Location: ../succes.php');
        else header('Location: ../index.php?error="apply');

} else  header('Location: ../date.php?date=' . $_POST['date']);

