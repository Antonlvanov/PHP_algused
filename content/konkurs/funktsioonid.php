<?php

//require ('connection/conf2zone.php');
require('connection/conf.php');

global $yhendus;

if(isset($_REQUEST["uusKonkurss"])){
    $paring = $yhendus->prepare("INSERT INTO konkurss (konkursiNimi, lisamisAeg) VALUES (?, NOW())");
    $paring->bind_param("s", $_REQUEST["uusKonkurss"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if (isset($_REQUEST["uusKomment"])) {
    $komment = trim($_REQUEST["komment"]);
    if (!empty($komment)) {
        $kommentLisa = "\n" . htmlspecialchars($komment);
        $konkursiId = $_REQUEST["uusKomment"];
        $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?");
        $paring->bind_param("si", $kommentLisa, $konkursiId);
        $paring->execute();
    }
    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_REQUEST["heakonkurs_id"])){
    $kask=$yhendus->prepare("update konkurss set punktid=punktid+1
WHERE id=?");
    $kask->bind_param("i",$_REQUEST["heakonkurs_id"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
if(isset($_REQUEST["halbkonkurs_id"])){
    $kask=$yhendus->prepare("update konkurss set punktid=punktid-1
WHERE id=?");
    $kask->bind_param("i",$_REQUEST["halbkonkurs_id"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

if(isset($_REQUEST["nullidaPunktid_id"])){
    $kask=$yhendus->prepare("update konkurss set punktid=0
WHERE id=?");
    $kask->bind_param("i",$_REQUEST["nullidaPunktid_id"]);
    $kask->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

if (isset($_REQUEST["kustutaKonkurss_id"])) {
    $paring = $yhendus->prepare("DELETE FROM konkurss WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustutaKonkurss_id"]);
    $paring->execute();
}

if (isset($_REQUEST["kustKomment"])) {
    $paring = $yhendus->prepare("SELECT kommentaarid FROM konkurss WHERE id = ?");
    $paring->bind_param("i", $_REQUEST["kustKomment"]);
    $paring->execute();
    $paring->store_result();

    if ($paring->num_rows > 0) {
        $paring->bind_result($kommentaarid);
        $paring->fetch();
        if (!empty($kommentaarid)) {
            $newKommentaarid = preg_replace('/\n[^\n]*$/', '', $kommentaarid);

            $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid = ? WHERE id = ?");
            $paring->bind_param("si", $newKommentaarid, $_REQUEST["kustKomment"]);
            $paring->execute();
        }
    }
}

if(isset($_REQUEST["avamine_id"])) {
    $paring = $yhendus->prepare("SELECT avalik FROM konkurss WHERE id = ?");
    $paring->bind_param("i",$_REQUEST["avamine_id"]);
    $paring->execute();
    $paring->bind_result($avalik);
    $paring->fetch();
    $paring->free_result();

    $new_avalik = ($avalik == 1) ? 0 : 1;

    $paring_update = $yhendus->prepare("UPDATE konkurss SET avalik = ? WHERE id = ?");
    $paring_update->bind_param('ii', $new_avalik, $_REQUEST["avamine_id"]);
    $paring_update->execute();
}
