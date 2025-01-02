<?php
include 'db/db_connect.php';
session_start();

$isbn = $_GET['isbn'];
$id_usuario = $_SESSION['id_usuario'];

// Verifica se o usuário está logado
if (!isset($id_usuario)) {
    header('Location: index.html');
    exit;
}

// Busca informações do livro
$query = "SELECT * FROM LIVROS WHERE ISBN = '$isbn'";
$result = mysqli_query($conn, $query);
$livro = mysqli_fetch_assoc($result);

if (!$livro) {
    echo "<script> alert('Livro não encontrado.'); </script>";
    exit;
}

// Exibe o formulário para renovar
echo "<h2>Renovar Empréstimo do Livro: {$livro['TITULO']}</h2>";
echo "<form action='processar_renovacao.php' method='POST'>
        <label for='data_devolucao'>Nova Data de Devolução:</label>
        <input type='date' name='data_devolucao' required>
        <input type='hidden' name='isbn' value='$isbn'>
        <button type='submit'>Confirmar Renovação</button>
      </form>";
?>
