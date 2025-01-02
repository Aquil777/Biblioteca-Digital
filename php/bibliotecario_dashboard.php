<?php
include 'db/db_connect.php';
session_start();
include '../header_bib.html';

$id_usuario = $_SESSION['id_usuario'];

// Verifica se o usuário é um bibliotecário
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'BIBLIOTECARIO') {
    header('Location: index.html');
    exit;
}

// Navbar com opções
?>