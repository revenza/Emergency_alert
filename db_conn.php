<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "web_pelacak";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    echo "connection sql failed";
}
