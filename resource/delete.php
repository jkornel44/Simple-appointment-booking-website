<?php

require_once('../database/dataHandling.php');
session_start();

$user = $_SESSION['email'];

$_SESSION['email'] = $user;
deleteReservation($user);
header('Location: ../index.php?deleted=yes');