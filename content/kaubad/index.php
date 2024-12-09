<?php
require("abifunktsioonid.php");
$sorttulp="nimetus";
$otsisona="";
if(isSet($_REQUEST["sort"])){
    $sorttulp=$_REQUEST["sort"];
}
if(isSet($_REQUEST["otsisona"])){
    $otsisona=$_REQUEST["otsisona"];
}
$kaubad=kysiKaupadeAndmed($sorttulp, $otsisona);

if(isSet($_REQUEST["grupilisamine"])){
    lisaGrupp($_REQUEST["uuegrupinimi"]);
    header("Location: index.php");
    exit();
}
if(isSet($_REQUEST["kaubalisamine"])){
    lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);  header("Location: index.php");
    exit();
}
if(isSet($_REQUEST["kustutusid"])){
    kustutaKaup($_REQUEST["kustutusid"]);
}
if(isSet($_REQUEST["muutmine"])){
    muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
        $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);  }
?>

<!doctype html>
<html lang="et">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;
maximum-scale=1.0;">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kaupade leht</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>Kaupade leht</h1>

<div>
    <form action="index.php">
        Otsi: <input type="text" name="otsisona" />
        <h2>Kaupade loetelu</h2>
        <table>
            <tr>
                <th><a href="index.php?sort=nimetus">Nimetus</a></th>
                <th><a href="index.php?sort=grupinimi">Kaubagrupp</a></th>
                <th><a href="index.php?sort=hind">Hind</a></th>
                <th>Haaldamine</th>
            </tr>
            <?php foreach($kaubad as $kaup): ?>
                <tr>
                        <td><?=$kaup->nimetus ?></td>
                        <td><?=$kaup->grupinimi ?></td>
                        <td><?=$kaup->hind ?></td>
                    <?php if(isSet($_REQUEST["muutmisid"]) &&
                        intval($_REQUEST["muutmisid"])==$kaup->id): ?>  <td>
                        <input type="submit" name="muutmine" value="Muuda" />  <input type="submit" name="katkestus" value="Katkesta" />  <input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />  </td>
                        <td><input type="text" name="nimetus" value="<?=$kaup->nimetus ?>" /></td>  <td><?php
                            echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",   "kaubagrupi_id", $kaup->kaubagrupi_id);  ?></td>
                        <td><input type="text" name="hind" value="<?=$kaup->hind ?>" /></td>  <?php else: ?>
                        <td><a href="index.php?kustutusid=<?=$kaup->id ?>"  onclick="return confirm('Kas ikka soovid kustutada?')">Kustuta</a>  <a href="index.php?muutmisid=<?=$kaup->id ?>">Muuda</a>  </td>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>
</div>

<div>
    <form action="index.php">
        <h2>Kauba lisamine</h2>
            <dl class="form">
                <dt>Nimetus: <input type="text" name="nimetus" /> </dt>
                <dt>Kaubagrupp:<?php
                    echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",   "kaubagrupi_id");
                    ?></dt>
                <dt>Hind:<input type="text" name="hind" /></dt>
            </dl>
            <input type="submit" name="kaubalisamine" value="Lisa kaup" />
        <h2>Grupi lisamine</h2>
            <input type="text" name="uuegrupinimi" />
            <input type="submit" name="grupilisamine" value="Lisa grupp" />
    </form>
</div>


