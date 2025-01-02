<?php
include 'db/db_connect.php';
session_start();

// Verifica se o usuário é um administrador
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'ADMINISTRADOR') {
    header('Location: index.html');
    exit;
}
include '../header_admin.html';

echo "<style>


table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: white; /* Fundo da tabela */
}

th, td {
    border: 1px solid #ccc; /* Cor da borda */
    padding: 10px;
    text-align: left;
    color: black; /* Texto preto */
}

th {
    background-color: #f8f3b3; /* Cor de fundo dos cabeçalhos (opcional) */
    font-weight: bold;
}

h1, h2, h3 {
    color: black; /* Define a cor dos títulos como preto */
}
</style>";

echo "<h1 style=color:white;>Relatórios</h1>";

// Relatórios de Empréstimos por Usuário (ativos e devolvidos)
echo "<h2 style=color:white;>Relatório de Empréstimos por Usuário</h2>";
$query_emprestimos = "SELECT USUARIOS.ID_USUARIO, USUARIOS.NOME, 
                      SUM(CASE WHEN EMPRESTIMOS.STATUS_EMPRESTIMO = 'EMPRESTADO' THEN 1 ELSE 0 END) AS EMPRESTIMOS_ATIVOS, 
                      SUM(CASE WHEN EMPRESTIMOS.STATUS_EMPRESTIMO = 'DEVOLVIDO' THEN 1 ELSE 0 END) AS LIVROS_DEVOLVIDOS
                      FROM EMPRESTIMOS 
                      JOIN USUARIOS ON EMPRESTIMOS.ID_USUARIO = USUARIOS.ID_USUARIO 
                      GROUP BY USUARIOS.ID_USUARIO";
$result_emprestimos = mysqli_query($conn, $query_emprestimos);

echo "<table>
        <tr>
            <th>ID Usuário</th>
            <th>Nome</th>
            <th>Empréstimos Ativos</th>
            <th>Livros Devolvidos</th>
        </tr>";

while ($emprestimo = mysqli_fetch_assoc($result_emprestimos)) {
    echo "<tr>
            <td>{$emprestimo['ID_USUARIO']}</td>
            <td>{$emprestimo['NOME']}</td>
            <td>{$emprestimo['EMPRESTIMOS_ATIVOS']}</td>
            <td>{$emprestimo['LIVROS_DEVOLVIDOS']}</td>
          </tr>";
}
echo "</table><br>";

// Relatório de Usuários Inativos (mostra o tipo de usuário)
echo "<h2>Relatório de Usuários Inativos</h2>";
$query_inativos = "SELECT USUARIOS.ID_USUARIO, USUARIOS.NOME, USUARIOS.TIPO 
                   FROM USUARIOS 
                   LEFT JOIN EMPRESTIMOS ON USUARIOS.ID_USUARIO = EMPRESTIMOS.ID_USUARIO 
                   WHERE EMPRESTIMOS.ID_EMPRESTIMO IS NULL";
$result_inativos = mysqli_query($conn, $query_inativos);

echo "<table>
        <tr>
            <th>ID Usuário</th>
            <th>Nome</th>
            <th>Tipo de Usuário</th>
        </tr>";

while ($inativo = mysqli_fetch_assoc($result_inativos)) {
    echo "<tr>
            <td>{$inativo['ID_USUARIO']}</td>
            <td>{$inativo['NOME']}</td>
            <td>{$inativo['TIPO']}</td>
          </tr>";
}
echo "</table><br>";

// Filtro de duração para usuários mais ativos
echo '<h2>Usuários Mais Ativos</h2>';
echo '<form method="GET" action="relatorios_admin.php">
        <label for="duracao">Escolha a Duração:</label>
        <select id="duracao" name="duracao" required>
            <option value="7">Últimos 7 dias</option>
            <option value="30">Últimos 30 dias</option>
            <option value="365">Últimos 12 meses</option>
        </select>
        <button type="submit">Ver Relatório</button>
      </form>';

// Relatório de Usuários Mais Ativos (com base na duração selecionada)
if (isset($_GET['duracao'])) {
    $duracao = intval($_GET['duracao']);
    $query_ativos = "SELECT USUARIOS.ID_USUARIO, USUARIOS.NOME, USUARIOS.TIPO, 
                     COUNT(EMPRESTIMOS.ID_EMPRESTIMO) AS TOTAL_ATIVIDADES 
                     FROM EMPRESTIMOS 
                     JOIN USUARIOS ON EMPRESTIMOS.ID_USUARIO = USUARIOS.ID_USUARIO 
                     WHERE EMPRESTIMOS.DATA_EMPRESTIMO >= DATE_SUB(CURDATE(), INTERVAL $duracao DAY)
                     GROUP BY USUARIOS.ID_USUARIO 
                     ORDER BY TOTAL_ATIVIDADES DESC";
    $result_ativos = mysqli_query($conn, $query_ativos);

    echo "<table>
            <tr>
                <th>ID Usuário</th>
                <th>Nome</th>
                <th>Tipo de Usuário</th>
                <th>Total de Atividades</th>
            </tr>";

    while ($ativo = mysqli_fetch_assoc($result_ativos)) {
        echo "<tr>
                <td>{$ativo['ID_USUARIO']}</td>
                <td>{$ativo['NOME']}</td>
                <td>{$ativo['TIPO']}</td> <!-- Adicionando tipo de usuário -->
                <td>{$ativo['TOTAL_ATIVIDADES']}</td>
              </tr>";
    }
    echo "</table>";
}
echo "<br>";
?>
