<?php
include 'db/db_connect.php'; // Conexão ao banco de dados
session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];

$query = "SELECT * FROM USUARIOS WHERE EMAIL='$email' AND SENHA='$senha'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['id_usuario'] = $user['ID_USUARIO'];
    
    if ($user['TIPO'] == 'ADMINISTRADOR') {
        header('Location: admin_dashboard.php');
    } elseif ($user['TIPO'] == 'BIBLIOTECARIO') {
        header('Location: bibliotecario_dashboard.php');
    } else {
        header('Location: user_dashboard.php');
    }
} else {
    echo "Login inválido!";
}
?>