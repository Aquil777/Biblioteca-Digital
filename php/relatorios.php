<?php
include 'db/db_connect.php';
session_start();
include '../header_bib.html';

// Verifica se o usuário é um bibliotecário
$id_usuario = $_SESSION['id_usuario'];
$query = "SELECT * FROM USUARIOS WHERE ID_USUARIO='$id_usuario'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['TIPO'] !== 'BIBLIOTECARIO') {
    header('Location: index.html');
    exit;
}

// Relatório de livros mais emprestados
$query_mais_emprestados = "SELECT LIVROS.TITULO, COUNT(EMPRESTIMOS.ID_EMPRESTIMO) AS QTD_EMPRESTIMOS
                           FROM EMPRESTIMOS 
                           JOIN LIVROS ON EMPRESTIMOS.LIVRO_ISBN = LIVROS.ISBN 
                           GROUP BY LIVROS.TITULO 
                           ORDER BY QTD_EMPRESTIMOS DESC 
                           LIMIT 10";
$result_mais_emprestados = mysqli_query($conn, $query_mais_emprestados);

// Preparar dados para o gráfico de livros mais emprestados
$emprestados_titulos = [];
$emprestados_quantidade = [];
while ($row = mysqli_fetch_assoc($result_mais_emprestados)) {
    $emprestados_titulos[] = $row['TITULO'];
    $emprestados_quantidade[] = $row['QTD_EMPRESTIMOS'];
}

// Relatório de Empréstimos por Mês
$query_emprestimos_mes = "SELECT MONTH(DATA_EMPRESTIMO) AS MES, COUNT(*) AS QTD 
                          FROM EMPRESTIMOS 
                          WHERE YEAR(DATA_EMPRESTIMO) = YEAR(CURDATE()) 
                          GROUP BY MES";
$result_emprestimos_mes = mysqli_query($conn, $query_emprestimos_mes);

// Relatório de Devoluções Atrasadas
$query_atrasos = "SELECT COUNT(*) AS QTD_ATRASOS 
                  FROM EMPRESTIMOS 
                  WHERE DATA_DEVOLUCAO < DATA_REAL_DEVOLUCAO";
$result_atrasos = mysqli_query($conn, $query_atrasos);
$atrasos = mysqli_fetch_assoc($result_atrasos)['QTD_ATRASOS'];

// Preparar dados para o gráfico de empréstimos por mês
$meses = [];
$emprestimos_por_mes = [];
while ($row = mysqli_fetch_assoc($result_emprestimos_mes)) {
    $meses[] = $row['MES'];
    $emprestimos_por_mes[] = $row['QTD'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios de Livros</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Adicionando a biblioteca Chart.js -->
    <style>
        body {
            background-image: url('../img/biblioteca.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #333;
        }

        h2 {
            color: #FFFFE0;
            text-align: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Fundo branco transparente */
            border-radius: 10px;
            padding: 20px;
            max-width: 800px;
            margin: auto; /* Centraliza o container */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adiciona sombra */
        }

        canvas {
            width: 100% !important; /* Garante que o gráfico use 100% da largura do container */
            height: 300px !important; /* Ajusta a altura do gráfico */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Relatórios de Livros</h2><br>

        <!-- Gráfico de Livros Mais Emprestados -->
        <h3>Livros Mais Emprestados</h3>
        <canvas id="chartEmprestados"></canvas><br>

        <!-- Gráfico de Empréstimos por Mês -->
        <h3>Empréstimos por Mês (<?= date('Y') ?>)</h3>
        <canvas id="chartEmprestimosMes"></canvas><br>

        <!-- Devoluções Atrasadas -->
        <h3>Total de Devoluções Atrasadas</h3>
        <p><?= $atrasos ?> devoluções foram feitas após a data prevista.</p>
    </div>

    <script>
        // Dados do gráfico de Livros Mais Emprestados
        const emprestadosData = {
            labels: <?= json_encode($emprestados_titulos) ?>,
            datasets: [{
                label: 'Quantidade de Empréstimos',
                data: <?= json_encode($emprestados_quantidade) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Configuração do gráfico de Livros Mais Emprestados
        const configEmprestados = {
            type: 'bar',
            data: emprestadosData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderizar o gráfico de Livros Mais Emprestados
        const chartEmprestados = new Chart(
            document.getElementById('chartEmprestados'),
            configEmprestados
        );

        // Dados do gráfico de Empréstimos por Mês
        const emprestimosMesData = {
            labels: <?= json_encode($meses) ?>,
            datasets: [{
                label: 'Quantidade de Empréstimos',
                data: <?= json_encode($emprestimos_por_mes) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Configuração do gráfico de Empréstimos por Mês
        const configEmprestimosMes = {
            type: 'line',
            data: emprestimosMesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Renderizar o gráfico de Empréstimos por Mês
        const chartEmprestimosMes = new Chart(
            document.getElementById('chartEmprestimosMes'),
            configEmprestimosMes
        );
    </script>
</body>
</html>
