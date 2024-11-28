-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2024 às 23:48
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
-- Banco de dados: `barbearia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `nivel_usuario` enum('administrador','funcionario') NOT NULL,
  `porcentagem` decimal(5,2) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario_cadastro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `nivel_usuario`, `porcentagem`, `celular`, `sexo`, `data_cadastro`, `id_usuario_cadastro`) VALUES
(1, 'diezare', 'administrador', 0.00, '(43)99951-4950', 'MASCULINO', '2024-11-19 22:51:08', 0),
(2, 'teste', 'administrador', 50.00, '(44) 44444-4444', 'Masculino', '2024-11-19 22:51:08', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_acessos`
--

CREATE TABLE `log_acessos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ip_usuario` varchar(50) NOT NULL,
  `data_tentativa` datetime NOT NULL,
  `status` enum('permitido','negado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_login`
--

CREATE TABLE `log_login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('sucesso','falha') DEFAULT NULL,
  `data_hora` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `log_login`
--

INSERT INTO `log_login` (`id`, `username`, `ip_address`, `status`, `data_hora`) VALUES
(1, 'gf', '::1', 'falha', '2024-11-27 13:08:17'),
(2, 'diezare', '::1', 'falha', '2024-11-27 13:14:20'),
(3, 'diezare', '::1', 'falha', '2024-11-27 13:14:25'),
(4, 'diezare', '::1', 'falha', '2024-11-27 13:14:32'),
(5, 'diezare', '::1', 'falha', '2024-11-27 13:14:36'),
(6, 'diezare', '::1', 'falha', '2024-11-27 13:14:39'),
(7, 'diezare', '::1', 'falha', '2024-11-27 13:21:58'),
(8, 'diezare', '::1', 'falha', '2024-11-27 13:22:01'),
(9, 'diezare', '::1', 'falha', '2024-11-27 13:25:52'),
(10, 'diezare', '::1', 'falha', '2024-11-27 13:33:28'),
(11, 'diezare', '::1', 'falha', '2024-11-27 13:36:19'),
(12, 'diezare', '::1', 'falha', '2024-11-27 13:42:07'),
(13, 'diezare', '::1', 'falha', '2024-11-27 13:42:11'),
(14, 'diezare', '::1', 'falha', '2024-11-27 13:48:14'),
(15, 'diezare', '::1', 'falha', '2024-11-27 13:51:04'),
(16, 'diezare', '::1', 'sucesso', '2024-11-27 13:51:08'),
(17, 'diezare', '::1', 'sucesso', '2024-11-27 16:42:25'),
(18, 'diezare', '::1', 'sucesso', '2024-11-27 16:42:30'),
(19, 'diezare', '::1', 'sucesso', '2024-11-27 16:45:21'),
(20, 'diezare', '::1', 'sucesso', '2024-11-27 17:00:31'),
(21, 'diezare', '::1', 'sucesso', '2024-11-27 17:07:10'),
(22, 'diezare', '::1', 'sucesso', '2024-11-27 17:07:27'),
(23, 'diezare', '::1', 'sucesso', '2024-11-27 17:07:43'),
(24, 'diezare', '::1', 'sucesso', '2024-11-27 17:26:44'),
(25, 'diezare', '::1', 'sucesso', '2024-11-27 17:29:40'),
(35, 'diezare', '::1', 'sucesso', '2024-11-27 19:37:53'),
(36, 'diezare', '::1', 'sucesso', '2024-11-27 19:39:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `paginas`
--

CREATE TABLE `paginas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `paginas`
--

INSERT INTO `paginas` (`id`, `nome`, `caminho`) VALUES
(1, 'Cadastro de Funcionários', 'http://localhost/gil/pages/cadastros/funcionario.php'),
(2, 'Página Principal', '/gil/pages/index.php');

-- --------------------------------------------------------

--
-- Estrutura para tabela `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `total_recebido` decimal(10,2) NOT NULL,
  `valor_funcionario` decimal(10,2) NOT NULL,
  `lucro_dono` decimal(10,2) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario_cadastro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome_servico` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario_cadastro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario_cadastro` int(11) NOT NULL,
  `data_alteracao_senha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `id_funcionario`, `data_cadastro`, `id_usuario_cadastro`, `data_alteracao_senha`) VALUES
(2, 'diezare', '$2y$10$wUKRw3LpJEMQIRq99E9nTOY1nHWk7cgJOckUbbOQN6sXKlbIdb4nO', 1, '2024-11-27 13:50:44', 1, NULL);

--
-- Acionadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `before_update_usuarios` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN
    IF NEW.password != OLD.password THEN
        SET NEW.password = PASSWORD(NEW.password);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_paginas`
--

CREATE TABLE `usuario_paginas` (
  `id_usuario` int(11) NOT NULL,
  `id_pagina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_paginas`
--

INSERT INTO `usuario_paginas` (`id_usuario`, `id_pagina`) VALUES
(2, 1),
(2, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `log_acessos`
--
ALTER TABLE `log_acessos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `usuario_paginas`
--
ALTER TABLE `usuario_paginas`
  ADD PRIMARY KEY (`id_usuario`,`id_pagina`),
  ADD KEY `fk_pagina` (`id_pagina`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `log_acessos`
--
ALTER TABLE `log_acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `log_login`
--
ALTER TABLE `log_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `log_acessos`
--
ALTER TABLE `log_acessos`
  ADD CONSTRAINT `log_acessos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`),
  ADD CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`);

--
-- Restrições para tabelas `usuario_paginas`
--
ALTER TABLE `usuario_paginas`
  ADD CONSTRAINT `fk_pagina` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id`),
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
