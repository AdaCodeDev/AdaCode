-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/11/2025 às 16:59
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
-- Banco de dados: `bd_adacode`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_area`
--

CREATE TABLE `tb_area` (
  `id_area` int(11) NOT NULL,
  `nm_area` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_area`
--

INSERT INTO `tb_area` (`id_area`, `nm_area`) VALUES
(1, 'Inteligência Artificial'),
(2, 'Machine Learning'),
(3, 'Programação'),
(4, 'Desenvolvimento WEB'),
(5, 'Redes e Infraestrutura'),
(6, 'Cloud Computing'),
(7, 'Banco de Dados'),
(8, 'Cibersegurança'),
(9, 'Data Science'),
(10, 'UX/UI Design'),
(11, 'DevOps'),
(12, 'Hardware'),
(13, 'Gestão de Projetos e Produtos'),
(14, 'Sistemas Embarcados'),
(15, 'Python'),
(16, 'JavaScript'),
(17, 'TypeScript'),
(18, 'Java'),
(19, 'C#'),
(20, 'C++'),
(21, 'PHP'),
(22, 'Swift'),
(23, 'Kotlin'),
(24, 'Golang'),
(25, 'Ruby');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_curso`
--

CREATE TABLE `tb_curso` (
  `id_curso` int(11) NOT NULL,
  `nm_curso` varchar(45) NOT NULL,
  `ds_curso` varchar(500) NOT NULL,
  `ds2_curso` longtext NOT NULL,
  `nm_plataforma` varchar(40) NOT NULL,
  `fk_id_nivel` int(11) NOT NULL,
  `vl_curso` decimal(10,0) NOT NULL,
  `ch_curso` int(11) NOT NULL,
  `certificado` varchar(5) NOT NULL,
  `url_curso` varchar(200) NOT NULL,
  `url_img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_curso`
--

INSERT INTO `tb_curso` (`id_curso`, `nm_curso`, `ds_curso`, `ds2_curso`, `nm_plataforma`, `fk_id_nivel`, `vl_curso`, `ch_curso`, `certificado`, `url_curso`, `url_img`) VALUES
(5, 'Desenvolvimento Web Completo - 20 cursos + 20', 'Domine Web - 20 Cursos - HTML5, CSS3, SASS, Bootstrap, JS, ES6, PHP, OO, MySQL, JQuery, MVC, APIs, IONIC e muito mais', 'Bem vindo ao curso Desenvolvimento Web Completo - 20 cursos + 20 projetos, o curso mais completo e bem avaliado da categoria.\r\n\r\nO curso conta com mais de 620 aulas, ao todo são mais de 117 horas de videoaulas em que são abordadas as principais tecnologias web do momento.\r\n\r\nPara iniciar o treinamento não é necessário nenhum conhecimento prévio na área, o aluno partirá do zero e ao final do treinamento alcançará um nível profissional. Além disso o aluno conta com um suporte campeão para tirar suas dúvidas.\r\n\r\nEste super pacote reúne incríveis 20 cursos. Para aprender tudo o que é proposto em mais de 117 horas de treinamento o aluno irá desenvolver 20 projetos reais.\r\n\r\nAprenda agora mesmo as tecnologias: HTML5, CSS3, BootStrap 4, Java Script (ES6, ES7, ES8, ES9, ES10, ES11, ES12, ES13 e ES14), PHP, Orientação a Objetos, MySQL, PHP com PDO, Ajax, JQuery, MVC, APIs, IONIC, WordPress e muito mais! \r\n\r\nConheça o curso mais COMPLETO da Udemy, que reúne o Desenvolvimento Web front-end e back-end além de aplicações mobile, tudo na pratica.', 'Udemy', 2, 196, 120, 'Sim', 'https://www.udemy.com/course/web-completo/?couponCode=MT251110G3', '69161ba4a908a_Captura de tela 2025-11-13 144600.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_curso_area`
--

