-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12-Maio-2017 às 03:03
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `locadora`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(2) NOT NULL,
  `descricao` varchar(20) NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descricao`, `valor`) VALUES
(1, 'SUV', 200),
(2, 'Passeio', 100),
(3, 'Van', 270);

-- --------------------------------------------------------

--
-- Estrutura da tabela `exemplares`
--

CREATE TABLE `exemplares` (
  `id_exemplar` int(11) NOT NULL,
  `placa_veiculo` varchar(8) NOT NULL,
  `id_locacao` int(11) NOT NULL,
  `locado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `locacao`
--

CREATE TABLE `locacao` (
  `id_locacao` int(11) NOT NULL,
  `data` date NOT NULL,
  `valor_total` float NOT NULL,
  `cpf_socio` varchar(11) NOT NULL,
  `id_veiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `socios`
--

CREATE TABLE `socios` (
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `rg` varchar(12) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `email` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `user` text,
  `senha` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `placa` varchar(8) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `anoFabricacao` int(10) UNSIGNED DEFAULT NULL,
  `fabricante` varchar(30) DEFAULT NULL,
  `opcionais` text,
  `motorizacao` varchar(50) NOT NULL,
  `valorBase` float NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `exemplares`
--
ALTER TABLE `exemplares`
  ADD PRIMARY KEY (`id_exemplar`);

--
-- Indexes for table `locacao`
--
ALTER TABLE `locacao`
  ADD PRIMARY KEY (`id_locacao`);

--
-- Indexes for table `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`placa`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
