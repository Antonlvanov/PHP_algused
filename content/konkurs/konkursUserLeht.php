<?php
include 'header.php';

//require ('connection/conf2zone.php');
require('connection/conf.php');
require ('funktsioonid.php');
global $yhendus;

?>

<form action="" id="lisa-konkurs-vorm">
    <label for="uusKonkurss">Lisa konkurss</label>
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
            echo "<td><a href='?heakonkurs_id=$id'>Lisa +1 punkt</a></td>";
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