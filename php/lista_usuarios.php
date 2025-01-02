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

echo "<h1>Lista de Usuários</h1>";
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
</style>";

$query_usuarios = "SELECT * FROM USUARIOS";
$result_usuarios = mysqli_query($conn, $query_usuarios);
echo "<table>
        <tr>
            <th>ID Usuário</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>";

while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
    // Bloquear edição e remoção de outros administradores
    if ($usuario['TIPO'] === 'ADMINISTRADOR' && $usuario['ID_USUARIO'] !== $id_usuario) {
        $acoes = "<span>Não permitido</span>";
    } else {
        $acoes = "<a href='editar_usuario.php?id={$usuario['ID_USUARIO']}'>Editar</a> | 
                  <a href='remover_usuario.php?id={$usuario['ID_USUARIO']}'>Remover</a>";
    }

    echo "<tr>
            <td>{$usuario['ID_USUARIO']}</td>
            <td>{$usuario['NOME']}</td>
            <td>{$usuario['EMAIL']}</td>
            <td>{$usuario['TELEFONE']}</td>
            <td>{$usuario['TIPO']}</td>
            <td>$acoes</td>
          </tr>";
}
echo "</table>";
?>
