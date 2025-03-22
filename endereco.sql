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
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `ID` int(10) NOT NULL,
  `CEP` int(8) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` int(5) NOT NULL,
  `complemento` varchar(100) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `comprovante` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`ID`, `CEP`, `rua`, `numero`, `complemento`, `bairro`, `comprovante`) VALUES
(1, 88137074, 'Rua da Universidade', 89, 'APTO 304B', 'Pedra Branca', 'uploads/672789446058'),
(2, 88135432, 'Rua Giovanni Pisano', 500, 'APTO 1010', 'Aririú', 'uploads/67278d385122'),
(3, 88130685, 'Rua Acácio Santiago', 105, '', 'Ponte do Imaruim', 'uploads/67278f9e02ee'),
(4, 88132599, 'Avenida Paulo Roberto Vidal', 280, 'APTO 101', 'Bela Vista', 'uploads/672791a2aeb4'),
(5, 88130005, 'Rua Caetano Silveira de Matos', 230, '', 'Centro', 'uploads/6727925aa051'),
(6, 88135, 'Rua Antônio Luiz Pereira', 786, '', 'Guarda do Cubatão', 'uploads/672792dab5d0'),
(7, 88132209, 'Rua Bergamo', 35, '', 'Pagani', 'uploads/6728cb69a5aa'),
(8, 88136565, 'Rua Ilha do Pico', 899, '', 'São Sebastião', 'uploads/672e84667cb5'),
(9, 88136303, 'Rua das Ameixas', 55, '', 'Madri', 'uploads/672ecf345130'),
(10, 88136343, 'Rua das Uvaias', 78, '', 'Madri', 'uploads/672ed5d85309'),
(11, 88135015, 'Rua Iracema Schaimann Weingartner', 112, '', 'Aririú', 'uploads/672ee60c84a6'),
(12, 88135015, 'Rua Iracema Schaimann Weingartner', 345, '', 'Aririú', 'uploads/672ee65bd14a'),
(13, 88137074, 'Rua da Universidade', 110, '', 'Pedra Branca', 'uploads/672ee6ca20fb'),
(14, 88131000, 'Rua José Maria da Luz', 143, 'APTO 1001', 'Centro', 'uploads/672ee933d7c2'),
(15, 88137074, 'Rua da Universidade', 55, 'APTO 101A', 'Pedra Branca', 'uploads/672fc39029d7'),
(16, 88135437, 'Avenida da Inovação', 876, '', 'Aririú', 'uploads/6730185a4126'),
(17, 88135307, 'Servidão Rafael Manoel da Silva', 432, '', 'Aririú', 'uploads/67301a605834'),
(18, 88135235, 'Rua Antônia Job', 437, '', 'Aririú', 'uploads/67301d7cd402'),
(19, 88139181, 'Rua Teofilo Scheidt', 439, '', 'Pinheira', 'uploads/6730abb5dfd9'),
(20, 88134785, 'Rua Genoveva Generosa de Jesus', 235, '', 'Aririú da Formiga', 'uploads/6739f2564b78'),
(21, 88134734, 'Rua Barcelona', 112, '', 'Aririú da Formiga', 'uploads/6739f406e921'),
(22, 88134758, 'Rua Francisco Melo', 760, '', 'Aririú da Formiga', 'uploads/6739fa65c453'),
(23, 88136500, 'Avenida Alaor Silveira', 765, '', 'São Sebastião', 'uploads/673b2af4eb18'),
(24, 88132495, 'Rua Orivaldo Pedro Pereira', 12, '', 'Caminho Novo', 'uploads/6749a249612f'),
(25, 88132887, 'Rua Beatriz Segall', 198, '', 'Bela Vista', 'uploads/6749ad26e97e');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
