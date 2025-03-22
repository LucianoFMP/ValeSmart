-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/11/2024 às 14:26
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `usuarios`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_aluno`
--

CREATE TABLE `cadastro_aluno` (
  `ID` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `endereco_id` int(10) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastro_aluno`
--

INSERT INTO `cadastro_aluno` (`ID`, `nome`, `matricula`, `telefone`, `email`, `endereco_id`, `status`) VALUES
(12, 'Diogo Vieira', 'MAT001', '48988151523', 'diogo.vieira@aluno.fmpsc.edu.br', 24, ''),
(13, 'Vitor Machado', 'MAT002', '48988151522', 'vitor.machado@aluno.fmpsc.edu.br', 25, '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastro_aluno`
--
ALTER TABLE `cadastro_aluno`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `endereco_id` (`endereco_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro_aluno`
--
ALTER TABLE `cadastro_aluno`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
