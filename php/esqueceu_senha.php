<?php
include 'db/db_connect.php';
session_start();

$senha_trocada = false; // Variável para verificar se a senha foi alterada
$usuario_encontrado = false; // Variável para verificar se o usuário foi encontrado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_usuario']) && isset($_POST['email'])) {
        $id_usuario = $_POST['id_usuario'];
        $email = $_POST['email'];

        // Verifica se o usuário existe com o email fornecido
        $query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario' AND EMAIL='$email'";
        $result = mysqli_query($conn, $query);
        $usuario = mysqli_fetch_assoc($result);

        if ($usuario) {
            $usuario_encontrado = true; // Usuário encontrado

            // Se o usuário foi encontrado, permita a troca de senha
            if (isset($_POST['nova_senha'])) {
                $nova_senha = $_POST['nova_senha'];
                $confirmar_senha = $_POST['confirmar_senha']; // Novo campo para confirmação
                
                // Validação da nova senha
                if ($nova_senha !== $confirmar_senha) {
                    echo "<script>alert('As senhas não coincidem.');</script>";
                } else {
                    // Atualiza a senha no banco de dados
                    $update_query = "UPDATE USUARIOS SET SENHA='$nova_senha' WHERE ID_USUARIO='$id_usuario'";
                    if (mysqli_query($conn, $update_query)) {
                        $senha_trocada = true;
                    } else {
                        echo "<script>alert('Erro ao atualizar a senha: " . mysqli_error($conn) . "');</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Usuário não encontrado. Verifique seu ID e email.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Esqueceu a Senha?</title>
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
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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
            <h1>Esqueceu a Senha?</h1>
            <?php if (!$senha_trocada && !$usuario_encontrado): ?>
                <form method="POST">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="id_usuario">ID Usuário:</label>
                            <input type="text" id="id_usuario" name="id_usuario" placeholder="ID Usuário" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <button type="submit">Verificar</button>
                </form>
            <?php elseif ($usuario_encontrado && !$senha_trocada): ?>
                <form method="POST">
                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="nova_senha">Nova Senha:</label>
                            <input type="password" id="nova_senha" name="nova_senha" placeholder="Nova Senha" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="confirmar_senha">Confirmar Nova Senha:</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme a Senha" required>
                        </div>
                    </div>
                    <button type="submit">Trocar Senha</button>
                </form>
            <?php elseif ($senha_trocada): ?>
                <script> 
                    alert('Senha trocada com sucesso!');
                    window.location.href = "../index.html"</script>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
