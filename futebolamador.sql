-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2019 at 10:36 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `futebolamador`
--

-- --------------------------------------------------------

--
-- Table structure for table `campos`
--

CREATE TABLE `campos` (
  `Nome_campo` varchar(100) NOT NULL,
  `GPS` varchar(100) DEFAULT NULL,
  `Rua` varchar(100) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `Cidade` varchar(100) DEFAULT NULL,
  `Custo` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campos`
--

INSERT INTO `campos` (`Nome_campo`, `GPS`, `Rua`, `Numero`, `Cidade`, `Custo`) VALUES
('Campo de Futebol - Hospital dos Covões', '40.197823,-8.4750585', 'R. Carminé de Miranda', 55, 'Coimbra', 10),
('Associação Recreativa Casaense', '40.2000229,-8.4845351', '25 de Abril - Estremão', NULL, 'Coimbra', 25),
('Campo de Santa Cruz', '40.1973705,-8.4449741', 'R. Lourenço de Almeida Azevedo', 19, 'Coimbra', 20);

-- --------------------------------------------------------

--
-- Table structure for table `capitaes`
--

CREATE TABLE `capitaes` (
  `CC` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `capitaes`
--

INSERT INTO `capitaes` (`CC`) VALUES
('11111111'),
('12'),
('12334'),
('1234'),
('14'),
('15'),
('20'),
('90');

-- --------------------------------------------------------

--
-- Table structure for table `equipas`
--

CREATE TABLE `equipas` (
  `Nome_equipa` varchar(100) NOT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `Nome_torneio` varchar(100) NOT NULL,
  `CC` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipas`
--

INSERT INTO `equipas` (`Nome_equipa`, `Estado`, `Nome_torneio`, `CC`) VALUES
('Equipa 1', 1, 'Torneio 1', '12334'),
('Equipa 4', 1, 'Torneio 1', '14'),
('Equipa 2', 1, 'Torneio 1', '15'),
('Equipa 3', 1, 'Torneio 1', '1234'),
('Equipa 5', 1, 'Torneio 2', '20'),
('Equipa 6', 0, 'Torneio 3', '90'),
('Equipa 7', 1, 'Torneio 2', '12'),
('Equipa 8', 0, 'Torneio 3', '11111111');

-- --------------------------------------------------------

--
-- Table structure for table `equipas_jogadores`
--

CREATE TABLE `equipas_jogadores` (
  `Nome_equipa` varchar(100) NOT NULL,
  `CC` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipas_jogadores`
--

INSERT INTO `equipas_jogadores` (`Nome_equipa`, `CC`) VALUES
('Equipa 1', '11111111'),
('Equipa 1', '12'),
('Equipa 1', '12334'),
('Equipa 1', '13'),
('Equipa 1', '14'),
('Equipa 1', '15'),
('Equipa 2', '12'),
('Equipa 2', '15'),
('Equipa 2', '2345'),
('Equipa 3', '1234'),
('Equipa 4', '13'),
('Equipa 4', '14'),
('Equipa 4', '3456'),
('Equipa 5', '20'),
('Equipa 6', '90');

-- --------------------------------------------------------

--
-- Table structure for table `gestores_torneio`
--

CREATE TABLE `gestores_torneio` (
  `CC` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gestores_torneio`
--

INSERT INTO `gestores_torneio` (`CC`) VALUES
('11111111'),
('12334');

-- --------------------------------------------------------

--
-- Table structure for table `gestores_torneio_torneios`
--

CREATE TABLE `gestores_torneio_torneios` (
  `CC` varchar(12) NOT NULL,
  `Nome_torneio` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gestores_torneio_torneios`
--

INSERT INTO `gestores_torneio_torneios` (`CC`, `Nome_torneio`) VALUES
('11111111', 'Torneio 1'),
('11111111', 'Torneio 2'),
('11111111', 'Torneio 3'),
('12334', 'Torneio 1');

-- --------------------------------------------------------

--
-- Table structure for table `jogadores`
--

CREATE TABLE `jogadores` (
  `CC` varchar(12) NOT NULL,
  `Prioridade_conv` int(11) DEFAULT NULL,
  `Numero_falhas` int(11) DEFAULT NULL,
  `Saldo` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jogadores_jogo`
--

CREATE TABLE `jogadores_jogo` (
  `id_jogo` int(11) NOT NULL,
  `Nome_torneio` varchar(100) NOT NULL,
  `CC` varchar(12) NOT NULL,
  `Nome_equipa` varchar(100) NOT NULL,
  `Posicao` varchar(100) DEFAULT NULL,
  `Suplente` tinyint(1) DEFAULT NULL,
  `Golos_marcados` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jogos`
--

CREATE TABLE `jogos` (
  `id_jogo` int(11) NOT NULL,
  `Nome_torneio` varchar(100) NOT NULL,
  `Data` date DEFAULT NULL,
  `Golos_visitantes` int(11) DEFAULT NULL,
  `Golos_visitados` int(11) DEFAULT NULL,
  `Nome_equipa_visitante` varchar(100) NOT NULL,
  `Nome_equipa_visitada` varchar(100) NOT NULL,
  `id_slot` int(11) NOT NULL,
  `Jornada` int(11) NOT NULL,
  `Volta` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jogos`
--

INSERT INTO `jogos` (`id_jogo`, `Nome_torneio`, `Data`, `Golos_visitantes`, `Golos_visitados`, `Nome_equipa_visitante`, `Nome_equipa_visitada`, `id_slot`, `Jornada`, `Volta`) VALUES
(224, 'Torneio 1', '2020-01-06', NULL, NULL, 'Equipa 3', 'Equipa 2', 14, 3, 2),
(223, 'Torneio 1', '2020-01-02', NULL, NULL, 'Equipa 4', 'Equipa 1', 15, 3, 2),
(222, 'Torneio 1', '2019-12-30', NULL, NULL, 'Equipa 2', 'Equipa 4', 14, 2, 2),
(221, 'Torneio 1', '2019-12-26', NULL, NULL, 'Equipa 3', 'Equipa 1', 15, 2, 2),
(220, 'Torneio 1', '2019-12-23', NULL, NULL, 'Equipa 4', 'Equipa 3', 14, 1, 2),
(219, 'Torneio 1', '2019-12-19', NULL, NULL, 'Equipa 2', 'Equipa 1', 15, 1, 2),
(218, 'Torneio 1', '2019-12-16', NULL, NULL, 'Equipa 3', 'Equipa 2', 14, 3, 1),
(217, 'Torneio 1', '2019-12-12', NULL, NULL, 'Equipa 4', 'Equipa 1', 15, 3, 1),
(216, 'Torneio 1', '2019-12-09', NULL, NULL, 'Equipa 2', 'Equipa 4', 14, 2, 1),
(215, 'Torneio 1', '2019-12-05', NULL, NULL, 'Equipa 3', 'Equipa 1', 15, 2, 1),
(214, 'Torneio 1', '2019-12-02', NULL, NULL, 'Equipa 4', 'Equipa 3', 14, 1, 1),
(213, 'Torneio 1', '2019-11-28', NULL, NULL, 'Equipa 2', 'Equipa 1', 15, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifica`
--

CREATE TABLE `notifica` (
  `CC_autor` varchar(12) NOT NULL,
  `CC` varchar(12) DEFAULT NULL,
  `id_notificacao` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifica`
--

INSERT INTO `notifica` (`CC_autor`, `CC`, `id_notificacao`) VALUES
('14', '11111111', '1'),
('12334', '11111111', '2');

-- --------------------------------------------------------

--
-- Table structure for table `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id_notificacao` char(10) NOT NULL,
  `Texto` varchar(1000) DEFAULT NULL,
  `Data` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notificacoes`
--

INSERT INTO `notificacoes` (`id_notificacao`, `Texto`, `Data`) VALUES
('1', 'Criada Equipa 4 no Torneio 1.', '2019-11-26'),
('2', 'Adicionado resultado de jogo 2-1 no Torneio 1.', '2019-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `posicoes desejadas`
--

CREATE TABLE `posicoes desejadas` (
  `Posicao` varchar(100) DEFAULT NULL,
  `CC` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `CC` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservas torneios`
--

CREATE TABLE `reservas torneios` (
  `CC` varchar(12) NOT NULL,
  `Nome_torneio` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE `slot` (
  `id_slot` int(11) NOT NULL,
  `Nome_campo` varchar(100) NOT NULL,
  `Hora_inicio` time DEFAULT NULL,
  `Hora_fim` time DEFAULT NULL,
  `Dia_semana` varchar(100) DEFAULT NULL,
  `Numero_dia` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slot`
--

INSERT INTO `slot` (`id_slot`, `Nome_campo`, `Hora_inicio`, `Hora_fim`, `Dia_semana`, `Numero_dia`) VALUES
(14, 'Campo de Santa Cruz', '19:00:00', '20:00:00', 'Segunda-feira', 1),
(15, 'Associação Recreativa Casaense', '19:20:00', '20:30:00', 'Quinta-feira', 4),
(16, 'Campo de Futebol - Hospital dos Covões', '18:00:00', '19:30:00', 'Segunda-feira', 1),
(17, 'Campo de Futebol - Hospital dos Covões', '18:00:00', '19:30:00', 'Quarta-feira', 3),
(18, 'Associação Recreativa Casaense', '18:30:00', '20:00:00', 'Sexta-feira', 5),
(19, 'Campo de Santa Cruz', '20:30:00', '21:00:00', 'Quarta-feira', 3),
(20, 'Associação Recreativa Casaense', '10:00:00', '11:30:00', 'Sábado', 6),
(21, 'Associação Recreativa Casaense', '11:00:00', '12:30:00', 'Domingo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `slot_torneios`
--

CREATE TABLE `slot_torneios` (
  `id_slot` int(11) NOT NULL,
  `Nome_torneio` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slot_torneios`
--

INSERT INTO `slot_torneios` (`id_slot`, `Nome_torneio`) VALUES
(14, 'Torneio 1'),
(15, 'Torneio 1'),
(16, 'Torneio 2'),
(17, 'Torneio 2'),
(18, 'Torneio 2'),
(19, 'Torneio 3'),
(20, 'Torneio 3'),
(21, 'Torneio 3');

-- --------------------------------------------------------

--
-- Table structure for table `torneios`
--

CREATE TABLE `torneios` (
  `Nome_torneio` varchar(100) NOT NULL,
  `Data_inicio` date NOT NULL,
  `Data_fim` date NOT NULL,
  `Numero_confrontos` int(11) NOT NULL,
  `Estado` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `torneios`
--

INSERT INTO `torneios` (`Nome_torneio`, `Data_inicio`, `Data_fim`, `Numero_confrontos`, `Estado`) VALUES
('Torneio 3', '2019-11-03', '2019-11-30', 0, 0),
('Torneio 2', '2019-12-01', '2020-01-06', 0, 0),
('Torneio 1', '2019-11-28', '2020-01-06', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `utilizadores`
--

CREATE TABLE `utilizadores` (
  `CC` varchar(12) NOT NULL,
  `Primeiro_nome` varchar(100) NOT NULL,
  `Ultimo_nome` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Telemovel` int(11) DEFAULT NULL,
  `Admin` tinyint(1) DEFAULT NULL,
  `Confirmado` tinyint(1) NOT NULL DEFAULT 0,
  `Banido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilizadores`
--

INSERT INTO `utilizadores` (`CC`, `Primeiro_nome`, `Ultimo_nome`, `Email`, `Password`, `Username`, `Telemovel`, `Admin`, `Confirmado`, `Banido`) VALUES
('123456784ds5', 'administrador', 'boss', 'admin@gmail.com', 'adminadmin', 'Admin', 914689657, 1, 0, 0),
('123456822as5', 'Rita', 'Garrido', 'ritagarrido@hotmail.com', 'ritapass', 'RitaG', 914914689, 0, 0, 0),
('12334', 'Alberto', 'Matos', 'alberto@gmail.com', '123', 'alberto', 910001111, 0, 1, 0),
('1234', 'Antonio', 'Pereira', 'antonio@gmail.com', '123', 'antonio', 910001111, 0, 1, 0),
('2345', 'Maria', 'Santos', 'maia@gmail.com', '123', 'maria', 910001111, 0, 1, 0),
('11111111', 'Filipa', 'Martins', 'filipa@gmail.com', '123', 'filipamartins', 911111111, 1, 1, 0),
('12', 'Raquel', 'Silva', 'raquel@gmail.com', '123', 'raquel', 910000000, 0, 1, 0),
('13', 'Marco', 'Oliveira', 'marco@gmail.com', '123', 'marco', 910000000, 0, 1, 0),
('14', 'Pedro', 'Gusmão', 'pedro@gmail.com', '123', 'pedro', 910000000, 0, 1, 0),
('15', 'Rui', 'Filipe', 'rui@gmail.com', '123', 'rui', 910000000, 0, 1, 0),
('3456', 'André', 'Vieira', 'andre@gmail.com', '123', 'andre', 919999999, 0, 1, 0),
('20', 'João', 'Ferreira', 'joao@gmail.com', '123', 'joão', 919999999, 0, 1, 0),
('90', 'Bernardo', 'Teles', 'bernardo@gmail.com', '123', 'bernardo', 919999999, 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campos`
--
ALTER TABLE `campos`
  ADD PRIMARY KEY (`Nome_campo`);

--
-- Indexes for table `capitaes`
--
ALTER TABLE `capitaes`
  ADD PRIMARY KEY (`CC`);

--
-- Indexes for table `equipas`
--
ALTER TABLE `equipas`
  ADD PRIMARY KEY (`Nome_equipa`),
  ADD KEY `RefTorneios20` (`Nome_torneio`),
  ADD KEY `RefCapitaes21` (`CC`);

--
-- Indexes for table `equipas_jogadores`
--
ALTER TABLE `equipas_jogadores`
  ADD PRIMARY KEY (`Nome_equipa`,`CC`),
  ADD KEY `RefJogadores24` (`CC`);

--
-- Indexes for table `gestores_torneio`
--
ALTER TABLE `gestores_torneio`
  ADD PRIMARY KEY (`CC`);

--
-- Indexes for table `gestores_torneio_torneios`
--
ALTER TABLE `gestores_torneio_torneios`
  ADD PRIMARY KEY (`CC`,`Nome_torneio`),
  ADD KEY `RefTorneios16` (`Nome_torneio`);

--
-- Indexes for table `jogadores`
--
ALTER TABLE `jogadores`
  ADD PRIMARY KEY (`CC`);

--
-- Indexes for table `jogadores_jogo`
--
ALTER TABLE `jogadores_jogo`
  ADD PRIMARY KEY (`id_jogo`,`Nome_torneio`,`CC`),
  ADD KEY `RefEquipas25` (`Nome_equipa`),
  ADD KEY `RefJogadores27` (`CC`);

--
-- Indexes for table `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id_jogo`,`Nome_torneio`),
  ADD KEY `RefTorneios29` (`Nome_torneio`),
  ADD KEY `RefEquipas32` (`Nome_equipa_visitante`),
  ADD KEY `RefEquipas33` (`Nome_equipa_visitada`),
  ADD KEY `RefSlot37` (`id_slot`);

--
-- Indexes for table `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`CC_autor`),
  ADD KEY `RefNotificacoes55` (`id_notificacao`),
  ADD KEY `RefUtilizadores56` (`CC`);

--
-- Indexes for table `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id_notificacao`);

--
-- Indexes for table `posicoes desejadas`
--
ALTER TABLE `posicoes desejadas`
  ADD KEY `RefJogadores7` (`CC`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`CC`);

--
-- Indexes for table `reservas torneios`
--
ALTER TABLE `reservas torneios`
  ADD PRIMARY KEY (`CC`,`Nome_torneio`),
  ADD KEY `RefTorneios13` (`Nome_torneio`);

--
-- Indexes for table `slot`
--
ALTER TABLE `slot`
  ADD PRIMARY KEY (`id_slot`),
  ADD KEY `Nome_campo` (`Nome_campo`);

--
-- Indexes for table `slot_torneios`
--
ALTER TABLE `slot_torneios`
  ADD PRIMARY KEY (`id_slot`,`Nome_torneio`),
  ADD KEY `RefTorneios36` (`Nome_torneio`);

--
-- Indexes for table `torneios`
--
ALTER TABLE `torneios`
  ADD PRIMARY KEY (`Nome_torneio`);

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`CC`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id_jogo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `slot`
--
ALTER TABLE `slot`
  MODIFY `id_slot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
