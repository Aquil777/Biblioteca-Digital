<?php
include 'db/db_connect.php';
session_start();

// Verifica se o usuário está logado
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'ADMINISTRADOR') {
    header('Location: index.html');
    exit;
}

include '../header_admin.html';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Administrador</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Dados do Administrador</h1>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['NOME']); ?></p>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($user['ID_USUARIO']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['EMAIL']); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($user['TELEFONE']); ?></p>
    </div>
</body>
</html>
