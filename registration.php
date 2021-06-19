<?php
    session_start();
    $error = unserialize($_GET['error']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Regisztráció - Nemzeti Koronavírus Depó</title>
</head>
<body>
    <div class="page">
        <div id="welcome">
            <h1>REGISZTRÁCIÓ|<br><span>Nemzeti Koronavírus Depó</span><br> Hozd létre saját fiókodat!</h1>
            <p>Amennyiben már rendelkezik regisztrált felhasználóval, <a href="login.php"> jelentkezzen be!</a></p>
        </div>

        <div class="container" id="registration">

                <form action="resource/regist.php" method="post">
                    <input type="text" placeholder="Név" name="name"><br>
                        <p id="errorMsg"><?= $error["nameRequired"] ? "Mező megadása kötelező!" : ""?></p>
                    <input type="text" placeholder="TAJ szám" name="taj" ><br>
                        <p id="errorMsg"><?= $error["tajRequired"] ? "Mező megadása kötelező!" : ""?></p>
                        <p id="errorMsg"><?= $error["tajLength"] ? "Nem megfelelő hossz" : ""?></p>
                        <p id="errorMsg"><?= $error["tajNotNumber"] ? "Csak számot tartalmazhat" : ""?></p>
                    <input type="text" placeholder="Értesítési cím" name="address" ><br>
                        <p id="errorMsg"><?= $error["addressRequired"] ? "Mező megadása kötelező!" : ""?></p>
                    <input type="text" placeholder="Email" name="email"><br>
                        <p id="errorMsg"><?= $error["emailRequired"] ? "Mező megadása kötelező!" : ""?></p>
                        <p id="errorMsg"><?= $error["emailExists"] ? "A megadott email címmel már regisztráltak" : ""?></p>
                        <p id="errorMsg"><?= $error["emailFormat"] ? "Nem megfelelő formátum" : ""?></p>
                    <input type="password" placeholder="Jelszó" name="password1"><br>
                        <p id="errorMsg"><?= $error["passwordRequired"] ? "Mező megadása kötelező!" : ""?></p>
                    <input type="password" placeholder="Jelszó megerősítése" name="password2">
                        <p id="errorMsg"><?= $error["passwordMatch"] ? "Jelszónak egyeznie kell" : ""?></p>
                    <input type="submit" value="Regisztráció" id="regButton">
                </form>

        </div>
    </div>
</body>
</html>