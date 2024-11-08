<?php
echo "<h1>Mõistatus. Euroopa riik</h1>";

$riik='Netherlands';
echo "<ol>";
echo "<li>Riigi nimes on ".strlen($riik)." tähti</li>";
echo "<li>Esimene täht riigis on ".substr($riik,0,1)."</li>";
echo "<li>Viimane täht riigis on ".substr($riik, -1)."</li>";

$riikmassiiv = str_split($riik);
$randomIndex = rand(0, count($riikmassiiv) - 1);
echo "<li>$randomIndex. täht on ".$riikmassiiv[$randomIndex]."</li>";

echo "</ol>";
//str_replace();

hightlight_file('moistatus.php');

