<?php
    session_start();
    $error = unserialize($_GET['error']); 

    $logged_in = isset($_SESSION['email']);
    $user = $_SESSION['email'];
    if(!$logged_in) {
        header('Location: login.php');
    } 

    $_SESSION['email'] = $user;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Időpont felvétel - Nemzeti Koronavírus Depó</title>
</head>
<body>
    <div class="page">
    <div class="header">
            <a href="index.php" id="menu"><div class="menuItem" id="reg"> Időpontok</div></a>
                <a href="resource/logout.php" id="menu"><div class="menuItem" id="logout">Kijelentkezés</div></a>
                <div class="menuItem" id="user"><?= $user ?><?= $userData['admin'] ? " [admin]" : ""?></div>
            <?php if($userData['admin']): ?>
                <a href="logout.php" id="menu"><div class="menuItem" id="admin">Új időpont meghirdetése</div></a>
            <?php endif ?>
        </div>
        <div id="welcome">
            <h1>ADMIN PAGE|<br><span>Nemzeti Koronavírus Depó</span><br> időpontok felvétele</h1>
        </div>

        <div class="container" id="adminpanel">

                <form action="resource/addDate.php" method="post">
                <input type="text" name="date" placeholder="<?= "Dátum: " . date("Y-m-d") ?>"><br>
                <p id="errorMsg"><?= $error["dateRequired"] ? "Mező megadása kötelező!" : ""?></p>
                <p id="errorMsg"><?= $error["dateFormat"] ? "Nem valid dátum" : ""?></p>
                <p id="errorMsg"><?= $error["pastDate"] ? "Nem lehet múltbeli dátum" : ""?></p>
                <input type="text" placeholder="Idő: 12:00" name="time">
                <p id="errorMsg"><?= $error["timeRequired"] ? "Mező megadása kötelező!" : ""?></p>
                <p id="errorMsg"><?= $error["timeFormat"] ? "Nem valid idő" : ""?></p>
                <input type="text" placeholder="Férőhelyek" name="max">
                <p id="errorMsg"><?= $error["maxRequired"] ? "Mező megadása kötelező!" : ""?></p>
                <p id="errorMsg"><?= $error["maxFormat"] ? "Nem egész szám" : ""?></p>
                <p id="errorMsg"><?= $error["maxGreater"] ? "Csak pozitív egész lehet" : ""?></p>
                <input type="submit" value="Felvesz" id="regButton">
                </form>

        </div>
    </div>
</body>
</html>