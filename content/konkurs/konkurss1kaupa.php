<?php
include 'header.php';

//require ('connection/conf2zone.php');
require('connection/conf.php');
global $yhendus;
?>
<br>
<h3>Konkursid</h3>
<nav class="konkursid">
    <ul>
        <?php
        $paring=$yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik FROM konkurss");
        $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid, $avalik);
        $paring->execute();
        while ($paring->fetch()) {
            echo "<li><a href='?konkurs_valik=$id'>" . htmlspecialchars($konkursiNimi) . "</a></li>";
        }
        $paring->close();
        ?>
    </ul>
</nav>
<br>
<?php
if (isset($_REQUEST["konkurs_valik"])) {
    $paring = $yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik FROM konkurss WHERE id = ?");
    $paring->bind_param("i", $_REQUEST["konkurs_valik"]);
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid, $avalik);
    $paring->execute();

    echo "<div class='konkurs-div'>";
    if ($paring->fetch()) {
        echo "<p><strong>Nimetus: " . htmlspecialchars($konkursiNimi) . "</strong> ";
        echo "<p><strong>Punktid: </strong> " . htmlspecialchars($punktid) . "</p>";
        echo "<p><strong>Komentaarid:</strong><br>" . nl2br(htmlspecialchars($kommentaarid)) . "</p>";
        echo "<p><strong>Lisatud:</strong> " . htmlspecialchars($lisamisaeg) . "</p>";
        echo "<p><strong>Status:</strong> " . ($avalik == 1 ? "Avalik" : "Peidetud") . "</p>";
    } else {
        echo "<p>Konkurss ei leitud!</p>";
    }
    echo "</div>";
    $paring->close();
}
?>
<br>
</body>
<?php
include 'footer.php';
?>