<?php
    session_start(); 
    $logged_in = isset($_SESSION['email']);
    $user = $_SESSION['email']; 


    header("Refresh:5; url=index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Sikeres jelentkezés - Nemzeti Koronavírus Depó</title>
</head>
<body>
    <div class="page">
    <div class="header">
            <?php if(!$logged_in): ?>
                <a href="login.php" id="menu"><div class="menuItem" id="log_in">Bejelentkezés</div></a>
                <a href="registration.php" id="menu"><div class="menuItem" id="reg"> Regisztráció</div></a>
            <?php else: ?>
                <a href="resource/logout.php" id="menu"><div class="menuItem" id="logout">Kijelentkezés</div></a>
                <div class="menuItem" id="user"><?= $user ?></div>
            <?php endif ?>
        </div>
        <div id="welcome">
            <h1>Sikeres jelentkezés</h1>
            <p>A jelentkezés rögzítésre került! 5 másodpercen belül visszairányítunk a főoldalra.</p>
        </div>  
        </div>
    </div>
</body>
</html>