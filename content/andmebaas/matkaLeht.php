<?php
require ('conf.php');
//require ('conf2zone.php');
global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}
//tabeli andmete lisamine
if(isset($_REQUEST["nimi"]) && !empty($_REQUEST["nimi"])){
    $paring=$yhendus->prepare("INSERT INTO osalejad(nimi, telefon, pilt, synniaeg)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["pilt"], $_REQUEST["synniaeg"]);
    $paring->execute();
}
function kalk($birthDate) {
    $synnipaev = new DateTime($birthDate);
    $current = new DateTime();
    $vanus = $synnipaev->diff($current);
    return $vanus->y;
}
?>
<style>
    table {
        border-collapse: collapse;
        width: 50%;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
</style>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
</head>
<body>
<h1>Matkal osalejad</h1>
<table border="1">
    <tr>
        <th></th>
        <th>id</th>
        <th>nimi</th>
        <th>telefon</th>
        <th>pilt</th>
        <th>synniaeg</th>
        <th>vanus</th>
    </tr>
    <?php
    $paring=$yhendus->prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
    $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
    $paring->execute();
    while($paring->fetch()){
        $vanus = kalk($synniaeg);
        echo "<tr>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "<td>".$id."</td>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".htmlspecialchars($telefon)."</td>";
        echo "<td><img src='$pilt' alt='pilt' width='100px'></td>";
        echo "<td>".htmlspecialchars($synniaeg)."</td>";
        echo "<td>".$vanus."</td>";
        echo "</tr>";
    }
    ?>
</table>

<h2>Osaleja lisamine</h2>
<form action="?" method="post">
    <table>
        <tr>
            <td><label for="nimi">Nimi:</label></td>
            <td><input type="text" id="nimi" name="nimi" required></td>
        </tr>
        <tr>
            <td><label for="telefon">Telefon:</label></td>
            <td><input type="text" id="telefon" name="telefon" required></td>
        </tr>
        <tr>
            <td><label for="pilt">Pilt:</label></td>
            <td><textarea id="pilt" name="pilt" rows="3" cols="30" required></textarea></td>
        </tr>
        <tr>
            <td><label for="synniaeg">Synniaeg:</label></td>
            <td><input type="date" id="sünniaeg" name="synniaeg" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Lisa">
            </td>
        </tr>
    </table>
</form>

</body>
</html>
<?php
$yhendus->close();
?>
<footer>
    <?php
    echo "Anton I &copy;";
    echo date('Y');
    ?>
    <br>
    <a href="https://antonivanov23.thkit.ee/wp/php-mysql-andmebaasiga-tootamine/">Wordpress</a>
</footer>

