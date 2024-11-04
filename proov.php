<?php
echo "Tere hommikust!";
echo "<br>";
$muutuja="Muutuja";
echo "<strong>";
echo $muutuja;
// tekstifunktsioonid
echo "<h2> Tekstifunktsioonid </h2>";
$tekst = "Esmaspäev on 4. november";
echo "<br>";

echo mb_strtoupper($tekst);
echo "<br>";

echo strtolower($tekst);
echo "<br>";

echo ucwords($tekst);
echo "<br>";

//tekstipikkus
echo "Tekstipikkus - ".strlen($tekst);
echo "<br>";

//eraldame esimesed 5 tähte
echo "Esimesed 5 tähte - ".substr($tekst, 0, 5);
echo "<br>";

//leiame on positsiooni
$otsing="on";
echo "'on' asukoht lauses - ".strpos($tekst, $otsing);
echo "<br>";
echo "<br>";

// eralda esimene sõna alates "on"
echo substr($tekst, 0, strpos($tekst, $otsing));
echo "<br>";

// eralda esimene sõna alates "on"
echo substr($tekst, strpos($tekst, $otsing));
echo "<br>";
echo "<h2> Kasutame veebis kasutavaid näidised</h2>";
echo "<br>";

echo "sõnade arv lauses - ".str_word_count($tekst);
echo "<br>";
// Iseseisvalt
// kärpimine
$tekst2="Põhitoetus võetakse ära 11.11 kui võlgnevused ei ole parandatud.";
echo trim($tekst2, "A, a, w");

echo "<br>";

// tekst kui massiiv

