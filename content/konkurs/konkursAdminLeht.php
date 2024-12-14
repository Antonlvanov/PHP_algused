<?php
include 'header.php';

//require ('connection/conf2zone.php');
require('connection/conf.php');
require ('funktsioonid.php');
global $yhendus;

$sql = "CREATE TABLE users (
    usersId INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    usersUsername VARCHAR(128) NOT NULL,
    usersEmail VARCHAR(128) NOT NULL,
    usersPassword VARCHAR(128) NOT NULL,
    usersRealname VARCHAR(128) NOT NULL
)";

// Выполнение запроса
if ($yhendus->query($sql) === TRUE) {
    echo "Table 'users' created successfully";
} else {
    echo "Error creating table: " . $yhendus->error;
}
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
        if ($avalik == 1) { echo "<td><a href='?avamine_id=$id'>Peida</a></td>"; }
        else { echo "<td><a href='?avamine_id=$id'>Ava</a></td>"; }
        echo "</tr>";
    }
    ?>
</table>
</body>
<?php
include 'footer.php';
?>