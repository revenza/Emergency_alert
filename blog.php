<?php
session_start();
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: login/login.php");
    //echo "NO LOGIN";
    exit();
}
