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
        <h2>Seu Perfil</h2>
        <?php if ($userData) { ?>
            <p>Altura: <?php echo $userData['altura']; ?></p>
            <p>Peso: <?php echo $userData['peso']; ?></p>
            <p>Idade: <?php echo $userData['idade']; ?></p>
            <p>Frequência na academia: <?php echo $userData['frequencia']; ?></p>
            <a href="edit_profile.php">Editar Dados</a>
        <?php } else { ?>
            <p>Nenhum perfil encontrado.</p>
        <?php } ?>
    </div>
</body>
</html>
