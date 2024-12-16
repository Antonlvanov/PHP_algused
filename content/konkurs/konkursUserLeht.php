<?php
session_start();
//include 'header.php';

//require ('connection/conf2zone.php');
require('connection/conf.php');
require ('funktsioonid.php');
global $yhendus;
?>
<!doctype html>
<html lang="et">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;
maximum-scale=1.0;">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tarpv23 jõulu konkursid</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="highligher.js"></script>
</head>
<body>
<h2>Jõulu konkursid</h2>
<nav class="nav">
    <ul>
        <?php
        if (isset($_SESSION['useruid']) && isset($_SESSION['rolli'])) {
            if ($_SESSION['rolli'] == 1) {
                echo '<li><a href="konkursAdminLeht.php">Admin</a></li>';
            } else if ($_SESSION['rolli'] == 0) {
                echo '<li><a href="konkursUserLeht.php">Kasutaja</a></li>';
                echo '<li><a href="konkurss1kaupa.php">Konkursid</a></li>';
            }
            echo '<li><a href="user_handler/logout.inc.php">Logi välja (' . htmlspecialchars($_SESSION['useruid']) . ')</a></li>';
        } else {
            echo '<li><a href="login.php">Sisse loogi</a></li>';
            echo '<li><a href="signup.php">Registreeri</a></li>';
        }
        ?>
    </ul>
</nav>
<br>
<form action="" id="lisa-konkurs-vorm">
    <label for="uusKonkurss">Lisa konkurs</label>
    <input type="text" name="uusKonkurss" id="uusKonkurss">
    <input type="submit" value="Lisa">
</form>
<table border="1">
    <tr>
        <th>Konkurssi nimi</th>
        <th>Lisamisaeg</th>
        <th>Punktid</th>
        <th colspan="2">Kommentaarid</th>
        <th colspan="3">Haaldus</th>
    </tr>
    <?php
    $paring=$yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik FROM konkurss");
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid, $avalik);
    $paring->execute();
    while($paring->fetch()) {
        if ($avalik==1) {
            echo "<tr>";
            $konkursiNimi = htmlspecialchars($konkursiNimi);
            $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
            echo "<td><a href='konkurss1kaupa.php?konkurs_valik=$id'>$konkursiNimi</a></td>";
            echo "<td>$lisamisaeg</td>";
            echo "<td>$punktid</td>";
            echo "<td>$kommentaarid</td>";
            ?>
            <td>
                <form action="?">
                    <input type="hidden" name="uusKomment" value="<?=$id?>">
                    <input type="text" name="komment" id="komment">
                    <input type="submit" value="Lisa kommentaar">
                </form>
            </td>
            <?php
            echo "<td><a href='?heakonkurs_id=$id'>+1 punkt</a></td>";
            echo "<td><a href='?halbkonkurs_id=$id'>-1 punkt</a></td>";
            echo "</tr>";
        }
    }
    ?>
</table>
</body>
<?php
include 'footer.php';
?>