<?php
include 'db/db_connect.php';
session_start();

$isbn = $_GET['isbn'];
$id_usuario = $_SESSION['id_usuario'];

// Verifica se há unidades disponíveis
$query = "SELECT UNIDADES_DISPONIVEIS FROM LIVROS WHERE ISBN = '$isbn'";
$result = mysqli_query($conn, $query);
$livro = mysqli_fetch_assoc($result);

if ($livro['UNIDADES_DISPONIVEIS'] > 0) {
    // Obtém a data de devolução do formulário
    if (isset($_POST['data_devolucao'])) {
        $data_devolucao = $_POST['data_devolucao'];
    } else {
        echo "Erro: Data de devolução não fornecida.";
        exit;
    }

    // Realiza o empréstimo
    $emprestimo_query = "INSERT INTO EMPRESTIMOS (ID_USUARIO, LIVRO_ISBN, DATA_EMPRESTIMO, DATA_DEVOLUCAO) 
                         VALUES ('$id_usuario', '$isbn', NOW(), '$data_devolucao')";
    mysqli_query($conn, $emprestimo_query);

    // Atualiza a quantidade de unidades disponíveis
    $update_query = "UPDATE LIVROS SET UNIDADES_DISPONIVEIS = UNIDADES_DISPONIVEIS - 1 WHERE ISBN = '$isbn'";
    mysqli_query($conn, $update_query);

    echo "<script> alert('Empréstimo realizado com sucesso! Data de devolução: $data_devolucao');
    window.location.href = 'user_dashboard.php'; </script>";
} else {
    echo "Não há unidades disponíveis para empréstimo.";
}
?>
