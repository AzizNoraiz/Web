-- Adminer 5.4.1 MySQL 8.0.44 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `casino` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `casino`;

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260311134540',	'2026-03-11 14:45:46',	42),
('DoctrineMigrations\\Version20260311134631',	'2026-03-11 14:46:39',	55),
('DoctrineMigrations\\Version20260312063631',	'2026-03-12 07:36:40',	82),
('DoctrineMigrations\\Version20260331093125',	'2026-03-31 11:31:36',	60);

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `personne`;
CREATE TABLE `personne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `jetons` int NOT NULL DEFAULT '5000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `personne` (`id`, `email`, `roles`, `password`, `pseudo`, `nom`, `prenom`, `telephone`, `jetons`) VALUES
(1,	'noraizaziz72@gmail.com',	'[]',	'$2y$13$KLh18YVteTfaCf2vG2Eb8.W7i6qvrRyS4Figb7qdVNZFKe5a6nKta',	'NAZIZ',	'Aziz',	'Noraiz',	'0766452131',	5000),
(2,	'noraizaziz72@yahoo.com',	'[]',	'$2y$13$Jg0JxDXH3ih6kbpgP1sSB.51aCr3ShjU1w00ZN26aqh9dQRO.Ivg.',	'naziz',	'Aziz',	'Noraiz',	'0766452131',	0),
(3,	'rohroh@gmail.com',	'[]',	'$2y$13$NK2AR2/G0O6sA..NYmsJY.kEaluQN.iguZn78OQZihkn6UroCEyG2',	'roh',	'roh',	'rohroh',	'0766452141',	5000),
(4,	'test@gmail.com',	'[]',	'$2y$13$DauW/GzFdQvgFK8VMIFJK.48Xp4ep20Z5I7JwhdQwiFSm7RQ2Sl2e',	'test@',	'test',	'testTest',	'0606060606',	5000),
(5,	'nano@gmail.com',	'[]',	'$2y$13$4JO4hwgaR.dSS/L6s.1Hz.rKLbUd77F6ItYICQhDOaTZTTTJjl8tq',	'nazzouz',	'znhhh',	'zzz',	'0876453215',	13257),
(6,	'dd@gmail.com',	'[]',	'$2y$13$Ipdh0sjBrb.ABp3oPCcCkOn/d7wfioczCds0ywZf98roQlo4XOgCS',	'dd',	'dsd',	'dd',	'0667677666',	5000),
(7,	'tariq@gmail.com',	'[]',	'$2y$13$XnxUKe3XPdNvFl40MKGv9uMHFiSL0AiqsJn6xoitG9tOlV0ZqKnei',	'TariqA',	'Aziz',	'Tariq',	'0663936477',	5000),
(8,	'test4@gmail.com',	'[]',	'$2y$13$aW15g41N2ZaeqU1d2ss1Qex1ARsb9d/ol.SmjI7YRMLtwcIxlAJC2',	'test4',	'test',	'noraiz',	'0777777778',	5000),
(9,	'noraizaziz94@gmail.com',	'[]',	'$2y$13$j2WnD6JHAK50P.skqg3Zeek.U2l2.sD2wakqFJLvzRGKUNXcKwruq',	'NoraizTest',	'Aziz',	'Noraiz',	'0808080808',	5000);

-- 2026-05-10 14:08:03 UTC
