<?php
include 'db/db_connect.php';
session_start();
include '../header_bib.html';

$id_usuario = $_SESSION['id_usuario'];

// Verifica se o usuário é um bibliotecário
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'BIBLIOTECARIO') {
    header('Location: index.html');
    exit;
}

// Navbar com opções
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acervo de Livros</title>
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

        h1 {
            text-align: center;
            color: #808080;
        }

        .table th {
            background-color: #FFFFE0; /* Cor de fundo para cabeçalho */
            color: #808080; /* Cor do texto do cabeçalho */
        }

        .table tbody tr:hover {
            background-color: #f1f1f1; /* Cor de fundo ao passar o mouse */
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <h1>Acervo de Livros</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Disponíveis</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $query_livros = "SELECT * FROM LIVROS";
            $result_livros = mysqli_query($conn, $query_livros);

            if (mysqli_num_rows($result_livros) > 0) {
                while ($livro = mysqli_fetch_assoc($result_livros)) {
                    echo "<tr>
                            <td>{$livro['TITULO']}</td>
                            <td>{$livro['AUTOR']}</td>
                            <td>{$livro['ISBN']}</td>
                            <td>{$livro['UNIDADES_DISPONIVEIS']}</td>
                            <td><a href='editar_livro.php?isbn={$livro['ISBN']}' class='btn btn-primary'>Editar</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Não há livros cadastrados no acervo.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>