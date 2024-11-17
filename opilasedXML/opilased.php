<?php
    $opilased_file = simplexml_load_file("opilased.xml");

    // otsing funktsioon
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
<div id="container">
    <h2>TARpv23</h2>
    <h3>Õpilaste otsing</h3>
    <div id="search-form">
        <form method="post" onsubmit="return kontroll('otsing')" action="?">
            <label for="otsing">Täisnimi / Nimi / Perakonnanimi:</label>
            <br>
            <input type="text" id="otsing" name="otsing" placeholder="Otsi nimi järgi" autofocus>
            <input type="submit" value="OK">
        </form>
    </div>
    <div class="cards">
        <?php
        // otsi õpilased
        if (!empty($_POST['otsing'])) {
            $vastus = otsiOpilane($_POST['otsing'], 'taisnimi');
            if (!empty($vastus)) {
                echo "<div class='found'>";
                foreach ($vastus as $opilane_andmed) {
                    $taisnimi = $opilane_andmed->taisnimi;
                    $veebileht = $opilane_andmed->veebileht;
                    echo "<div class='card'><a href='$veebileht' target='_blank'>$taisnimi</a></div>";
                }
                echo "</div>";
            } else {
                echo "<p class='error'>Ei leidnud!</p>";
            }
        }

        // kõik õpilased
        echo "<div class='all'>";
        foreach ($opilased_file->opilane_andmed as $opilane_andmed) {
            $taisnimi = $opilane_andmed->taisnimi;
            $veebileht = $opilane_andmed->veebileht;
            echo "<div class='card'><a href='$veebileht' target='_blank'>$taisnimi</a></div>";
        }
        echo "</div>";
        ?>
    </div>
    <h3>Õpilaste lisamine</h3>
    <div id="search-form">
        <form action="" method="post" name="add_form">
            <tr>
                <td><label for="taisnimi_sisend">Õpilaste täisnimi:</label></td>
                <td><input type="text" name="taisnimi_sisend" id="taisnimi_sisend"></td>
            </tr>
            <tr>
                <td><label for="veebileht_sisend">Veebilehe link:</label></td>
                <td><input type="text" name="veebileht_sisend" id="veebileht_sisend"></td>
            </tr>
            <tr>
                <td><label for="sugu_sisend">Sugu:</label></td>
                <td><input type="text" name="sugu_sisend" id="sugu_sisend"></td>
            </tr>
            <tr>
                <td><label for="juuksevarv_sisend">Juuksevärv:</label></td>
                <td><input type="text" name="juuksevarv_sisend" id="juuksevarv_sisend"></td>
            </tr>
            <tr>
                <td><input type="submit" name="lisa" id="lisa" value="Lisa"></td>
                <td></td>
            </tr>
        </form>

        <?php
        // Õpilaste lisamine
        if(isset($_POST["lisa"])) {
            if (!empty($_POST['taisnimi_sisend'] && $_POST['veebileht_sisend'] && $_POST['sugu_sisend'] && $_POST['juuksevarv_sisend'])) {
                $opilased_doc = new DOMDocument("1.0", "UTF-8");
                $opilased_doc->preserveWhiteSpace = false;
                $opilased_doc->load('opilased.xml');
                $opilased_doc->formatOutput = true;

                $opilased_root = $opilased_doc->documentElement;
                $uus_opilane_andmed = $opilased_doc->createElement("opilane_andmed");
                $opilased_root->appendChild($uus_opilane_andmed);

                $uus_opilane_andmed->appendChild($opilased_doc->createElement('taisnimi', htmlspecialchars($_POST['taisnimi_sisend'])));
                $uus_opilane_andmed->appendChild($opilased_doc->createElement('veebileht', htmlspecialchars($_POST['veebileht_sisend'])));
                $uus_opilane_andmed->appendChild($opilased_doc->createElement('sugu', htmlspecialchars($_POST['sugu_sisend'])));
                $uus_opilane_andmed->appendChild($opilased_doc->createElement('juuksevarv', htmlspecialchars($_POST['juuksevarv_sisend'])));

                $opilased_doc->save('opilased.xml');
                echo "<p class='ok'> Õpilane lisatud</p>";
                exit();
            }
            else {
                echo "<p class='error'>Viga</p>";
            }
        }
        ?>
    </div>
    <div><a href="opilased.xml" target="_blank">XML file</a>
    </div>
    <script>
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
