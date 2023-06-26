<?php

$servername = "teste";
$username = "teste";
$password = "teste";
$dbname = "teste";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

?>
