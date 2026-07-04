-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 28/06/2026 às 13:08
-- Versão do servidor: 8.0.44
-- Versão do PHP: 8.3.30
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Banco de dados: `locadoraVeiculos`
--

-- --------------------------------------------------------
--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int NOT NULL,
  `descricao` varchar(20) NOT NULL,
  `valor` float NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descricao`, `valor`)
VALUES (1, 'SUV', 200),
  (2, 'Passeio', 100),
  (3, 'Van', 270);
-- --------------------------------------------------------
--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `rg` varchar(12) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (
    `cpf`,
    `nome`,
    `rg`,
    `endereco`,
    `telefone`,
    `email`
  )
VALUES (
    '00000000000',
    'Administrador Teste',
    '000000000',
    'Rua Exemplo, 123',
    '00000000000',
    'teste@email'
  ),
  (
    '19292929',
    'dfsdkj',
    '2929',
    'sfdfsdfsdfdsfsd',
    '333333333',
    'sdfd@email'
<<<<<<< HEAD
  ),
  (
    '11122233344',
    'Cliente Teste 1',
    '4455667',
    'Rua Teste, 456',
    '27999990000',
    'teste1@email'
=======
>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c
  );
-- --------------------------------------------------------
--
-- Estrutura para tabela `exemplares`
--

CREATE TABLE `exemplares` (
  `id_exemplar` int NOT NULL,
  `placa_veiculo` varchar(8) NOT NULL,
  `id_locacao` int NOT NULL,
  `locado` tinyint(1) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
-- --------------------------------------------------------
--
-- Estrutura para tabela `locacao`
--

CREATE TABLE `locacao` (
  `id_locacao` int NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `data_fim` datetime DEFAULT NULL,
  `valor_total` float NOT NULL,
  `cpf_socio` varchar(11) NOT NULL,
  `id_veiculo` varchar(8) NOT NULL,
  `devolvida` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_locacao`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
-- --------------------------------------------------------
--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `user` varchar(150) NOT NULL,
  `senha` text,
  `perfil` varchar(20) DEFAULT 'cliente'
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`user`, `senha`, `perfil`)
VALUES ('sdfd@email', '123456', 'c'),
  ('teste1@email', '1234', 'C'),
  ('teste@email', '1234', 'A');
-- --------------------------------------------------------
--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `placa` varchar(8) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `anoFabricacao` int UNSIGNED DEFAULT NULL,
  `fabricante` varchar(30) DEFAULT NULL,
  `opcionais` text,
  `motorizacao` varchar(50) NOT NULL,
  `valorBase` float NOT NULL,
  `id_categoria` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
ADD PRIMARY KEY (`id_categoria`);
--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
ADD PRIMARY KEY (`cpf`),
  ADD KEY `fk_socio_usuario` (`email`);
--
-- Índices de tabela `exemplares`
--
ALTER TABLE `exemplares`
ADD PRIMARY KEY (`id_exemplar`);
--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
ADD PRIMARY KEY (`user`);
--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
ADD PRIMARY KEY (`placa`);
--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `clientes`
--
ALTER TABLE `clientes`
ADD CONSTRAINT `fk_socio_usuario` FOREIGN KEY (`email`) REFERENCES `usuarios` (`user`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
INSERT INTO veiculos (
    placa,
    nome,
    anoFabricacao,
    fabricante,
    opcionais,
    motorizacao,
    valorBase,
    id_categoria
  )
VALUES (
    'ABC1D23',
    'Compass',
    2023,
    'Jeep',
    'Ar-condicionado, Direção elétrica, Câmbio automático',
    '2.0 Turbo Flex',
    250,
    1
  ),
  (
    'DEF4E56',
    'Tracker',
    2022,
    'Chevrolet',
    'Ar-condicionado, Multimídia, Sensor de estacionamento',
    '1.2 Turbo',
    220,
    1
  ),
  (
    'GHI7F89',
    'Onix',
    2023,
    'Chevrolet',
    'Ar-condicionado, Direção elétrica',
    '1.0 Flex',
    120,
    2
  ),
  (
    'JKL0G12',
    'HB20',
    2022,
    'Hyundai',
    'Ar-condicionado, Multimídia',
    '1.0 Flex',
    110,
    2
  ),
  (
    'MNO3H45',
    'Corolla',
    2023,
    'Toyota',
    'Ar-condicionado, Câmbio automático, Bancos em couro',
    '2.0 Flex',
    180,
    2
  ),
  (
    'PQR6I78',
    'Master',
    2021,
    'Renault',
    'Ar-condicionado, 15 lugares',
    '2.3 Diesel',
    280,
    3
  ),
  (
    'STU9J01',
    'Sprinter',
    2022,
    'Mercedes-Benz',
    'Ar-condicionado, 16 lugares',
    '2.2 Diesel',
    320,
    3
  );