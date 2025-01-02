<?php
include 'db/db_connect.php';
session_start();
include '../header_bib.html';

// Verifica se o usuário é um bibliotecário
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'BIBLIOTECARIO') {
    header('Location: index.html');
    exit;
}

// Se o formulário for enviado, insere o livro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $unidades = $_POST['unidades'];

    $insert_query = "INSERT INTO LIVROS (ISBN, TITULO, AUTOR, CATEGORIA, UNIDADES_DISPONIVEIS) 
                     VALUES ('$isbn', '$titulo', '$autor', '$categoria', '$unidades')";
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Livro adicionado com sucesso!'); window.location.href = 'bibliotecario_dashboard.php';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar livro: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Livro</title>
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
        <h2>Adicionar Novo Livro</h2>
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="isbn">ISBN:</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="titulo">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="autor">Autor:</label>
                    <input type="text" class="form-control" id="autor" name="autor" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="categoria">Categoria:</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="unidades">Unidades Disponíveis:</label>
                    <input type="number" class="form-control" id="unidades" name="unidades" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Livro</button>
        </form>
    </div>
</body>
</html>
