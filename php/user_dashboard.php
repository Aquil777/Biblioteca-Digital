<?php
include 'db/db_connect.php';
session_start();

$id_usuario = $_SESSION['id_usuario'];

// Verifica se o usuário está logado
if (!isset($id_usuario)) {
    header('Location: index.html');
    exit;
}

// Obtém informações do usuário
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Navbar com opções
include '../header_user.html';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
</head>
<body>
    <div class="container mt-4">

        <?php
        // Verifica empréstimos
        $query_emprestimos = "SELECT LIVROS.TITULO, EMPRESTIMOS.DATA_DEVOLUCAO 
                              FROM EMPRESTIMOS 
                              JOIN LIVROS ON EMPRESTIMOS.LIVRO_ISBN = LIVROS.ISBN 
                              WHERE EMPRESTIMOS.ID_USUARIO = '$id_usuario' AND EMPRESTIMOS.STATUS_EMPRESTIMO = 'EMPRESTADO'";
        $result_emprestimos = mysqli_query($conn, $query_emprestimos);

        while ($emprestimo = mysqli_fetch_assoc($result_emprestimos)) {
            $data_devolucao = $emprestimo['DATA_DEVOLUCAO'];
            $data_atual = date('Y-m-d');
            $faltam_dias = (strtotime($data_devolucao) - strtotime($data_atual)) / (60 * 60 * 24);

            // Se faltar 3 dias ou menos para a devolução, mostrar alerta
            if ($faltam_dias > 0 && $faltam_dias <= 3) {
                echo "<script>
                        alert('Atenção! Faltam apenas {$faltam_dias} dias para a data de devolução do livro \"{$emprestimo['TITULO']}\".');
                      </script>";
            }

            // Se a data de devolução já passou, bloquear acesso
            if ($faltam_dias < 0) {
                echo "<script>
                        alert('Você tem empréstimos vencidos. Por favor, devolva os livros para continuar acessando.');
                        window.location.href = '../bloqueado.html';
                      </script>";
                exit;
            }
        }

        if (mysqli_num_rows($result_emprestimos) > 0) {
            while ($emprestimo = mysqli_fetch_assoc($result_emprestimos)) {
                $data_devolucao = $emprestimo['DATA_DEVOLUCAO'];
                $data_atual = date('Y-m-d');

                // Exibe informações do empréstimo com link de renovação ao lado da data de devolução
                echo "<p>Livro: {$emprestimo['TITULO']} - Data de Empréstimo: {$emprestimo['DATA_EMPRESTIMO']} - Data de Devolução: {$emprestimo['DATA_DEVOLUCAO']}";
                
                // Verifica se o empréstimo ainda pode ser renovado (1 vez no máximo)
                if ($emprestimo['NUM_RENOVACOES'] < 1) {
                    echo " <a href='renovar_livro.php?isbn={$emprestimo['ISBN']}'>Renovar Empréstimo</a>";
                } else {
                    echo " - <span style='color: gray;'>Empréstimo já renovado</span>";
                }
                
                echo "</p>";

                // Se a data de devolução for hoje, gera um alerta em JS
                if ($data_devolucao == $data_atual) {
                    echo "<script>
                            alert('Atenção! A data de devolução do livro \"{$emprestimo['TITULO']}\" é hoje.');
                          </script>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
