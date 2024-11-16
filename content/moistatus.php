<div id="moistatus">
    <h1>Mõistatus. Euroopa riik</h1>
    <?php
    $riik='Netherlands';
    echo "<ol>";
    echo "<li>Riigi nimes on ".strlen($riik)." tähti</li>";
    echo "<li>Esimene täht riigis on ".substr($riik,0,1)."</li>";
    echo "<li>Viimane täht riigis on ".substr($riik, -1)."</li>";

    $riikmassiiv = str_split($riik);
    $randomIndex = rand(1, count($riikmassiiv) - 2);
    echo "<li>$randomIndex. täht on ".$riikmassiiv[$randomIndex]."</li>";

    $vowelsArray = [];
    preg_match_all('/[aeiouüõäöAEIOUÜÕÄÖ]/', $riik, $vowelsArray);
    echo "<li>Riigi nimes on järgmised täishäälikud: " . implode(', ', $vowelsArray[0]) . "</li>";

    $peidetudnimi = str_repeat('*', strlen($riik));
    $rndindex1 = rand(1, strlen($riik) - 2);
    $rndindex2 = rand(1, strlen($riik) - 2);
    $peidetudnimi[$rndindex1] = $riik[$rndindex1];
    $peidetudnimi[$rndindex2] = $riik[$rndindex2];
    while ($rndindex2 === $rndindex1) {
        $rndindex2 = rand(1, strlen($riik) - 2);
    }
    echo "<li>Riigi nimi peidetud kujul: " . $peidetudnimi . "</li>";

    echo "</ol>";

    if (isset($_REQUEST["riikSisend"])){
        if (empty($_REQUEST["riikSisend"])){
            echo "Sisesta riik";
        }
        else {
            $riik_sisestatud = ($_REQUEST["riikSisend"]);
            if (strtolower($riik) === strtolower($riik_sisestatud)) {
                echo "Õige";
            } else {
                echo "Vale";
            }
        }
    };
    ?>

    <form method="post" action="">
        <input type="text" name="riikSisend" placeholder="Sisesta riik">
        <input type="submit" value="Sisesta">
    </form>
</div>
<?php
echo "<br>";
highlight_file('moistatus.php');
?>

