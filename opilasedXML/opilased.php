<?php
    $opilased_file = simplexml_load_file("opilased.xml");

    // õpilaste otsing funktsioon
    function otsiOpilane($otsing, $kriterium){
        global $opilased_file;
        $leitud = array();
        $otsing = strtolower(trim($otsing));

        foreach ($opilased_file->opilane_andmed as $opilane_andmed) {
            $var = strtolower(trim($opilane_andmed->$kriterium));

            if ($var === $otsing) {
                $leitud[] = $opilane_andmed;
            } elseif (strpos($var, " ") !== false) {
                $nimi_split = explode(" ", $var);
                if (in_array($otsing, $nimi_split, true)) {
                    $leitud[] = $opilane_andmed;
                }
            }
        }
        return $leitud;
    }
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Õpilaste otsing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div>
    <h2>TARpv23 rühmaleht</h2>
    <h3>Õpilaste otsing</h3>
    <div id="search-form">
        <form method="post" onsubmit="return kontroll('otsing')" action="?">
            <label for="otsing">Täisnimi / Nimi / Perakonnanimi:</label>
            <br>
            <input type="text" id="otsing" name="otsing" placeholder="Otsi nimi järgi" autofocus>
            <input type="submit" value="OK">
        </form>
    </div>
    <div class="opilased">
        <?php
        // näitab leitud õpilane
        if (!empty($_POST['otsing'])) {
            $vastus = otsiOpilane($_POST['otsing'], 'taisnimi');
            if (!empty($vastus)) {
                echo "<div class='found'>";
                foreach ($vastus as $opilane_andmed) {
                    $taisnimi = $opilane_andmed->taisnimi;
                    $veebileht = $opilane_andmed->veebileht;
                    echo "<div class='opilane'><a href='$veebileht' target='_blank'>$taisnimi</a></div>";
                }
                echo "</div>";
            } else {
                echo "<p class='error'>Ei leitud!</p>";
            }
        }

        // näitab kõik õpilased
        echo "<div class='koik'>";
        foreach ($opilased_file->opilane_andmed as $opilane_andmed) {
            $taisnimi = $opilane_andmed->taisnimi;
            $veebileht = $opilane_andmed->veebileht;
            $sugu = strtolower($opilane_andmed->sugu); // saada õpilase sugu
            // Lisage klass sõltuvalt soost
            $_sugu = ($sugu === 'mees') ? 'male' : 'female';
            echo "<div class='opilane $_sugu'><a href='$veebileht' target='_blank'>$taisnimi</a></div>";
        }
        echo "</div>";
        ?>
    </div>

    <h3>Õpilaste lisamine</h3>
    <div id="lisa-opilane-form">
        <form action="" method="post" name="add_form">
            <div class="form-row">
                <label for="taisnimi_sisend">Õpilaste täisnimi:</label>
                <input type="text" name="taisnimi_sisend" id="taisnimi_sisend">
                <label for="sugu_sisend">Sugu:</label>
                <input type="text" name="sugu_sisend" id="sugu_sisend">
            </div>
            <div class="form-row">
                <label for="veebileht_sisend">Veebilehe link:</label>
                <input type="text" name="veebileht_sisend" id="veebileht_sisend">
                <label for="juuksevarv_sisend">Juuksevärv:</label>
                <input type="text" name="juuksevarv_sisend" id="juuksevarv_sisend">
            </div>
            <div class="form-row-button">
                <input type="submit" name="lisa" id="lisa" value="Lisa">
            </div>
        </form>

        <?php
        // Kood uute õpilaste faili lisamiseks
        if(isset($_POST["lisa"])) {
            if (
                !empty($_POST['taisnimi_sisend']) &&
                !empty($_POST['veebileht_sisend']) &&
                !empty($_POST['sugu_sisend']) &&
                !empty($_POST['juuksevarv_sisend'])
            ) {
                $opilased_doc = new DOMDocument("1.0", "UTF-8");
                $opilased_doc->preserveWhiteSpace = false;
                $opilased_doc->load('opilased.xml');
                $opilased_doc->formatOutput = true;

                $opilased_root = $opilased_doc->documentElement;

                if (isNotDublicate($opilased_root)) {
                    $uus_opilane_andmed = $opilased_doc->createElement("opilane_andmed");
                    $opilased_root->appendChild($uus_opilane_andmed);

                    $uus_opilane_andmed->appendChild($opilased_doc->createElement('taisnimi', htmlspecialchars($_POST['taisnimi_sisend'])));
                    $uus_opilane_andmed->appendChild($opilased_doc->createElement('veebileht', htmlspecialchars($_POST['veebileht_sisend'])));
                    $uus_opilane_andmed->appendChild($opilased_doc->createElement('sugu', htmlspecialchars($_POST['sugu_sisend'])));
                    $uus_opilane_andmed->appendChild($opilased_doc->createElement('juuksevarv', htmlspecialchars($_POST['juuksevarv_sisend'])));

                    $opilased_doc->save('opilased.xml');
                    echo "<p class='ok'>Õpilane lisatud</p>";
                    exit();
                }
                else {
                    echo "<p class='error'>Selline õpilane on juba olemas</p>";
                }
            }
            else {
                echo "<p class='error'>Viga</p>";
            }
        }
        // andmete dubleerimine kontroll
        function isNotDublicate($opilased_root) {
            $uus_taisnimi = htmlspecialchars($_POST['taisnimi_sisend']);
            $uus_veebileht = htmlspecialchars($_POST['veebileht_sisend']);
            $uus_sugu = htmlspecialchars($_POST['sugu_sisend']);
            $uus_juuksevarv = htmlspecialchars($_POST['juuksevarv_sisend']);
            foreach ($opilased_root->getElementsByTagName('opilane_andmed') as $opilane_andmed) {
                $leitud_taisnimi = $opilane_andmed->getElementsByTagName('taisnimi')->item(0)->nodeValue;
                $leitud_veebileht = $opilane_andmed->getElementsByTagName('veebileht')->item(0)->nodeValue;
                $leitud_sugu = $opilane_andmed->getElementsByTagName('sugu')->item(0)->nodeValue;
                $leitud_juuksevarv = $opilane_andmed->getElementsByTagName('juuksevarv')->item(0)->nodeValue;

                if (
                    $leitud_taisnimi === $uus_taisnimi &&
                    $leitud_veebileht === $uus_veebileht &&
                    $leitud_sugu === $uus_sugu &&
                    $leitud_juuksevarv === $uus_juuksevarv
                ) {
                    return false;
                }
            }
            return true;
        }
        ?>
    </div>
    <h3>Kood</h3>
    <div class="failid">
        <form method="post">
            <button type="submit" name="action" value="php">PHP</button>
            <button type="submit" name="action" value="xml">XML</button>
            <button type="submit" name="action" value="css">CSS</button>
        </form>
    </div>
    <?php
    // koodi kuvamiseks faili valimine
    $file = null;
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'php') {
            $file = 'opilased.php';
        } elseif ($_POST['action'] == 'xml') {
            $file = 'opilased.xml';
        } elseif ($_POST['action'] == 'css') {
            $file = 'style.css';
        }
    }
    ?>
    <?php
    // faili koodi kuvamine
    if ($file) {
        echo "<div id='code'>";
        echo "<h3>$file</h3>";
        highlight_file($file);
        echo "</div>";
    }
    ?>
    <script>
        // skript tühjade väljade kontrollimiseks
        function kontroll(field) {
            const name = document.getElementById(field).value;
            if (name == "") {
                alert("Sisesta andmed");
                return false;
            }
            return true;
        }
    </script>
</div>
</body>
</html>
