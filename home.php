<?php
session_start();
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("location: login/login.php");
    //echo "NO LOGIN";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert</title>
</head>

<body>

    <h1>HOME PAGeE</h1>
    <a href="login/logout.php"><button>logout</button></a>
</body>

</html>