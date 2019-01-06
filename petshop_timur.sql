-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `petshop_timur`;

DROP TABLE IF EXISTS `card_crd`;
CREATE TABLE `card_crd` (
  `id_crd` int(11) NOT NULL AUTO_INCREMENT,
  `idusr_crd` int(11) NOT NULL,
  `serial_crd` varchar(60) NOT NULL DEFAULT '',
  `cardholder_crd` varchar(60) NOT NULL DEFAULT '',
  `expiredate_crd` varchar(60) NOT NULL DEFAULT '',
  `secretcode_crd` varchar(60) NOT NULL DEFAULT '',
  `type_crd` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_crd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `card_crd`;

DROP TABLE IF EXISTS `comanda_cmd`;
CREATE TABLE `comanda_cmd` (
  `id_cmd` int(11) NOT NULL AUTO_INCREMENT,
  `idusr_cmd` int(11) NOT NULL,
  `idcrd_cmd` int(11) NOT NULL,
  `date_cmd` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_cmd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `comanda_cmd`;

DROP TABLE IF EXISTS `produs_cmd`;
CREATE TABLE `produs_cmd` (
  `id_prdcmd` int(11) NOT NULL AUTO_INCREMENT,
  `id_prd` int(11) NOT NULL,
  `id_cmd` int(11) NOT NULL,
  `price_prdcom` decimal(13,4) NOT NULL,
  `cantitate_prdcom` int(11) NOT NULL,
  PRIMARY KEY (`id_prdcmd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `produs_cmd`;

DROP TABLE IF EXISTS `produs_prd`;
CREATE TABLE `produs_prd` (
  `id_prd` int(11) NOT NULL AUTO_INCREMENT,
  `name_prd` varchar(50) NOT NULL DEFAULT '',
  `description_prd` varchar(255) NOT NULL DEFAULT '',
  `type_prd` int(11) NOT NULL,
  `price_prod` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `stoc_prod` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_prd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `produs_prd`;

DROP TABLE IF EXISTS `produs_rcmd`;
CREATE TABLE `produs_rcmd` (
  `id_prdrcmd` int(11) NOT NULL AUTO_INCREMENT,
  `id_prd` int(11) NOT NULL,
  `id_rcmd` int(11) NOT NULL,
  PRIMARY KEY (`id_prdrcmd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `produs_rcmd`;

DROP TABLE IF EXISTS `recomand_rcmd`;
CREATE TABLE `recomand_rcmd` (
  `id_rcmd` int(11) NOT NULL AUTO_INCREMENT,
  `name_rcmd` varchar(50) NOT NULL DEFAULT '',
  `description_rcmd` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_rcmd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `recomand_rcmd`;

DROP TABLE IF EXISTS `type_card`;
CREATE TABLE `type_card` (
  `id_tcrd` tinyint(1) NOT NULL AUTO_INCREMENT,
  `name_tcrd` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tcrd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `type_card`;

DROP TABLE IF EXISTS `type_prd`;
CREATE TABLE `type_prd` (
  `id_tprd` int(11) NOT NULL AUTO_INCREMENT,
  `name_tprd` varchar(50) NOT NULL DEFAULT '',
  `isbio_tprd` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tprd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `type_prd`;

DROP TABLE IF EXISTS `type_usr`;
CREATE TABLE `type_usr` (
  `id_tusr` tinyint(1) NOT NULL AUTO_INCREMENT,
  `name_tusr` varchar(15) NOT NULL DEFAULT '',
  `descripition_tusr` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tusr`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

TRUNCATE `type_usr`;
INSERT INTO `type_usr` (`id_tusr`, `name_tusr`, `descripition_tusr`) VALUES
(1,	'ADMIN',	'Gradul de administrator permite operatiuni de tip '),
(2,	'USER',	'Gradul normal de ultizator.');

DROP TABLE IF EXISTS `users_usr`;
CREATE TABLE `users_usr` (
  `id_usr` int(11) NOT NULL AUTO_INCREMENT,
  `email_usr` varchar(50) NOT NULL DEFAULT '',
  `password_usr` varchar(60) NOT NULL DEFAULT '',
  `createdate_usr` varchar(20) NOT NULL DEFAULT '',
  `idtype_usr` tinyint(1) NOT NULL DEFAULT '0',
  `nume_usr` varchar(30) NOT NULL DEFAULT '',
  `prenume_usr` varchar(50) NOT NULL DEFAULT '',
  `birthday_usr` varchar(20) NOT NULL DEFAULT '',
  `sex_usr` varchar(12) NOT NULL DEFAULT 'Nespecificat',
  `token_usr` varchar(32) NOT NULL DEFAULT '',
  `enabled_usr` tinyint(1) NOT NULL DEFAULT '0',
  `lastlogin_usr` varchar(20) NOT NULL DEFAULT '',
  `authkey_usr` varchar(32) NOT NULL,
  PRIMARY KEY (`id_usr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `users_usr`;

-- 2018-11-06 13:15:49
