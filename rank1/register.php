<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro realizado com sucesso!";
        } else {
            echo "Erro ao registrar: " . $conn->error;
        }
    } else {
        echo "Campos de usuário e senha não foram enviados corretamente.";
    }
}
?>
