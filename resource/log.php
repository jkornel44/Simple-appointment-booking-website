<?php

require_once('../database/dataHandling.php');

session_start();
if($_POST['email'] != "" && $_POST['pswd'] != "") {
    if(userExists($_POST['email']) && pswdMatch($_POST['email'],$_POST['pswd'])){
        if(isset($_SESSION['date'])) {
            $date = $_SESSION['date'];
            $_SESSION['email'] = $_POST['email'];
            header('Location: ../date.php?date=' . $date);
        } else {
            $_SESSION['email'] = $_POST['email'];
            header('Location: ../index.php');
        }
    }else{
        header('Location: ../login.php?error=authenticationError');
    }
} else  header('Location: ../login.php?error=emptyField');
