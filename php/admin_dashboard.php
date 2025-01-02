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

include('../header_admin.html');
?>
