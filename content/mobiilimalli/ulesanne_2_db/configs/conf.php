<?php
$kasutaja="anton";
$parool="123456";
$andmebaas="anton";
$serverinimi="localhost";

$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");