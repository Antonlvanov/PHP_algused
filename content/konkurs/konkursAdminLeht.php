<?php
require ('conf.php');
global $yhendus;

if(isset($_REQUEST["nullidaPunktid_id"])){
    $kask=$yhendus->prepare("update konkurss set punktid=0
WHERE id=?");
    $kask->bind_param("i",$_REQUEST["nullidaPunktid_id"]);
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
if (isset($_REQUEST["kustKomment"])) {
    $paring = $yhendus->prepare("SELECT kommentaarid FROM konkurss WHERE id = ?");
    $paring->bind_param("i", $_REQUEST["kustKomment"]);
    $paring->execute();
    $paring->store_result();

    if ($paring->num_rows > 0) {
        $paring->bind_result($kommentaarid);
        $paring->fetch();
        if (!empty($kommentaarid)) {
            $newKommentaarid = preg_replace('/\n[^\n]*$/', '', $kommentaarid);

            $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid = ? WHERE id = ?");
            $paring->bind_param("si", $newKommentaarid, $_REQUEST["kustKomment"]);
            $paring->execute();
        }
    }
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
    <nav class="nav">
        <ul>
            <li><a href="konkursAdminLeht.php">Admin</a></li>
            <li><a href="konkursUserLeht.php">Kasutaja</a></li>
        </ul>
    </nav>
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
                <form action="?" method="get">
                    <input type="hidden" name="kustKomment" value="<?=$id?>">
                    <input type="submit" value="Kustuta kommentaar">
                </form>
            </td>
            <?php
            echo "<td><a href='?nullidaPunktid_id=$id'>Nullida punktid</a></td>";
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