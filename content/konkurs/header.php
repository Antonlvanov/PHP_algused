<?php
session_start();
?>

<!doctype html>
<html lang="et">
<head>
    <meta name="viewport" content="width=device-width; initial-scale=1.0;
maximum-scale=1.0;">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tarpv23 jõulu konkursid</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script src="highligher.js"></script>
</head>
<body>
<h2>Jõulu konkursid</h2>
<nav class="nav">
    <ul>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<li><a href="konkursAdminLeht.php">Admin</a></li>';
        }
        ?>
        <li><a href="konkursUserLeht.php">Kasutaja</a></li>
        <li><a href="konkurss1kaupa.php">Konkursid</a></li>
        <?php
        if (!isset($_SESSION['username'])) {
            echo '<li><a href="login.php">Sisse loogi</a></li>';
            echo '<li><a href="signup.php">Registreeri</a></li>';
        }
        else {
            echo '<li><a href="user_handler/logout.inc.php">Logi välja</a></li>';
        }
        ?>
    </ul>
</nav>