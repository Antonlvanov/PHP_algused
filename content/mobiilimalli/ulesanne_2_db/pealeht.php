<?php
require ('configs/conf.php');
//require ('configs/conf2zone.php');
global $yhendus;

//tabeli andmete lisamine
if (isset($_REQUEST["nimetus"], $_REQUEST["sisu"]) && !empty($_REQUEST["nimetus"]) && !empty($_REQUEST["sisu"])) {
    global $yhendus;
    $aeg = date("Y-m-d H:i:s");
    $paring=$yhendus->prepare("INSERT INTO anekdoodid(nimetus, sisu, kuupaev)
VALUES (?, ?, ?)");
    $paring->bind_param("sss", $_REQUEST["nimetus"], $_REQUEST["sisu"], $aeg);
    $paring->execute();
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;
maximum-scale=1.0;">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Anekdoodi leht</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Anekdoodid</h1>
<div class="nav">
    <ul>
        <?php
        $paring=$yhendus->prepare("SELECT id, nimetus, sisu, kuupaev FROM anekdoodid");
        $paring->bind_result($id, $nimetus, $sisu, $kuupaev);
        $paring->execute();
        while ($paring->fetch()) {
            echo "<li><a href='?anekdoot_valik=$id'>" . htmlspecialchars($nimetus) . "</a></li>";
        }
        ?>
    </ul>
</div>

<div class="anekdot-div">
    <?php
    if(isset($_REQUEST["anekdoot_valik"])){
        $paring = $yhendus->prepare("SELECT id, nimetus, sisu, kuupaev FROM anekdoodid WHERE id = ?");
        $paring->bind_result($id, $nimetus, $sisu, $kuupaev);
        $paring->bind_param("i", $_REQUEST["anekdoot_valik"]);
        $paring->execute();
        if ($paring->fetch()) {
            echo "<h2>" . htmlspecialchars($nimetus) . "</h2>";
            echo "<p>" . nl2br(htmlspecialchars($sisu)) . "</p>";
            echo "<small>Lisatud: " . htmlspecialchars($kuupaev) . "</small>";
        }
    }
    if (!isset($_REQUEST["lisamine"])&& !isset($_REQUEST["anekdoot_valik"])){
        echo "<h2>Vali anekdoot!</h2>";
    }
    ?>
</div>
<?php
if (!isset($_REQUEST["lisamine"])){
    echo "<a href='?lisamine=jah' class='lisa'>Lisa uus</a>";
}
?>

<?php
if (isset($_REQUEST["lisamine"])){
?>
<h3>Anekdoodi lisamine</h3>
<form action="?" method="post">
    <table>
        <tr>
            <td><label for="nimetus">Nimetus:</label></td>
            <td><input type="text" id="nimetus" name="nimetus" required></td>
        </tr>
        <tr>
            <td><label for="sisu">Sisu:</label></td>
            <td><textarea type="text" id="sisu" name="sisu"  rows="5" cols="20"  required></textarea></td>
        </tr>
    </table>
    <input type="submit" value="Lisa">
</form>
<?php
}
?>
</body>

<footer>
    <div class="nav2">
        <?php require("jalus.php"); ?>
    </div>
</footer>
</html>
