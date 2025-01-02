<?php
include '../header_user.html';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Livros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../img/biblioteca.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #333;

    background-color: #f5f5f5; /* Cor de fallback */

        }

        h2 {
            color: #FFFFE0;
            text-align: center;
        }

        h3 {
            color: #FFFFE0;
            text-align: center;
        }

        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            background-color: #FFFFFF; /* Cor de fundo da tabela */
            border-radius: 8px;
            overflow: hidden; /* Para evitar bordas arredondadas na tabela */
        }

        th, td {
            padding: 12px;
            text-align: left;
            color: #333; /* Cor do texto da tabela */
        }

        th {
            background-color: #FFFFE0; /* Cor de fundo dos cabeçalhos */
            color: #333; /* Cor do texto dos cabeçalhos */
        }

        tr:hover {
            background-color: #f2f2f2; /* Cor ao passar o mouse */
        }

        .actions {
            display: flex;
            justify-content: space-between; /* Para espaçar as ações */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Consultar Livros</h2>
        <form class="search-form" action="" method="GET"> <!-- Ação vazia para submeter na mesma página -->
            <input type="text" name="busca" placeholder="Digite o título, autor, categoria ou ISBN" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <h3>Livros Disponíveis</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>ISBN</th>
                    <th>Unidades Disponíveis</th>
                    <th>Açao</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db/db_connect.php'; // Certifique-se de que o caminho está correto

                // Se houver uma busca, aplica a consulta
                $busca = $_GET['busca'] ?? '';

                if ($busca) {
                    $query = "SELECT * FROM LIVROS 
                              WHERE (TITULO LIKE '%$busca%' OR AUTOR LIKE '%$busca%' OR CATEGORIA LIKE '%$busca%' OR ISBN LIKE '%$busca%')
                              AND UNIDADES_DISPONIVEIS > 0";
                } else {
                    // Se não houver busca, mostra todos os livros disponíveis
                    $query = "SELECT * FROM LIVROS WHERE UNIDADES_DISPONIVEIS > 0";
                }

                $result = mysqli_query($conn, $query);

                // Exibe os livros disponíveis
                while ($livro = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$livro['TITULO']}</td>
                            <td>{$livro['AUTOR']}</td>
                            <td>{$livro['CATEGORIA']}</td>
                            <td>{$livro['ISBN']}</td>
                            <td>{$livro['UNIDADES_DISPONIVEIS']}</td>
                            <td class='actions'>
                                <a href='confirmar_emprestimo.php?isbn={$livro['ISBN']}'>Emprestar</a>
                            </td>
                          </tr>";
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
