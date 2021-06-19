<?php
    require_once('database/dataHandling.php');
    include('resource/dataStorage.php');
    session_start();

    $logged_in = isset($_SESSION['email']);
    $user = $_SESSION['email'];
    if(!$logged_in) {
        header("Location: login.php?date=" . $_GET['date']);
    } 

    if(hasReservation($user)) {
        header('Location: ../index.php?error="apply');
    }

    $_SESSION['email'] = $user;

    
    $userStorage = new DataStorage("felhasznalok");
    $userData = $userStorage->findById($user);

    $idopontStorage = new DataStorage("idopontok");
    $dateData = $idopontStorage->findAll();

    $monthId = (int)date('m', strtotime($_GET['date']));

    function getUsersData($userId) {
        $userStorage = new DataStorage("felhasznalok");
        return $userStorage->findById($userId);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Jelentkezés - Nemzeti Koronavírus Depó</title>
</head>
<body>
    <div class="page">
    <div class="header">
            <a href="index.php" id="menu"><div class="menuItem" id="reg"> Időpontok</div></a>
            <?php if(!$logged_in): ?>
                <a href="login.php" id="menu"><div class="menuItem" id="log_in">Bejelentkezés</div></a>
                <a href="registration.php" id="menu"><div class="menuItem" id="reg"> Regisztráció</div></a>
            <?php else: ?>
                <a href="resource/logout.php" id="menu"><div class="menuItem" id="logout">Kijelentkezés</div></a>
                <div class="menuItem" id="user"><?= $user ?><?= $userData['admin'] ? " [admin]" : ""?></div>
            <?php endif ?>
        </div>
        <div id="welcome">
            <h1>Jelentkezés a <br><span><?= $_GET['date']?></span>-kor<br> elvégzendő oltásra.</h1>
            
            
            <div class="container" id="apply">
                 <table> 
                    <tr>
                        <td>Név</td>
                        <td><?= $userData['nev'] ?></td>
                    </tr>
                    <tr>
                        <td>Értesítési cím</td>
                        <td><?= $userData['cim'] ?></td>
                    </tr>
                    <tr>
                        <td>TAJ szám</td>
                        <td><?= $userData['taj'] ?></td>
                    </tr>
                 </table>   
                 <form action="resource/apply.php" method="post">
                     <input type="checkbox" name="term" value="yes" id="term">
                     <label for="term"> Elfogadom a jelentkezés feltételeit</label>
                     <input type="hidden" name="date" value="<?= $_GET['date']?>">
                     <input type="submit" value="Megerősítés" id="loginButton">
                 </form>      
        </div>  
        </div>
            <?php if($userData['admin']): ?>
                <table id="plist">
                    <tr>
                        <th>Név</th>
                        <th>TAJ szám</th>
                        <th>Email</th>
                    </tr>
                    <?php foreach( $dateData[$monthId] as $d): ?>
                        <?php if($d['date'] == $_GET['date']): ?>
                            <?php foreach( $d['patient'] as $p): ?>
                                <tr>
                                    <td><?= getUsersData($p)['nev'] ?></td>
                                    <td><?= getUsersData($p)['taj'] ?></td>
                                    <td><?= getUsersData($p)['email'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </table>
        <?php endif ?>
    </div>
</body>
</html>