CREATE TABLE `tb_curso_area` (
  `fk_id_curso` int(11) NOT NULL,
  `fk_id_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_curso_area`
--

INSERT INTO `tb_curso_area` (`fk_id_curso`, `fk_id_area`) VALUES
(5, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_feedback`
--

CREATE TABLE `tb_feedback` (
  `id_feedback` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(200) NOT NULL,
  `feedback` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_feedback`
--

INSERT INTO `tb_feedback` (`id_feedback`, `nome`, `email`, `feedback`) VALUES
(1, 'madu', 'madu@gmail.com', 'Ótimo site, me ajudou a descobrir cursos na área. Só acho que o fórum podia ter a opção de republicar posts.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_nivel`
--

CREATE TABLE `tb_nivel` (
  `id_nivel` int(11) NOT NULL,
  `nm_nivel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_nivel`
--

INSERT INTO `tb_nivel` (`id_nivel`, `nm_nivel`) VALUES
(1, 'Iniciante'),
(2, 'Intermediário'),
(3, 'Avançado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_publicacao`
--

CREATE TABLE `tb_publicacao` (
  `id_publicacao` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `conteudo` longtext NOT NULL,
  `url_img` varchar(200) DEFAULT NULL,
  `fk_id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_publicacao`
--

INSERT INTO `tb_publicacao` (`id_publicacao`, `titulo`, `conteudo`, `url_img`, `fk_id_usuario`) VALUES
(2, 'Minha experiência com programação', 'Minha experiência com programação foi blablabla bla blabla bla blabla bla bla blablabla', NULL, 1),
(3, 'Participei do SEPEI', 'Muito legal minha experiencia, vamos participem', NULL, 2),
(4, 'ROBO SEGUIDOR DE LINHA', 'Na minha aula passada aprendi a programar no arduino para um robo seguidor de linha. Foi uma ótima experiência, pela UFSC ', NULL, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `email`, `senha`) VALUES
(1, 'madu', 'madu@gmail.com', '$2y$10$hycclXL/aLpCIUPux4ZOvOo4U4cvfJLH6OlzBNptdbWJm8TAo2m3O'),
(2, 'melissa', 'melissa@gmail.com', '$2y$10$gjnevwHyKQUp6gfeqbIHxuiKnOYutBZyrRUdkC1y81NxNT7DySRkS'),
(3, 'mari', 'mari@gmail.com', '$2y$10$I1nJ2Y4NsY6fAH/wPWph3OxHqPafmjWoZNHX.L/Dx8bsoCWi//hlW');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_area`
--
ALTER TABLE `tb_area`
  ADD PRIMARY KEY (`id_area`);

--
-- Índices de tabela `tb_curso`
--
ALTER TABLE `tb_curso`
  ADD PRIMARY KEY (`id_curso`);

--
-- Índices de tabela `tb_curso_area`
--
ALTER TABLE `tb_curso_area`
  ADD PRIMARY KEY (`fk_id_curso`,`fk_id_area`),
  ADD KEY `fk_id_area` (`fk_id_area`);

--
-- Índices de tabela `tb_feedback`
--
ALTER TABLE `tb_feedback`
  ADD PRIMARY KEY (`id_feedback`);

--
-- Índices de tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Índices de tabela `tb_publicacao`
--
ALTER TABLE `tb_publicacao`
  ADD PRIMARY KEY (`id_publicacao`);

--
-- Índices de tabela `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_area`
--
ALTER TABLE `tb_area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tb_curso`
--
ALTER TABLE `tb_curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_feedback`
--
ALTER TABLE `tb_feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_nivel`
--
ALTER TABLE `tb_nivel`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_publicacao`
--
ALTER TABLE `tb_publicacao`
  MODIFY `id_publicacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_curso_area`
--
ALTER TABLE `tb_curso_area`
  ADD CONSTRAINT `tb_curso_area_ibfk_1` FOREIGN KEY (`fk_id_curso`) REFERENCES `tb_curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_curso_area_ibfk_2` FOREIGN KEY (`fk_id_area`) REFERENCES `tb_area` (`id_area`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
