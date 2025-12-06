-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/12/2025 às 03:26
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
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `ID` int(11) NOT NULL,
  `tipo` enum('computador','perifericos','outros') DEFAULT NULL,
  `solicitante` varchar(100) DEFAULT NULL,
  `data_abertura` datetime NOT NULL DEFAULT current_timestamp(),
  `data_conclusao` datetime DEFAULT NULL,
  `data_ocorrido` date DEFAULT NULL,
  `urgencia` enum('baixa','media','alta') DEFAULT NULL,
  `status` enum('Concluído','Não resolvido','Cancelado','Incompleto','Aberto','Em andamento','Negado') DEFAULT NULL,
  `tecnico_responsavel` varchar(100) DEFAULT NULL,
  `anexo` varchar(255) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `ID_Solicitante` int(11) DEFAULT NULL,
  `setor_lab` varchar(30) NOT NULL,
  `ID_tecnico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`ID`, `tipo`, `solicitante`, `data_abertura`, `data_conclusao`, `data_ocorrido`, `urgencia`, `status`, `tecnico_responsavel`, `anexo`, `descricao`, `ID_Solicitante`, `setor_lab`, `ID_tecnico`) VALUES
(116, 'computador', 'Admin', '2025-12-05 17:20:07', NULL, '2025-12-05', 'media', 'Em andamento', 'Admin', '', 'Teste', 20, 'SalaMaker', 20),
(117, 'perifericos', 'Admin', '2025-12-05 17:40:42', NULL, '2025-12-05', 'baixa', 'Em andamento', 'Admin', '', '321321', 20, '123', 20),
(118, 'outros', 'Admin', '2025-12-05 17:40:49', NULL, '2025-12-05', 'media', 'Em andamento', 'Admin', '', '12312312', 20, '312321', 20),
(119, 'computador', 'Admin', '2025-12-05 17:40:58', NULL, '2025-12-05', 'media', 'Em andamento', 'Admin', '', '2341234214', 20, '3123123', 20),
(120, 'computador', 'Admin', '2025-12-05 18:45:09', NULL, '2025-12-05', 'media', 'Em andamento', 'Admin', 'anexo_69335265307f1.jpg', '123', 20, '123', 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamado_computador`
--

CREATE TABLE `chamado_computador` (
  `id_chamado` int(11) NOT NULL,
  `numero_pc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamado_computador`
--

INSERT INTO `chamado_computador` (`id_chamado`, `numero_pc`) VALUES
(116, 24),
(119, 2134),
(120, 123);

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamado_outros`
--

CREATE TABLE `chamado_outros` (
  `id_chamado` int(11) NOT NULL,
  `tipo_problema` enum('Wifi','Projetor','Ar-condicionado','Impressora','Outro') DEFAULT NULL,
  `tipo_personalizado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamado_outros`
--

INSERT INTO `chamado_outros` (`id_chamado`, `tipo_problema`, `tipo_personalizado`) VALUES
(118, '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamado_perifericos`
--

CREATE TABLE `chamado_perifericos` (
  `id_chamado` int(11) NOT NULL,
  `tipo_periferico` enum('Teclado','Mouse','Monitor','Outro') DEFAULT NULL,
  `tipo_personalizado` varchar(100) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamado_perifericos`
--

INSERT INTO `chamado_perifericos` (`id_chamado`, `tipo_periferico`, `tipo_personalizado`, `numero`) VALUES
(117, 'Teclado', '', '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `tipo_usuario` enum('requisitante','admin') NOT NULL,
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
(20, 'admin', 'Admin', NULL, 'admin@gmail.com', '$2y$10$EIzSk9.Le6PRQVGgGWzqmOr4rvuzoKgxasdQwTCKdnoKYXj5C1YzG', 'anexo_693333f7d3d79.jfif', 'admin@gmail.com', NULL, NULL, NULL, NULL, '2025-12-05 13:46:51');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_solicitante` (`ID_Solicitante`);

--
-- Índices de tabela `chamado_computador`
--
ALTER TABLE `chamado_computador`
  ADD PRIMARY KEY (`id_chamado`);

--
-- Índices de tabela `chamado_outros`
--
ALTER TABLE `chamado_outros`
  ADD PRIMARY KEY (`id_chamado`);

--
-- Índices de tabela `chamado_perifericos`
--
ALTER TABLE `chamado_perifericos`
  ADD PRIMARY KEY (`id_chamado`);

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
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `fk_solicitante` FOREIGN KEY (`ID_Solicitante`) REFERENCES `usuarios` (`ID`);

--
-- Restrições para tabelas `chamado_computador`
--
ALTER TABLE `chamado_computador`
  ADD CONSTRAINT `chamado_computador_ibfk_1` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`ID`);

--
-- Restrições para tabelas `chamado_outros`
--
ALTER TABLE `chamado_outros`
  ADD CONSTRAINT `chamado_outros_ibfk_1` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`ID`);

--
-- Restrições para tabelas `chamado_perifericos`
--
ALTER TABLE `chamado_perifericos`
  ADD CONSTRAINT `chamado_perifericos_ibfk_1` FOREIGN KEY (`id_chamado`) REFERENCES `chamados` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
