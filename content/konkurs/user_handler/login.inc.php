<?php
if (isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'functions.inc.php';
    require_once '../connection/conf.php';
    global $yhendus;

    if(emptyInputLogin($username, $password) )
    {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($yhendus, $username, $password);
}
else
{
    header("location: ../login.php");
    exit();
}