<div id="ajafunk">
    <h2>Ajafunktsioonid</h2>
    <?php
    echo "Täna on ".date("d.m.Y")."<br>";
    date_default_timezone_set("Europe/Tallinn");
    echo "<strong>";
    echo "Tänane Tallinna kuupäev ja kellaeg on ".date("d.m.Y G:i", time())."<br>";
    echo "</strong>";
    echo "<br>";
    echo "date('d.m.Y G:i'), time()";
    echo "<br>";
    echo "d - kuupäev 1-31";
    echo "<br>";
    echo "m - kuu numbrina 1-12";
    echo "<br>";
    echo "y - aasta neljakohane";
    echo "<br>";
    echo "G - tunniformaat 0 - 23";
    echo "<br>";
    echo "i - minutid 0 - 59";
    echo "<br>";
    ?>
</div>
<div id="hooaeg">
    <h3>Väljenda vastavalt hooajale pilt</h3>
    <?php
    $today = new DateTime();
    echo "Täna on " .$today->format('m-d-Y ');
    echo "<br>";
    /* hooaja pinktid */
    $spring = new DateTime('March 20');
    $summer = new DateTime('June 21');
    $autumn = new DateTime('September 22');
    $winter = new DateTime('December 22');
    $tanaon = "";

    switch (true) {
        case ($today>=$spring && $today<$summer):
            $tanaon = "Kevad";
            $picture='content/img/spring.jpg';
            break;
        case ($today>=$summer && $today<$autumn):
            $tanaon = "Suvi";
            $picture='content/img/summer.jpg';
            break;
        case ($today>=$autumn && $today<$winter):
            $tanaon = "Sügis";
            $picture='content/img/autumn.jpg';
            break;
        case ($today>=$winter && $today<$spring):
            $tanaon = "Talv";
            $picture='content/img/winter.jpg';
            break;
        default:
            exit();
    }
    echo "<strong>".$tanaon;
    echo "</strong>";
    echo "<br>";
    ?>
    <img src="<?=$picture?>" alt="hooaja pilt">
</div>
<div id="koolivaheag">
    <h3>Mitu päeva on koolivaheajani 23.12.24</h3>
    <?php
    $k_date = date_create_from_format('d.n.Y', '23.12.2024');
    $date=date_create();
    $datediff=date_diff($k_date,$date);
    echo "Jääb ".$datediff->format("%a")." päeva";
    echo "<br>";
    echo "Jääb ".$datediff->days." päeva";
    ?>
</div>
<div id="musunnipaev">
    <h3>Mu sünnipaev</h3>
    <?php
    $k_date = date_create_from_format('d.n.Y', '19.02.2025');
    $date=date_create();
    $datediff=date_diff($k_date,$date);
    echo "Jääb ".$datediff->format("%a")." päeva";
    echo "<br>";
    echo "Jääb ".$datediff->days." päeva";
    ?>
</div>
<div id="vanus">
    <h3>Vanuse leidmine</h3>
    <form method="post" action="">
        Sisesta sünnipäev
        <input type="date" name="synd" placeholder="dd.mm.yyyy">
        <input type="submit" value="OK">
    </form>
    <?php
    if (isset($_REQUEST["synd"])){
        $date=date_create();
        if (empty($_REQUEST["synd"])){
            echo "Sisesta andmed";
        }
        else {
            $input_date = date_create($_REQUEST["synd"]);
            $datediff=date_diff($input_date,$date);
            echo "Sa oled ".$datediff->format("%y")." aastat vana";
        }
    };
    ?>
</div>
<div>
    <br>
    <strong>Massivi abil näidata kuu nimega</strong>
    <br>
    <?php
    $massiiv = ["0","Jaanuar", "Veebruar", "Märts", "Aprill", "Mai", "Juuni", "Juuli", "August", "September", "Oktoober", "November", "Detsember"];
    $date=date_create();
    echo "Täna on ".$date->format("j").". ".$massiiv[$date->format("m")]." ".$date->format("Y");
    ?>
</div>

<?php
highlight_file('ajafunktsioonid.php');
?>