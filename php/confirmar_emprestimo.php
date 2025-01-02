<?php
include 'db/db_connect.php';
session_start();
include '../header_user.html';

$isbn = $_GET['isbn'];
$id_usuario = $_SESSION['id_usuario'];

// Busca informações do livro
$query = "SELECT * FROM LIVROS WHERE ISBN = '$isbn'";
$result = mysqli_query($conn, $query);
$livro = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Empréstimo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Confirmar Empréstimo de Livro</h2>
            </div>
            <div class="card-body">
                <p>Livro: <?php echo htmlspecialchars($livro['TITULO']); ?> - Autor: <?php echo htmlspecialchars($livro['AUTOR']); ?></p>
                <form action="emprestar_livro.php?isbn=<?php echo htmlspecialchars($isbn); ?>" method="POST">
                    <div class="form-group">
                        <label for="data_devolucao">Selecione a data de devolução:</label>
                        <input type="date" name="data_devolucao" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirmar Empréstimo</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

