<?php
require ('conf.php');
global $yhendus;
$paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad");
$paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
$paring->execute();
//
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM loomad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["uusloom"]) && !empty($_REQUEST["loomanimi"])){

    $paring=$yhendus->prepare("INSERT INTO loomad(loomanimi, varv, omanik, pilt)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"], $_REQUEST["varv"],
        $_REQUEST["omanik"], $_REQUEST["pilt"]);
    $paring->execute();
}
?>
<!doctype html>
<html lang="et">
<head>
    <title>Loomad 1 kaupa</title>
</head>
<body>
<h1>Loomad 1 kaupa</h1>
<div id="meny">

<ul>
    <?php
    // loomade nimed andmebassist
    while($paring->fetch()){
        echo "<li><a href='?looma_id=$id'>".$loomanimi."</li>";
    }

    ?>
</ul>
    <?php
    echo "<a href='?lisamine=jah'>Lisa..</a>"
    ?>

</div>
<div id="sisu">
    <?php
    //kui klik looma nimele, siis näitame looma info
    if(isset($_REQUEST["looma_id"])){
        $paring=$yhendus->prepare("SELECT id, loomanimi, omanik, varv, pilt FROM loomad WHERE id = ?");
        $paring->bind_result($id, $loomanimi, $omanik, $varv, $pilt);
        $paring->bind_param("i", $_REQUEST["looma_id"]);
        $paring->execute();
        // näitame ühe kaupa
        if($paring->fetch()){
            echo "<div style='background-color:$varv;' > Loomanimi: ".$loomanimi;
            echo "<br> Tõug: ".$varv;
            echo "<br><img src='$pilt' width='100px' alt='pilt'>";
            echo "<br>Omanik: ".$omanik;
            echo "<br><a href='?kustuta=$id'>Kustuta</a>";
            echo "</div>";
        }
    }
    ?>

</div>

<?php
// lisamisvorm, mis avatakse kui vajatatud lisa...
if (isset($_REQUEST["lisamine"])){
?>
    <form action="?" method="post">
        <input type="hidden" value="jah" name="uusloom">
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

<?php
}
?>

</body>
</html>