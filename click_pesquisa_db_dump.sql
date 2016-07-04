-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 04-Jul-2016 às 14:20
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `click_pesquisa_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` datetime DEFAULT NULL,
  `user_id_creator` int(11) unsigned DEFAULT NULL COMMENT 'User who created the form',
  `form_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `f` (`form_group_id`),
  KEY `user_id_creator` (`user_id_creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `form`
--

INSERT INTO `form` (`id`, `name`, `created_at`, `last_updated_at`, `user_id_creator`, `form_group_id`) VALUES
(1, 'Intenção de votos', '2016-06-27 22:46:15', '2016-07-03 17:55:00', 8, 1),
(2, 'Form teste', '2016-06-29 10:01:59', '2016-07-03 18:22:00', 1, 1),
(5, 'Form teste sem questão', '2016-06-29 11:03:30', '2016-07-03 00:08:00', 1, 2),
(6, 'Form teste com questão completa ', '2016-07-02 23:23:53', '2016-07-03 13:04:00', 1, 2),
(7, 'Form teste completo 2', '2016-07-02 17:53:36', '2016-07-03 00:08:00', 1, 1),
(8, 'Form teste sem questão 2', '2016-07-02 18:10:08', '2016-07-03 00:08:00', 1, 2),
(9, 'Form sem questão 3', '2016-07-02 18:18:42', '2016-07-03 00:08:00', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `form_group`
--

CREATE TABLE IF NOT EXISTS `form_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(28) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `form_group`
--

INSERT INTO `form_group` (`id`, `name`) VALUES
(1, 'Formulários políticos'),
(2, 'Pesquisas urbanas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lat` varchar(11) DEFAULT NULL,
  `long` varchar(11) DEFAULT NULL,
  `neighborhood` varchar(32) DEFAULT NULL,
  `number` int(5) unsigned DEFAULT NULL,
  `address` varchar(32) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phone`
--

CREATE TABLE IF NOT EXISTS `phone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ddd` varchar(2) NOT NULL,
  `number` varchar(10) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order` int(2) NOT NULL,
  `text` varchar(256) NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `question_type_id` int(11) NOT NULL,
  `num_options` int(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Total number of radio buttons or checkboxes',
  `comment` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `question_type_id` (`question_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `question`
--

INSERT INTO `question` (`id`, `order`, `text`, `form_id`, `question_type_id`, `num_options`, `comment`) VALUES
(7, 1, 'Sexo:', 1, 3, 2, NULL),
(12, 2, 'Faixa etária:', 1, 3, 6, NULL),
(13, 3, 'Grau de escolaridade:', 1, 3, 7, NULL),
(14, 4, 'Qual é a renda mensal da sua família aproximadamente? (Por faixa de salários mínimos) - Tabela vigente: R$ 800,00 - Em salários mínimos', 1, 3, 6, NULL),
(15, 5, 'Você possui religião? Qual sua religião?', 1, 3, 1, NULL),
(16, 6, 'Se as eleições de outubro fossem hoje, em quem você votaria para prefeito(a) de Mangueirinha?', 1, 3, 3, NULL),
(17, 7, 'E se fossem estes os candidatos, em qual deles você votaria para prefeito(a) da sua cidade? -Disco 1-', 1, 3, 6, NULL),
(18, 8, 'E se fossem estes os candidatos, em qual deles você votaria para prefeito(a) da sua cidade? -Disco 2-', 1, 3, 6, NULL),
(19, 9, 'E se fossem estes os candidatos, em qual deles você votaria para prefeito(a) da sua cidade? -Disco 3-', 1, 3, 6, NULL),
(20, 10, 'E sendo estes os candidatos, em qual deles você jamais votaria para prefeito(a) da sua cidade? -Disco 1-', 1, 3, 11, NULL),
(21, 11, 'Se algum candidato(a) tivesse apoio do ex-prefeito Miguel Aguiar, a chance de você votar nele(a):', 1, 3, 4, NULL),
(22, 12, 'Se algum candidato(a) tivesse o apoio do prefeito Guimo, a chance de você votar nele(a):', 1, 3, 4, NULL),
(23, 1, 'Questão de teste', 2, 3, 0, NULL),
(24, 1, 'Questão tipo radio 1', 6, 3, 0, NULL),
(26, 1, 'Questão do formulário de teste completo 1', 7, 2, 0, NULL),
(27, 2, 'Questão não sei o tipo 2', 6, 3, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `question_item`
--

CREATE TABLE IF NOT EXISTS `question_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(128) NOT NULL,
  `question_id` int(11) unsigned NOT NULL,
  `order` int(2) unsigned NOT NULL,
  `child_question_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `child_question_id` (`child_question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

--
-- Extraindo dados da tabela `question_item`
--

INSERT INTO `question_item` (`id`, `text`, `question_id`, `order`, `child_question_id`) VALUES
(1, 'Masculino', 7, 1, NULL),
(2, 'Feminino', 7, 2, NULL),
(32, '16-24 Anos', 12, 1, NULL),
(33, '25-34 Anos', 12, 2, NULL),
(34, '35-44 Anos', 12, 3, NULL),
(35, '45-59 Anos', 12, 4, NULL),
(36, '60 ou +', 12, 5, NULL),
(37, 'Não opinou', 12, 6, NULL),
(38, 'N/C', 13, 1, NULL),
(39, '1ª à 4ª', 13, 2, NULL),
(40, '5ª à 8ª', 13, 3, NULL),
(41, 'Ens. Médio', 13, 4, NULL),
(42, 'Sup. Incompleto', 13, 5, NULL),
(43, 'Sup. ou mais', 13, 6, NULL),
(44, 'Não opinou', 13, 7, NULL),
(45, 'Até 1 salário', 14, 1, NULL),
(46, 'De 1 a 2 salários', 14, 2, NULL),
(47, 'De 2 a 3 salários', 14, 3, NULL),
(48, 'De 3 a 5 salários', 14, 4, NULL),
(49, 'Acima de 5 salários', 14, 5, NULL),
(50, 'Não sabe/ Não opinou', 14, 6, NULL),
(51, 'Não possui religião', 15, 1, NULL),
(52, 'Católico', 15, 2, NULL),
(53, 'Espírita', 15, 3, NULL),
(54, 'Evangélico', 15, 4, NULL),
(55, 'Outros', 15, 5, NULL),
(56, 'Não sabe/Não opinou', 15, 6, NULL),
(57, 'Indeciso', 16, 1, NULL),
(58, 'Nulo/Branco', 16, 2, NULL),
(59, 'Não sabe/Não opinou', 16, 3, NULL),
(150, 'Palauro', 17, 1, NULL),
(151, 'Vilela', 17, 2, NULL),
(152, 'Amós', 17, 3, NULL),
(153, 'Elidio', 17, 4, NULL),
(154, 'Vanderlei Dorini', 17, 5, NULL),
(155, 'Luiz Ikiu', 17, 6, NULL),
(156, 'Ziguer', 17, 7, NULL),
(157, 'Ivete Dagostini', 17, 8, NULL),
(158, 'Pinheiro da Agropecuária Campo Verde', 17, 9, NULL),
(159, 'Indeciso', 17, 10, NULL),
(160, 'Nulo/Branco', 17, 11, NULL),
(161, 'Não sabe/Não opinou', 17, 12, NULL),
(162, 'Palauro', 18, 1, NULL),
(163, 'Vilela', 18, 2, NULL),
(164, 'Elidio', 18, 3, NULL),
(165, 'Indeciso', 18, 4, NULL),
(166, 'Nulo/Branco', 18, 5, NULL),
(167, 'Não sabe/Não opinou', 18, 6, NULL),
(168, 'Palauro', 19, 1, NULL),
(169, 'Vanderlei Dorini', 19, 2, NULL),
(170, 'Elidio', 19, 3, NULL),
(171, 'Indeciso', 19, 4, NULL),
(172, 'Nulo/Branco', 19, 5, NULL),
(173, 'Não sabe/Não opinou', 19, 6, NULL),
(174, 'Palauro', 20, 1, NULL),
(175, 'Vilela', 20, 2, NULL),
(176, 'Amós', 20, 3, NULL),
(177, 'Elidio', 20, 4, NULL),
(178, 'Vanderlei Dorini', 20, 5, NULL),
(179, 'Luiz Ikiu', 20, 6, NULL),
(180, 'Ziger', 20, 7, NULL),
(181, 'Ivete Dagostini', 20, 8, NULL),
(182, 'Pinheiro da Agropecuária Campo Verde', 20, 9, NULL),
(183, 'Sem rejeição', 20, 10, NULL),
(184, 'Não sabe/Não opinou', 20, 11, NULL),
(185, 'Aumentaria', 21, 1, NULL),
(186, 'Não mudaria', 21, 2, NULL),
(187, 'Diminuiria', 21, 3, NULL),
(188, 'Não sabe/Não opinou', 21, 4, NULL),
(189, 'Aumentaria', 22, 1, NULL),
(190, 'Não mudaria', 22, 2, NULL),
(191, 'Diminuiria', 22, 3, NULL),
(192, 'Não sabe/Não opinou', 22, 4, NULL),
(193, 'Item de teste', 23, 1, NULL),
(194, 'item de questão de formulário de teste completo 1', 26, 1, NULL),
(195, 'Item questão 24', 24, 1, NULL),
(196, 'Item não sei o tipo :B', 27, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `question_type`
--

CREATE TABLE IF NOT EXISTS `question_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `question_type`
--

INSERT INTO `question_type` (`id`, `type`) VALUES
(1, 'text'),
(2, 'checkbox'),
(3, 'radio'),
(4, 'checkbox+text'),
(5, 'radio+text');

-- --------------------------------------------------------

--
-- Estrutura da tabela `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`form_id`,`location_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `survey_history`
--

CREATE TABLE IF NOT EXISTS `survey_history` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) unsigned NOT NULL COMMENT 'Survey''s operator',
  `question_id` int(10) unsigned NOT NULL,
  `chosen_item_order` int(11) DEFAULT NULL COMMENT 'Order of the item of ''question_id'' that has been chosen as answer. It''s NULL if question is of TEXT type',
  `chosen_item_text` varchar(128) NOT NULL COMMENT 'Text of the item of ''question_id'' that has been chosen as answer. It''s NULL if question is of TEXT type',
  `response_text` varchar(128) DEFAULT NULL COMMENT 'For TEXT type questions. It''s NULL if the question is not of TEXT type',
  KEY `question_id` (`question_id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `photo_id` int(11) unsigned DEFAULT NULL,
  `role_id` int(11) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `reg_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `photo` (`photo_id`,`role_id`),
  KEY `role` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `cpf`, `username`, `password`, `email`, `photo_id`, `role_id`, `status`, `reg_time`) VALUES
(1, 'Giovanne', 'Almeida Messias', '00000000000', 'giovanne', '1234', 'giovanne.almeida@hotmail.com', NULL, 1, 1, '2016-06-27 18:15:42'),
(8, 'Ronaldo', 'Carvalho', '11111111111', 'ronaldo', '1234', 'ronaldo@gmail.com', NULL, 2, 1, '2016-06-27 19:27:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'operador'),
(2, 'administrator');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `FK_FORM_FORM_GROUP_ID` FOREIGN KEY (`form_group_id`) REFERENCES `form_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_FORM_USER_ID` FOREIGN KEY (`user_id_creator`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `FK_PHONE_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_QUESTION_FORM` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_QUESTION_QUESTION_TYPE_ID` FOREIGN KEY (`question_type_id`) REFERENCES `question_type` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `question_item`
--
ALTER TABLE `question_item`
  ADD CONSTRAINT `FK_CHILD_QUESTION_ID_QUESTION_ID` FOREIGN KEY (`child_question_id`) REFERENCES `question` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_QUESTION_ID_QUESTION_ID` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `FK_SURVEY_LOCATION_ID` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SURVEY_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `survey_history`
--
ALTER TABLE `survey_history`
  ADD CONSTRAINT `FK_SURVEY_HISTORY_QUESTION` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SURVEY_HISTORY_SURVEY` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_USER_PHOTO_ID` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USER_USER_ROLE` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
