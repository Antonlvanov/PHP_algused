<?php
//zone kasutaja jaoks conf fail s
$serverinimi="d132031.mysql.zonevs.eu";
$kasutaja="d132031_anton";
$parool="**********";
$andmebaas="d132031_anton";

$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");