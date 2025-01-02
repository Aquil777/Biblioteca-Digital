<?php
include 'db/db_connect.php';
session_start();

// Verifica se o usuário é um administrador
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'ADMINISTRADOR') {
    header('Location: index.html');
    exit;
}

if (isset($_GET['id'])) {
    $id_usuario_editar = $_GET['id'];
    
    // Busca as informações do usuário a ser editado
    $query_editar = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario_editar'";
    $result_editar = mysqli_query($conn, $query_editar);
    $usuario_editar = mysqli_fetch_assoc($result_editar);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualiza os dados do usuário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];

    $update_query = "UPDATE USUARIOS SET NOME='$nome', EMAIL='$email', TELEFONE='$telefone', TIPO='$tipo' 
                     WHERE ID_USUARIO='$id_usuario_editar'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href='lista_usuarios.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar usuário: " . mysqli_error($conn) . "');</script>";
    }
}
include '../header_admin.html';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../img/biblioteca.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #fff;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
        }

        .form-box {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 600px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-box">
            <h1>Editar Usuário</h1>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario_editar['NOME'] ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario_editar['EMAIL'] ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="telefone">Telefone:</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $usuario_editar['TELEFONE'] ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tipo">Tipo:</label>
                        <select id="tipo" name="tipo" class="form-control">
                            <option value="ADMINISTRADOR" <?= $usuario_editar['TIPO'] == 'ADMINISTRADOR' ? 'selected' : '' ?>>Administrador</option>
                            <option value="BIBLIOTECARIO" <?= $usuario_editar['TIPO'] == 'BIBLIOTECARIO' ? 'selected' : '' ?>>Bibliotecário</option>
                            <option value="USUARIO" <?= $usuario_editar['TIPO'] == 'USUARIO' ? 'selected' : '' ?>>Usuario</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
            </form>
        </div>
    </div>
</body>
</html>
