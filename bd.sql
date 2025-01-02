-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 08:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibdig`
--

-- --------------------------------------------------------

--
-- Table structure for table `emprestimos`
--

CREATE TABLE `emprestimos` (
  `ID_EMPRESTIMO` int(11) NOT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `LIVRO_ISBN` varchar(13) DEFAULT NULL,
  `DATA_EMPRESTIMO` date DEFAULT NULL,
  `DATA_DEVOLUCAO` date DEFAULT NULL,
  `STATUS_EMPRESTIMO` enum('EMPRESTADO','DEVOLVIDO','RENOVADO') DEFAULT 'EMPRESTADO',
  `DATA_REAL_DEVOLUCAO` date DEFAULT NULL,
  `NUM_RENOVACOES` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emprestimos`
--

INSERT INTO `emprestimos` (`ID_EMPRESTIMO`, `ID_USUARIO`, `LIVRO_ISBN`, `DATA_EMPRESTIMO`, `DATA_DEVOLUCAO`, `STATUS_EMPRESTIMO`, `DATA_REAL_DEVOLUCAO`, `NUM_RENOVACOES`) VALUES
(1, 1, '978-3-16-1484', '2024-01-01', NULL, 'DEVOLVIDO', '2024-10-10', 0),
(2, 2, '978-0-7475-32', '2024-01-02', NULL, 'EMPRESTADO', NULL, 0),
(3, 3, '978-85-359-02', '2024-01-03', '2024-01-10', 'DEVOLVIDO', NULL, 0),
(4, 4, '978-85-254-06', '2024-01-04', NULL, 'EMPRESTADO', NULL, 0),
(5, 1, '978-85-7679-1', '2024-01-05', NULL, 'DEVOLVIDO', '2024-10-10', 0),
(6, 5, '978-85-018-32', '2024-01-06', '2024-01-12', 'DEVOLVIDO', NULL, 0),
(7, 6, '978-85-508-08', '2024-01-07', NULL, 'EMPRESTADO', NULL, 0),
(8, 2, '978-85-230-39', '2024-01-08', NULL, 'EMPRESTADO', NULL, 0),
(11, 1, '978-85-508-08', '2024-10-10', '2024-10-18', 'EMPRESTADO', NULL, 0),
(12, 1, '978-85-254-06', '2024-10-12', '2024-10-29', 'DEVOLVIDO', NULL, 1),
(13, 1, '978-3-16-1484', '2024-10-12', '2024-10-24', 'EMPRESTADO', NULL, 1),
(14, 1, '978-0-3928-19', '2024-10-14', '2024-10-31', 'EMPRESTADO', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `livros`
--

CREATE TABLE `livros` (
  `ISBN` varchar(13) NOT NULL,
  `TITULO` varchar(255) DEFAULT NULL,
  `AUTOR` varchar(255) DEFAULT NULL,
  `CATEGORIA` varchar(100) DEFAULT NULL,
  `UNIDADES_DISPONIVEIS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `livros`
--

INSERT INTO `livros` (`ISBN`, `TITULO`, `AUTOR`, `CATEGORIA`, `UNIDADES_DISPONIVEIS`) VALUES
('978-0-3928-19', 'Nós Matámos o Cão-Tinhoso', 'Luís Bernardo Honwana', 'Ficção', 11),
('978-0-7475-32', 'Harry Potter e a Pedra Filosofal', 'J.K. Rowling', 'Ficção', 4),
('978-3-16-1484', 'O Senhor dos Anéis', 'J.R.R. Tolkien', 'Ficção', 9),
('978-85-018-32', 'A Moreninha', 'Joaquim Manuel de Macedo', 'Literatura Brasileira', 3),
('978-85-230-39', 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Infantil', 8),
('978-85-254-06', '1984', 'George Orwell', 'Ficção', 1),
('978-85-359-02', 'Dom Casmurro', 'Machado de Assis', 'Literatura Brasileira', 4),
('978-85-508-08', 'O Alquimista', 'Paulo Coelho', 'Ficção', 3),
('978-85-7679-1', 'A Revolução dos Bichos', 'George Orwell', 'Ficção', 6);

-- --------------------------------------------------------
--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_USUARIO` int(11) NOT NULL,
  `NOME` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `TELEFONE` varchar(15) DEFAULT NULL,
  `TIPO` enum('USUARIO','BIBLIOTECARIO','ADMINISTRADOR') DEFAULT NULL,
  `SENHA` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`ID_USUARIO`, `NOME`, `EMAIL`, `TELEFONE`, `TIPO`, `SENHA`) VALUES
(1, 'Ana Costa', 'ana.costa@gmail.com', '842517293', 'USUARIO', 'costana'),
(2, 'Bruno Almeida', 'bruno.almeida@gmail.com', '11999999902', 'USUARIO', 'Megatron10'),
(3, 'Carlos Silva', 'carlos.silva@gmail.com', '11999999903', 'BIBLIOTECARIO', 'cs1lva88'),
(4, 'Diana Oliveira', 'diana.oliveira@gmail.com', '11999999904', 'BIBLIOTECARIO', 'dol1v31ra'),
(5, 'Eduardo Martins', 'eduardo.martins@gmail.com', '11999999905', 'ADMINISTRADOR', 'emartins000'),
(6, 'Fernanda Pereira', 'fernanda.pereira@gmail.com', '11999999906', 'USUARIO', 'l1l1l1l1'),
(7, 'Gustavo Santos', 'gustavo.santos@gmail.com', '11999999907', 'USUARIO', '0ptimusPr1me'),
(8, 'Heloísa Ramos', 'heloisa.ramos@gmail.com', '11999999908', 'ADMINISTRADOR', 'sergioramos'),
(10, 'Sadia Aboobacar', 'sadiaboo@gmail.com', '840415135', 'USUARIO', 'sadia123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD PRIMARY KEY (`ID_EMPRESTIMO`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`),
  ADD KEY `LIVRO_ISBN` (`LIVRO_ISBN`);

--
-- Indexes for table `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`ISBN`);

-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_USUARIO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `ID_EMPRESTIMO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD CONSTRAINT `emprestimos_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`),
  ADD CONSTRAINT `emprestimos_ibfk_2` FOREIGN KEY (`LIVRO_ISBN`) REFERENCES `livros` (`ISBN`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
