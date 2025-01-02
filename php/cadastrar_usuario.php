<?php
include 'db/db_connect.php';
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['id_usuario'])) {
    if ($_SESSION['tipo_usuario'] === 'ADMINISTRADOR') {
        header('Location: admin_dashboard.php'); // Redireciona para o painel do administrador
    } elseif ($_SESSION['tipo_usuario'] === 'BIBLIOTECARIO') {
        header('Location: bibliotecario_dashboard.php'); // Redireciona para o painel do bibliotecário
    } else {
        header('Location: user_dashboard.php'); // Redireciona para o painel do usuário
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha']; // Novo campo para confirmação
    $telefone = $_POST['telefone'];
    $tipo = 'USUARIO'; // Define o tipo como 'USUARIO'

    // Validação da senha
    if ($senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem.');</script>";
    }  else {
        // Adiciona o novo usuário ao banco de dados
        $insert_query = "INSERT INTO USUARIOS (NOME, EMAIL, SENHA, TELEFONE, TIPO) 
                         VALUES ('$nome', '$email', '$senha', '$telefone', '$tipo')";
        
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='../index.html';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../img/biblioteca.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #333;
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
            width: 600px; /* Ajuste a largura conforme necessário */
        }

        .form-row {
            margin-bottom: 20px; /* Espaçamento entre as linhas */
        }

        .form-box input, .form-box select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-box button {
            background-color: #808080;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-box button:hover {
            background-color: #666666;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-box">
            <h1>Cadastrar Novo Usuário</h1>
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    </div>
                    <div class="col-md-6">
                        <label for="confirmar_senha">Confirmar Senha:</label>
                        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme a Senha" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" placeholder="Telefone" required>
                    </div>
                    <div class="col-md-6">
                    <input type="hidden" name="tipo" value="USUARIO"> <!-- Tipo é fixado como 'USUARIO' --><br>
                    </div>
                </div>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</html>
