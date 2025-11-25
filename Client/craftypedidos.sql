-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2025 às 10:26
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
-- Banco de dados: `craftypedidos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `tipo_usuario` enum('cliente','admin') NOT NULL,
  `nome_completo` varchar(60) NOT NULL,
  `nome_exibicao` varchar(20) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `senha_hash` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `contato` varchar(80) DEFAULT NULL,
  `cargo` varchar(60) DEFAULT NULL,
  `status_admin` enum('online','offline','ausente','ocupado') DEFAULT NULL,
  `descricaostatus` varchar(255) DEFAULT NULL,
  `horario_trabalho` varchar(60) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`ID`, `tipo_usuario`, `nome_completo`, `nome_exibicao`, `email`, `senha_hash`, `foto_perfil`, `contato`, `cargo`, `status_admin`, `descricaostatus`, `horario_trabalho`, `criado_em`) VALUES
(17, 'cliente', 'Renann Ferreira', NULL, 'renannfsilva10@gmail.com', '$2y$10$lTFJRiERTLVsmtQj9/2eZeGLlxbisUMW8LdPcLkQZsgfJWqKCb5pC', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 05:58:51');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
