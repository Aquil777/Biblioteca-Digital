<?php
include 'db/db_connect.php';
session_start();

$isbn = $_POST['isbn'];
$id_usuario = $_SESSION['id_usuario'];
$nova_data_devolucao = $_POST['data_devolucao'];

// Atualiza a data de devolução
$update_query = "UPDATE EMPRESTIMOS SET DATA_DEVOLUCAO = '$nova_data_devolucao', NUM_RENOVACOES = NUM_RENOVACOES + 1 
                 WHERE LIVRO_ISBN = '$isbn' AND ID_USUARIO = '$id_usuario' AND STATUS_EMPRESTIMO = 'EMPRESTADO' AND NUM_RENOVACOES < 1";
                 
if (mysqli_query($conn, $update_query)) {
    echo "<script> alert('Empréstimo renovado com sucesso! Nova data de devolução: $nova_data_devolucao');
    window.location.href = 'user_dashboard.php'; </script>";
} else {
    echo "Erro ao renovar o empréstimo: " . mysqli_error($conn);
}
?>
