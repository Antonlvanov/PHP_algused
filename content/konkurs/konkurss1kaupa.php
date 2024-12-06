<?php
require ('conf.php');
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
</head>
<body>
<h1>Tarpv23 jõulu konkursid</h1>
<nav class="nav">
    <ul>
        <li><a href="konkursAdminLeht.php">Admin</a></li>
        <li><a href="konkursUserLeht.php">Kasutaja</a></li>
        <li><a href="konkurss1kaupa.php">Info</a></li>
    </ul>
</nav>
<br>
<nav class="konkursid">
    <ul>
        <?php
        global $yhendus;
        $paring=$yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik FROM konkurss");
        $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid, $avalik);
        $paring->execute();
        while ($paring->fetch()) {
            echo "<li><a href='?konkurs_valik=$id'>" . htmlspecialchars($konkursiNimi) . "</a></li>";
        }
        ?>
    </ul>
</nav>
<?php
if (isset($_REQUEST["konkurs_valik"])) {
    $paring = $yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik FROM konkurss WHERE id = ?");
    $paring->bind_param("i", $_REQUEST["konkurs_valik"]);
    $paring->bind_result($id, $konkursiNimi, $lisamisaeg, $punktid, $kommentaarid, $avalik);
    $paring->execute();

    echo "<div class='konkurs-div'>";
    if ($paring->fetch()) {
        echo "<h3>" . htmlspecialchars($konkursiNimi) . "</h3>";
        echo "<p><strong>Punktid:</strong> " . htmlspecialchars($punktid) . "</p>";
        echo "<p><strong>Komentaarid:</strong><br>" . nl2br(htmlspecialchars($kommentaarid)) . "</p>";
        echo "<p><strong>Lisatud:</strong> " . htmlspecialchars($lisamisaeg) . "</p>";
        echo "<p><strong>Status:</strong> " . ($avalik == 1 ? "Avalik" : "Peidetud") . "</p>";
    } else {
        echo "<p>Konkurss ei leitud!</p>";
    }
    echo "</div>";
}
?>

</body>
</html>