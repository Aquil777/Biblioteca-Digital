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

// Processa o formulário quando é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];

    // Adiciona o novo usuário ao banco de dados
    $insert_query = "INSERT INTO USUARIOS (NOME, EMAIL, SENHA, TELEFONE, TIPO) 
                     VALUES ('$nome', '$email', '$senha', '$telefone', '$tipo')";
    
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Usuário adicionado com sucesso!'); window.location.href='lista_usuarios.php';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar usuário: " . mysqli_error($conn) . "');</script>";
    }
}

include '../header_admin.html';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Usuário</title>
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
            height: 100vh;
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
            <h1>Adicionar Usuário</h1>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telefone">Telefone:</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tipo">Tipo:</label>
                        <select id="tipo" name="tipo" class="form-control">
                            <option value="ADMINISTRADOR">Administrador</option>
                            <option value="BIBLIOTECARIO">Bibliotecário</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <!-- Espaço para uma futura funcionalidade, se necessário -->
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Adicionar Usuário</button>
            </form>
        </div>
    </div>
</body>
</html>
