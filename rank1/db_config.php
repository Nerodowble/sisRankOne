<?php
$servername = "localhost";
$username = "root"; // Usuário do MySQL (no seu caso, "root")
$password = ""; // Deixe em branco, pois não há senha definida ("")
$dbname = "rank1db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
