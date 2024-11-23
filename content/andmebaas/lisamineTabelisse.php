<?php
require ('conf.php');
//require ('conf2zone.php');
global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["loomanimi"]) && !empty($_REQUEST["loomanimi"])){

    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, varv, omanik, pilt)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"], $_REQUEST["varv"],
    $_REQUEST["omanik"], $_REQUEST["pilt"]);
    $paring->execute();
}


//tabeli sisu kuvamine

$paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad");
$paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
$paring->execute();
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
        tr:hover {background-color: crimson;}
    </style>
<!doctype html>
<html lang="et">
<head>
    <title>Tabeli sisu, mida võetakse andmebaasist</title>
</head>
<body>
<h1>Loomad andmebaasist</h1>
<table border="2">
    <tr>
        <th></th>
        <th>id</th>
        <th>loomanimi</th>
        <th>varv</th>
        <th>omanik</th>
        <th>loomapilt</th>
    </tr>
<?php
while($paring->fetch()){
    echo "<tr>";
    echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
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

<h2>Uue looma lisamine</h2>
<table>
<!--tabeli lisamisVorm-->
    <form action="?" method="post">
        <label for="loomanimi">Loomanimi</label>
        <input type="text" id="loomanimi" name="loomanimi">
        <br>
        <label for="varv">Värv</label>
        <input type="color" id="varv" name="varv">
        <br>
        <label for="omanik">Omanik</label>
        <input type="text" id="omanik" name="omanik">
        <br>
        <label for="pilt">Pilt:</label>
        <br>
        <textarea name="pilt" id="pilt" cols="30" rows="10">
            sisesta pildi link
        </textarea>
        <input type="submit" value="OK">
    </form>
</table>
</body>
</html>
<?php
$yhendus->close();
?>
