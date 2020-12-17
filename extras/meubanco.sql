-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Dez-2020 às 16:36
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `meubanco`
--
CREATE DATABASE IF NOT EXISTS `meubanco` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `meubanco`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas`
--

CREATE TABLE `contas` (
  `idConta` int(11) NOT NULL,
  `idPessoa` int(11) NOT NULL,
  `saldo` float NOT NULL DEFAULT 0,
  `limiteSaqueDiario` float NOT NULL,
  `flagAtivo` tinyint(1) NOT NULL DEFAULT 1,
  `tipoConta` int(11) NOT NULL,
  `dataCriacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `contas`
--

INSERT INTO `contas` (`idConta`, `idPessoa`, `saldo`, `limiteSaqueDiario`, `flagAtivo`, `tipoConta`, `dataCriacao`) VALUES
(1, 1, 118.87, 500, 1, 13, '2020-12-16 11:25:32'),
(3, 3, 100.5, 10, 0, 17, '2020-12-16 21:21:16'),
(4, 2, 987550, 10000, 1, 25, '2020-12-17 00:20:38');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `idPessoa` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cpf` char(14) NOT NULL,
  `dataNascimento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO `pessoas` (`idPessoa`, `nome`, `cpf`, `dataNascimento`) VALUES
(1, 'Jhon Doe', '849.744.770-05', '1999-11-17 03:00:00'),
(2, 'José da Silva', '930.394.400-39', '1990-07-10 03:00:00'),
(3, 'Maria Clara', '489.794.760-00', '2000-10-02 03:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `transacoes`
--

CREATE TABLE `transacoes` (
  `idTransacao` int(11) NOT NULL,
  `idConta` int(11) NOT NULL,
  `valor` float NOT NULL,
  `dataTransacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `transacoes`
--

INSERT INTO `transacoes` (`idTransacao`, `idConta`, `valor`, `dataTransacao`) VALUES
(1, 1, 117.99, '2019-12-16 12:59:43'),
(2, 1, -10, '2019-12-17 12:59:43'),
(3, 3, 100.5, '2020-11-16 12:59:43'),
(4, 1, -50.25, '2020-12-01 12:59:43'),
(5, 1, -24, '2020-12-16 18:24:43'),
(6, 1, 50, '2020-12-16 18:35:43'),
(7, 1, 2, '2020-12-16 19:08:32'),
(8, 1, -2, '2020-12-16 19:10:00'),
(9, 1, -2, '2020-12-16 19:17:12'),
(10, 1, -2, '2020-12-16 19:18:10'),
(11, 1, -0.5, '2020-12-16 19:18:49'),
(12, 1, -0.26, '2020-12-16 19:22:28'),
(13, 1, -0.24, '2020-12-16 19:25:03'),
(14, 1, -10, '2020-12-16 19:37:09'),
(15, 4, 987550, '2020-12-16 19:37:44'),
(16, 1, -0.24, '2020-12-17 13:44:41'),
(17, 1, 50.37, '2020-12-17 13:47:28');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`idConta`),
  ADD KEY `FK_PessoaId` (`idPessoa`);

--
-- Índices para tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`idPessoa`);

--
-- Índices para tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD PRIMARY KEY (`idTransacao`),
  ADD KEY `FK_ContaId` (`idConta`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `contas`
--
ALTER TABLE `contas`
  MODIFY `idConta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `idPessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `transacoes`
--
ALTER TABLE `transacoes`
  MODIFY `idTransacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `contas`
--
ALTER TABLE `contas`
  ADD CONSTRAINT `FK_PessoaId` FOREIGN KEY (`idPessoa`) REFERENCES `pessoas` (`idPessoa`);

--
-- Limitadores para a tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `FK_ContaId` FOREIGN KEY (`idConta`) REFERENCES `contas` (`idConta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
