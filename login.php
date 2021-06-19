<?php
    session_start();
    if(isset($_GET['date'])) {
        $_SESSION['date'] = $_GET['date'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Bejelentkezés - Nemzeti Koronavírus Depó</title>
</head>
<body>
    <div class="page">
        <?php if(isset($_GET['error'])): ?>
                <div class="header" id="error"><?= $_GET['error'] == "emptyField"? "Mezők kitöltése kötelező" : "Nem megfelelő email-jelszó páros" ?></div>
        <?php endif ?>
        <div id="welcome">
            <h1>BEJELENTKEZÉS|<br><span>Nemzeti Koronavírus Depó</span></h1>
            <p>Amennyiben még nem rendelkezik az oldalon felhasználói fiókkal: <a href="registration.php"> Regisztráljon!</a></p>
        </div>

        <div class="container" id="login">
                <form action="resource/log.php" method="post">
                <label for="email">E-mail</label> <input type="text" name="email"><br>
                <label for="password">Jelszó</label> <input type="password" name="pswd">
                <input type="submit" value="Bejelentkezés" id="loginButton">
                </form>
        </div>
    </div>
</body>
</html>