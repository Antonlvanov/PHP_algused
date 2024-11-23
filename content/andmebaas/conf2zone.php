<?php
//zone kasutaja jaoks conf fail
$serverinimi="d132031.mysql.zonevs.eu";
$kasutaja="d132031_anton";
$parool="Madiets420";
$andmebaas="d132031_anton";

$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");