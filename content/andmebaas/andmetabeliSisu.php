<?php
require ('conf.php');

//tabeli sisu kuvamine
global $yhendus;
$paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad");
$paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
$paring->execute();
?>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
</head>
<body>
<h1>Loomad andmebaasist</h1>
<table>
    <tr>
        <th>id</th>
        <th>loomanimi</th>
        <th>varv</th>
        <th>omanik</th>
        <th>loomapilt</th>
    </tr>
<?php
while($paring->fetch()){
    echo "<tr>";
    echo "<td>".$id."</td>";
    echo "<td bgcolor='$varv'>".htmlspecialchars($loomanimi)."</td>";
    //htmlspecialchars - ei käivita sisestatud koodi <>
    echo "<td>".htmlspecialchars($varv)."</td>";
    echo "<td>".htmlspecialchars($omanik)."</td>";
    echo "<td><img src='$pilt' alt='pilt' width='100px'></td>";
    echo "</tr>";
}
?>
</table>

</body>
</html>
<?php
$yhendus->close();

