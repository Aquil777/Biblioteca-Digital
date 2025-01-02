<?php
include 'db/db_connect.php';
session_start();
include '../header_user.html';

$id_usuario = $_SESSION['id_usuario'];

// Verifica se o usuário está logado
if (!isset($id_usuario)) {
    header('Location: index.html');
    exit;
}

// Obtém informações do usuário
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../img/biblioteca.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #333;
        }

        .container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #808080;
        }

        h2 {
            color: #808080;
            margin-top: 30px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #FFFFE0; /* Cor de fundo para cabeçalho */
            color: #808080; /* Cor do texto do cabeçalho */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Cor de fundo para linhas pares */
        }

        tr:hover {
            background-color: #f1f1f1; /* Cor de fundo ao passar o mouse */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Dados do Usuário</h1>
    <p>Nome: <?= htmlspecialchars($user['NOME']) ?></p>
    <p>ID: <?= htmlspecialchars($user['ID_USUARIO']) ?></p>
    <p>Email: <?= htmlspecialchars($user['EMAIL']) ?></p>
    <p>Telefone: <?= htmlspecialchars($user['TELEFONE']) ?></p>

    <!-- Exibe os livros emprestados pelo usuário -->
    <h2>Seus Empréstimos Ativos</h2>
    <?php
    $query_emprestimos = "SELECT LIVROS.TITULO, EMPRESTIMOS.DATA_EMPRESTIMO, EMPRESTIMOS.DATA_DEVOLUCAO, LIVROS.ISBN, EMPRESTIMOS.NUM_RENOVACOES
                          FROM EMPRESTIMOS 
                          JOIN LIVROS ON EMPRESTIMOS.LIVRO_ISBN = LIVROS.ISBN 
                          WHERE EMPRESTIMOS.ID_USUARIO = '$id_usuario' AND EMPRESTIMOS.STATUS_EMPRESTIMO = 'EMPRESTADO'";
    $result_emprestimos = mysqli_query($conn, $query_emprestimos);

    if (mysqli_num_rows($result_emprestimos) > 0) {
        echo "<table>
                <tr>
                    <th>Título</th>
                    <th>Data de Empréstimo</th>
                    <th>Data de Devolução</th>
                </tr>";

        while ($emprestimo = mysqli_fetch_assoc($result_emprestimos)) {
            echo "<tr>
                    <td>{$emprestimo['TITULO']}</td>
                    <td>{$emprestimo['DATA_EMPRESTIMO']}</td>
                    <td>{$emprestimo['DATA_DEVOLUCAO']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Você não tem livros emprestados no momento.</p>";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
