<?php
include 'db/db_connect.php';
session_start();
include '../header_bib.html';

$isbn = $_GET['isbn'];

// Se a edição estiver sendo feita, atualiza os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $unidades = $_POST['unidades'];

    $update_query = "UPDATE LIVROS SET TITULO='$titulo', AUTOR='$autor', CATEGORIA='$categoria', UNIDADES_DISPONIVEIS='$unidades' 
                     WHERE ISBN='$isbn'";
    mysqli_query($conn, $update_query);
    echo "<script> alert('Livro atualizado com sucesso!'); window.location.href = 'bibliotecario_dashboard.php'; </script>";
}

$query = "SELECT * FROM LIVROS WHERE ISBN='$isbn'";
$result = mysqli_query($conn, $query);
$livro = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
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
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #808080;
        }

        .form-group {
            margin-bottom: 15px;
        }

        button {
            background-color: #808080;
            color: white;
        }

        button:hover {
            background-color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Livro</h2>
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="titulo">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($livro['TITULO']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="autor">Autor:</label>
                    <input type="text" class="form-control" id="autor" name="autor" value="<?= htmlspecialchars($livro['AUTOR']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="categoria">Categoria:</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" value="<?= htmlspecialchars($livro['CATEGORIA']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="unidades">Unidades Disponíveis:</label>
                    <input type="number" class="form-control" id="unidades" name="unidades" value="<?= htmlspecialchars($livro['UNIDADES_DISPONIVEIS']) ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Livro</button>
        </form>
    </div>
</body>
</html>
