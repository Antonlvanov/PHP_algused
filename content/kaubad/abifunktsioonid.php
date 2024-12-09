<?php
require ('conf/conf2zone.php');
global $yhendus;

$sql_kaubagrupid = "CREATE TABLE IF NOT EXISTS kaubagrupid ( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    grupinimi VARCHAR(255) 
)";

// Выполнение запроса на создание таблицы kaubagrupid
if ($yhendus->query($sql_kaubagrupid) === TRUE) {
    echo "Table kaubagrupid created successfully.\n";
} else {
    echo "Error creating table kaubagrupid: " . $yhendus->error . "\n";
}

// SQL запрос для создания таблицы kaubad
$sql_kaubad = "CREATE TABLE IF NOT EXISTS kaubad ( 
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    nimetus VARCHAR(255), 
    kaubagrupi_id INT, 
    hind DECIMAL(10, 2),
    FOREIGN KEY (kaubagrupi_id) REFERENCES kaubagrupid(id)
)";

// Выполнение запроса на создание таблицы kaubad
if ($yhendus->query($sql_kaubad) === TRUE) {
    echo "Table kaubad created successfully.\n";
} else {
    echo "Error creating table kaubad: " . $yhendus->error . "\n";
}

// Закрытие соединения с базой данных
$yhendus->close();
?>

function kysiKaupadeAndmed($sorttulp="nimetus", $otsisona=""){
    global $yhendus;
    $lubatudtulbad=array("nimetus", "grupinimi", "hind");
    if(!in_array($sorttulp, $lubatudtulbad)){
        return "lubamatu tulp";
    }
    $otsisona=addslashes(stripslashes($otsisona));
    $kask=$yhendus->prepare("SELECT kaubad.id, nimetus, grupinimi, kaubagrupi_id, hind  FROM kaubad, kaubagrupid 
 WHERE kaubad.kaubagrupi_id=kaubagrupid.id 
 AND (nimetus LIKE '%$otsisona%' OR grupinimi LIKE '%$otsisona%')  ORDER BY $sorttulp");
    //echo $yhendus->error;
    $kask->bind_result($id, $nimetus, $grupinimi, $kaubagrupi_id, $hind);  $kask->execute();
    $hoidla=array();
    while($kask->fetch()){
        $kaup=new stdClass();
        $kaup->id=$id;
        $kaup->nimetus=htmlspecialchars($nimetus);
        $kaup->grupinimi=htmlspecialchars($grupinimi);
        $kaup->kaubagrupi_id=$kaubagrupi_id;
        $kaup->hind=$hind;
        array_push($hoidla, $kaup);
    }
    return $hoidla;
}

/**
 * Luuakse HTML select-valik, kus v6etakse v22rtuseks sqllausest tulnud  * esimene tulp ning n2idatakse teise tulba oma.
 */
function looRippMenyy($sqllause, $valikunimi, $valitudid=""){
    global $yhendus;
    $kask=$yhendus->prepare($sqllause);
    $kask->bind_result($id, $sisu);
    $kask->execute();
    $tulemus="<select name='$valikunimi'>";
    while($kask->fetch()){
        $lisand="";
        if($id==$valitudid){$lisand=" selected='selected'";}
        $tulemus.="<option value='$id' $lisand >$sisu</option>";
    }
    $tulemus.="</select>";
    return $tulemus;
}
/*
 function looRippMenyy($sqllause, $valikunimi){
 global $yhendus;
 $kask=$yhendus->prepare($sqllause);
 $kask->bind_result($id, $sisu);
 $kask->execute();
 $tulemus="<select name='$valikunimi'>";
 while($kask->fetch()){
 $tulemus.="<option value='$id'>$sisu</option>";
 }
 $tulemus.="</select>";
 return $tulemus;
 }
*/

function lisaGrupp($grupinimi){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO kaubagrupid (grupinimi)  VALUES (?)");
    $kask->bind_param("s", $grupinimi);
    $kask->execute();
}

function lisaKaup($nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO  
 kaubad (nimetus, kaubagrupi_id, hind) 
 VALUES (?, ?, ?)");
    $kask->bind_param("sid", $nimetus, $kaubagrupi_id, $hind);
    $kask->execute();
}

function kustutaKaup($kauba_id){
    global $yhendus;
    $kask=$yhendus->prepare("DELETE FROM kaubad WHERE id=?");
    $kask->bind_param("i", $kauba_id);
    $kask->execute();
}

function muudaKaup($kauba_id, $nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE kaubad SET nimetus=?, kaubagrupi_id=?, hind=?  WHERE id=?");
    $kask->bind_param("sidi", $nimetus, $kaubagrupi_id, $hind, $kauba_id);  $kask->execute();
}
