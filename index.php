<?php
    require_once('database/dataHandling.php');
    include('resource/dataStorage.php');
    session_start();

    $logged_in = isset($_SESSION['email']);
    $user = $_SESSION['email'];

    $monthIndex = 1;

    if (isset($_GET['month'])) {
        $monthIndex = intval($_GET['month']);
    }

    $idopontStorage = new DataStorage("idopontok");
    $dateData = $idopontStorage->findAll();

    if($logged_in) {
        $userStorage = new DataStorage("felhasznalok");
        $userData = $userStorage->findById($user);
    }

    $months = ["Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Nemzeti Koronavírus Depó - Jelentkezés védőoltásra</title>
</head>
<body>
    <div class="page">
        <?php if(isset($_GET['deleted'])): ?>
                <div class="header" id="success">A jelentkezés visszavonása sikeresen megtörtént</div>
        <?php elseif(isset($_GET['error'])): ?>
                <div class="header" id="error">A jelentkezés nem lehetséges</div>
        <?php endif ?>
        <div class="header">
            <a href="index.php" id="menu"><div class="menuItem" id="reg"> Időpontok</div></a>
            <?php if(!$logged_in): ?>
                <a href="login.php" id="menu"><div class="menuItem" id="log_in">Bejelentkezés</div></a>
                <a href="registration.php" id="menu"><div class="menuItem" id="reg"> Regisztráció</div></a>
            <?php else: ?>
                <a href="resource/logout.php" id="menu"><div class="menuItem" id="logout">Kijelentkezés</div></a>
                <div class="menuItem" id="user"><?= $user ?><?= $userData['admin'] ? " [admin]" : ""?></div>
                <?php if(hasReservation($user)): ?>
                    <div class="menuItem" id="reservation">
                        <div class="reservation">
                            <p>Aktív foglalás: <?= getReservation($user) ?> <a href="resource/delete.php">[x]</a></p>
                        </div>
                    </div>
                    
                <?php endif ?>
            <?php endif ?>
            <?php if($userData['admin']): ?>
                <a href="adminpage.php" id="menu"><div class="menuItem" id="admin">Új időpont meghirdetése</div></a>
            <?php endif ?>
        </div>

        <div id="welcome">
            <h1>Üdvözlünk a <br><span>Nemzeti Koronavírus Depó</span><br> jelentkezési oldalán!</h1>
            <p>Jelen weboldal a <b>NemKoViD - Mondj nemet a koronavírusra!</b> kampány keretében jött létre. Célunk, hogy ingyenes védőoltást biztosítsunk az arra igényt tartó személyek számára.</p>
            <p>A védőoltásra való jelentkezéshez elegendő a baloldalt található táblázatból a megfelelő időpontot kiválasztani, és regisztráció / bejelentkezés után a foglalást véglegesíteni.</p>

            <h2>Helyszín:</h2>
            <p> <b>1011. Budapest, Nekeresd utca 12-16. NemKoViD székház</b></p>
        </div>

        <div class="container" id="list">
            <div id="cont">
                
                    <?php if($dateData[$monthIndex] != NULL): ?>
                        <table>
                                <tr>
                                    <th>Időpont</th>
                                    <th>férőhelyek</th>
                                </tr>
                        <?php foreach($dateData[$monthIndex] as $d): ?>
                                <tr class="<?= Count($d['patient']) <  $d['max'] ? "vacant" : "reserved" ?>">
                                    <td><?= $d['date']?></td>
                                    <td> <?= $d['max']-Count($d['patient']) ?>/<?=$d['max']?> </td>
                                    <?php if(Count($d['patient']) < $d['max'] && !hasReservation($user)): ?>
                                        <td> <a href="date.php?date=<?= $d['date'] ?>">Jelentkezés</a></td>
                                    <?php else: ?>
                                        <td id="full">Nem foglalható</td>
                                    <?php endif ?>
                                </tr>
                        <?php endforeach?>
                        </table>
                    <?php else: ?>
                        <table><td>Nem található közétett időpont.</td></tr></table><tr>
                    <?php endif?>
            </div>
            <div id="control">
                <div id="months">
                    <a href="index.php?month=<?= $monthIndex-1 ?>" name="month">Előző</a>
                </div> 
                <div id="months"><b><?= $months[$monthIndex-1] ?></b></div> 
                <div id="months">
                    <a href="index.php?month=<?= $monthIndex+1 ?>" name="month">Következő</a>
                </div>
            </div>
        </div>
        <div class="credit">
            <p>Készítette: Juhász Kornél | i21rh2@inf.elte.hu</p>
        </div>
    </div>
</body>
</html>