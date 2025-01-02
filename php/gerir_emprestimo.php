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

// Atualiza o status do empréstimo
if (isset($_GET['devolver']) && !empty($_GET['devolver'])) {
    $id_emprestimo = $_GET['devolver'];
    
    // Obtém o status atual do empréstimo
    $status_query = "SELECT STATUS_EMPRESTIMO FROM EMPRESTIMOS WHERE ID_EMPRESTIMO = '$id_emprestimo'";
    $status_result = mysqli_query($conn, $status_query);
    $status_row = mysqli_fetch_assoc($status_result);
    $current_status = $status_row['STATUS_EMPRESTIMO'];

    // Verifica se o status é "EMPRESTADO"
    if ($current_status === 'EMPRESTADO') {
        $hoje = date('Y-m-d');
        $update_query = "UPDATE EMPRESTIMOS SET STATUS_EMPRESTIMO = 'DEVOLVIDO', DATA_REAL_DEVOLUCAO = '$hoje' WHERE ID_EMPRESTIMO = '$id_emprestimo'";
        
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Empréstimo marcado como devolvido!');</script>";
        } else {
            echo "<script>alert('Erro ao marcar o empréstimo como devolvido: " . mysqli_error($conn) . "');</script>";
        }
    } else if ($current_status === 'DEVOLVIDO') {
        // Se já foi devolvido, pode alternar para "EMPRESTADO"
        $update_query = "UPDATE EMPRESTIMOS SET STATUS_EMPRESTIMO = 'EMPRESTADO', DATA_REAL_DEVOLUCAO = NULL WHERE ID_EMPRESTIMO = '$id_emprestimo'";
        
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Empréstimo marcado como emprestado novamente!');</script>";
        } else {
            echo "<script>alert('Erro ao marcar o empréstimo como emprestado: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Status desconhecido para o empréstimo.');</script>";
    }
}

// Inicializa o filtro e a ordenação
$filter = "";
$order_by = "USUARIOS.ID_USUARIO"; // Ordenação padrão

// Filtra os empréstimos com base na pesquisa
if (isset($_POST['filter'])) {
    $search_criteria = $_POST['search_criteria'] ?? '';
    $search_value = $_POST['search_value'] ?? '';

    // Define o filtro de acordo com o critério selecionado
    if ($search_criteria === 'id_usuario') {
        $filter = "WHERE EMPRESTIMOS.STATUS_EMPRESTIMO = 'EMPRESTADO' AND USUARIOS.ID_USUARIO = '$search_value'";
    } elseif ($search_criteria === 'nome_usuario') {
        $filter = "WHERE EMPRESTIMOS.STATUS_EMPRESTIMO = 'EMPRESTADO' AND USUARIOS.NOME LIKE '%$search_value%'";
    } elseif ($search_criteria === 'id_emprestimo') {
        $filter = "WHERE EMPRESTIMOS.STATUS_EMPRESTIMO = 'EMPRESTADO' AND EMPRESTIMOS.ID_EMPRESTIMO = '$search_value'";
    }
}

// Ordenação
if (isset($_POST['order_by'])) {
    $order_by = $_POST['order_by'] === 'id_usuario' ? 'USUARIOS.ID_USUARIO' : 'EMPRESTIMOS.ID_EMPRESTIMO';
}

// Exibe todos os empréstimos ativos, com o filtro e a ordenação aplicados
$query_emprestimos = "SELECT EMPRESTIMOS.ID_EMPRESTIMO, USUARIOS.ID_USUARIO, USUARIOS.NOME, LIVROS.TITULO, EMPRESTIMOS.DATA_DEVOLUCAO, EMPRESTIMOS.DATA_EMPRESTIMO, EMPRESTIMOS.STATUS_EMPRESTIMO, EMPRESTIMOS.DATA_REAL_DEVOLUCAO
                      FROM EMPRESTIMOS 
                      JOIN USUARIOS ON EMPRESTIMOS.ID_USUARIO = USUARIOS.ID_USUARIO 
                      JOIN LIVROS ON EMPRESTIMOS.LIVRO_ISBN = LIVROS.ISBN 
                      $filter 
                      ORDER BY $order_by ASC"; // Ordena pelo critério selecionado

$result_emprestimos = mysqli_query($conn, $query_emprestimos);

// Debug: Verifique se a consulta retornou um resultado
if (!$result_emprestimos) {
    die('Erro na consulta: ' . mysqli_error($conn));
}

echo "<h2>Gerir Empréstimos</h2>";

// Formulário de pesquisa e ordenação
echo "<form method='POST'>
        <label for='search_criteria' style= color:#FFFFE0>Buscar por:</label>
        <select id='search_criteria' name='search_criteria' required>
            <option value='id_usuario'>ID Usuário</option>
            <option value='nome_usuario'>Nome do Usuário</option>
            <option value='id_emprestimo'>ID Empréstimo</option>
        </select>
        <input type='text' id='search_value' name='search_value' placeholder='Digite o valor' required>
        <button type='submit' name='filter'>Buscar</button>
      </form>";

echo "<form method='POST'>
        <label for='order_by' style= color:#FFFFE0>Ordenar por:</label>
        <select id='order_by' name='order_by'>
            <option value='id_usuario'>ID Usuário</option>
            <option value='id_emprestimo'>ID Empréstimo</option>
        </select>
        <button type='submit'>Ordenar</button>
      </form>";

echo "<table border='1'>
        <tr>
            <th>ID Empréstimo</th>
            <th>ID Usuário</th>
            <th>Nome Usuário</th>
            <th>Título do Livro</th>
            <th>Data de Empréstimo</th>
            <th>Data de Devolução</th>
            <th>Status</th>
            <th>Data Real de Devolução</th>
            <th>Ação</th>
        </tr>";

while ($emprestimo = mysqli_fetch_assoc($result_emprestimos)) {
    echo "<tr>
            <td>{$emprestimo['ID_EMPRESTIMO']}</td>
            <td>{$emprestimo['ID_USUARIO']}</td>
            <td>{$emprestimo['NOME']}</td>
            <td>{$emprestimo['TITULO']}</td>
            <td>{$emprestimo['DATA_EMPRESTIMO']}</td>
            <td>{$emprestimo['DATA_DEVOLUCAO']}</td>
            <td>{$emprestimo['STATUS_EMPRESTIMO']}</td>
            <td>{$emprestimo['DATA_REAL_DEVOLUCAO']}</td>
            <td>
                <a href='gerir_emprestimo.php?devolver={$emprestimo['ID_EMPRESTIMO']}'>
                    Marcar como " . ($emprestimo['STATUS_EMPRESTIMO'] === 'EMPRESTADO' ? 'Devolvido' : 'Emprestado') . "
                </a>
            </td>
          </tr>";
}
echo "</table>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    
</body>
</html>
