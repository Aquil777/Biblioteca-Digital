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

if (isset($_GET['id'])) {
    $id_usuario_remover = $_GET['id'];

    // Não permitir que um administrador seja removido
    if ($id_usuario_remover === $id_usuario) {
        echo "<script>alert('Não é permitido remover o seu próprio usuário.'); window.location.href='lista_usuarios.php';</script>";
        exit;
    }

    // Remove o usuário do banco de dados
    $delete_query = "DELETE FROM USUARIOS WHERE ID_USUARIO='$id_usuario_remover'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Usuário removido com sucesso!'); window.location.href='lista_usuarios.php';</script>";
    } else {
        echo "<script>alert('Erro ao remover usuário: " . mysqli_error($conn) . "');</script>";
    }
} else {
    echo "<script>alert('Usuário não especificado.'); window.location.href='lista_usuarios.php';</script>";
}
?>
