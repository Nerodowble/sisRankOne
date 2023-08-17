<?php
require_once 'db_config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.html');
    exit();
}

$username = $_SESSION['username'];

// Função para obter o ID do usuário a partir do username
function getUserId($conn, $username) {
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return null;
    }
}

$user_id = getUserId($conn, $username);

if ($user_id !== null) {
    $sql_profile = "SELECT * FROM user_profiles WHERE user_id = $user_id";
    $result_profile = $conn->query($sql_profile);

    if ($result_profile->num_rows === 1) {
        $userData = $result_profile->fetch_assoc();
    }
}

$updateSql = ""; // Inicialize a variável de atualização

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $altura = $_POST["altura"];
    $peso = $_POST["peso"];
    $idade = $_POST["idade"];
    $frequencia = $_POST["frequencia"];

    $updateSql = "UPDATE user_profiles SET altura = '$altura', peso = '$peso', idade = '$idade', frequencia = '$frequencia' WHERE user_id = $user_id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Dados atualizados com sucesso!";
        header('Location: profile.php'); // Redireciona para profile.php após atualização
        exit();
    } else {
        echo "Erro ao atualizar os dados: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Seu Perfil</title>
</head>
<body>
    <div class="container">
        <h2>Bem-vindo, <?php echo $username; ?></h2>
        <?php if ($userData) { ?>
            <p>Altura: <?php echo $userData['altura']; ?></p>
            <p>Peso: <?php echo $userData['peso']; ?></p>
            <p>Idade: <?php echo $userData['idade']; ?></p>
            <p>Frequência na academia: <?php echo $userData['frequencia']; ?></p>
        <?php } else { ?>
            <p>Nenhum perfil encontrado.</p>
        <?php } ?>
        <h3>Preencha seus dados</h3>
        <form action="home.php" method="POST">
            <input type="text" name="altura" placeholder="Altura" value="<?php echo isset($userData['altura']) ? $userData['altura'] : ''; ?>">
            <input type="text" name="peso" placeholder="Peso" value="<?php echo isset($userData['peso']) ? $userData['peso'] : ''; ?>">
            <input type="text" name="idade" placeholder="Idade" value="<?php echo isset($userData['idade']) ? $userData['idade'] : ''; ?>">
            <input type="text" name="frequencia" placeholder="Frequência na academia" value="<?php echo isset($userData['frequencia']) ? $userData['frequencia'] : ''; ?>">
            <button type="submit">Atualizar Dados</button>
        </form>
    </div>
</body>
</html>
