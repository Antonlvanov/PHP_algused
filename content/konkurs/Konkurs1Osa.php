<?php
require ('conf.php');
global $yhendus;

if(isset($_REQUEST["heakonkurs_id"])){
    $kask=$yhendus->prepare("update konkurss set punktid=punktid+1
WHERE id=?");
    $kask->bind_param("i",$_REQUEST["heakonkurs_id"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["halbkonkurs_id"])){
    $kask=$yhendus->prepare("update konkurss set punktid=punktid-1
WHERE id=?");
    $kask->bind_param("i",$_REQUEST["halbkonkurs_id"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["uusKonkurss"])){
    $paring = $yhendus->prepare("INSERT INTO konkurss (konkursiNimi, lisamisAeg) VALUES (?, NOW())");
    $paring->bind_param("s", $_REQUEST["uusKonkurss"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if (isset($_REQUEST["kustutaKonkurss_id"])) {
    $paring = $yhendus->prepare("DELETE FROM konkurss WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustutaKonkurss_id"]);
    $paring->execute();
}
if (isset($_REQUEST["uusKomment"])) {
    $kommentLisa = "\n" . htmlspecialchars($_REQUEST["komment"]);
    $konkursiId = $_REQUEST["uusKomment"];
    $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?");
    $paring->bind_param("si", $kommentLisa, $konkursiId);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

?>
<!doctype html>
<html lang="et">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;
maximum-scale=1.0;">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tarpv23 jõulu konkursid</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Tarpv23 jõulu konkursid</h1>
<form action="" id="lisa-konkurs-vorm">
    <label for="uusKonkurss">Lisa konkurssi nimi</label>
    <input type="text" name="uusKonkurss" id="uusKonkurss">
    <input type="submit" value="OK">
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
    global $yhendus;
    $paring=$yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid FROM konkurss");
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid);
    $paring->execute();
    while($paring->fetch()) {
        echo "<tr>";
        $konkursiNimi = htmlspecialchars($konkursiNimi);
        $kommentaarid = nl2br(htmlspecialchars($kommentaarid));
        echo "<td>$konkursiNimi</td>";
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
        echo "<td><a href='?heakonkurs_id=$id'>Lisa +1 punkt</a></td>";
        echo "<td><a href='?halbkonkurs_id=$id'>-1 punkt</a></td>";
        echo "<td><a href='?kustutaKonkurss_id=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>
<?php
$yhendus->close();
?>