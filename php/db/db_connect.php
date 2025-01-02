<?php
$host = "localhost"; // endereço do servidor
$user = "root";      // usuário do MySQL
$pass = "";          // senha do MySQL
$db = "bibdig";  // nome do banco de dados

$conn = mysqli_connect($host, $user, $pass, $db);

// Verifica se a conexão falhou
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}
?>