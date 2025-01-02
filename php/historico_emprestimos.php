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

// Obtém o histórico de empréstimos do usuário
$query_historico = "SELECT LIVROS.TITULO, EMPRESTIMOS.DATA_EMPRESTIMO, EMPRESTIMOS.DATA_DEVOLUCAO 
                    FROM EMPRESTIMOS 
                    JOIN LIVROS ON EMPRESTIMOS.LIVRO_ISBN = LIVROS.ISBN 
                    WHERE EMPRESTIMOS.ID_USUARIO = '$id_usuario'";

$result_historico = mysqli_query($conn, $query_historico);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Empréstimos</title>
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
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #808080;
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
    <h1>Histórico de Empréstimos</h1>

    <?php if (mysqli_num_rows($result_historico) > 0): ?>
        <table>
            <tr>
                <th>Título</th>
                <th>Data de Empréstimo</th>
                <th>Data de Devolução</th>
            </tr>

            <?php while ($historico = mysqli_fetch_assoc($result_historico)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($historico['TITULO']); ?></td>
                    <td><?php echo htmlspecialchars($historico['DATA_EMPRESTIMO']); ?></td>
                    <td><?php echo htmlspecialchars($historico['DATA_DEVOLUCAO']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Você não possui empréstimos anteriores.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
