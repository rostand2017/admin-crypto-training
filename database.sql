-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.7.24 - MySQL Community Server (GPL)
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             9.5.0.5332
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportiere Datenbank Struktur für mycourses
CREATE DATABASE IF NOT EXISTS `mycourses` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mycourses`;

-- Exportiere Struktur von Tabelle mycourses.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.admin: ~4 rows (ungefähr)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `email`, `password`, `createdAt`, `roles`) VALUES
	(1, 'admin@admin.com', '$argon2i$v=19$m=65536,t=4,p=1$a0ZpTVZnLlVIWGRXM1Njcg$ijvObAavQ7sOMOjq1ps/AX2OXyjCtsTaGJGs8ySleIA', '2020-10-06 10:54:09', '["ROLE_ADMIN"]'),
	(3, 'rob@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZnF2M0dGRVEwQnZlYThLRQ$nhylyHKI3vp5U5quAI4BIGEFVT9BPQndqqNmgdJ8sBo', '2020-10-13 09:34:29', '["ROLE_ADMIN"]'),
	(5, 'slz@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$a0syTkZmQ01xUUU0Y0lqMQ$KqjgU38GcGcRgRk9HPgNf0iF3kv9KUc+JuUp9MOx/go', '2020-10-14 05:09:37', '["ROLE_ADMIN"]'),
	(6, 'adm@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZXRySUpLYlNXLlBlRE9SQw$JFjM/xNM4s01VrFZY98CLYsYF11BRGW24DDORiYVky0', '2021-01-05 14:54:56', '["ROLE_ADMIN"]');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `category` varchar(254) NOT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.category: ~4 rows (ungefähr)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `category`, `createdAt`) VALUES
	(2, 'Programmation web', NULL),
	(4, 'Designs', '2020-10-14 10:41:45'),
	(5, 'Entreprenariat - Business', '2021-01-05 14:56:31'),
	(6, 'Cryptomonaie', '2021-01-05 15:01:09');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `Admin` int(11) DEFAULT NULL,
  `Category` int(11) DEFAULT NULL,
  `title` varchar(254) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `photo` varchar(254) NOT NULL,
  `video` varchar(254) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_Association_1` (`Category`),
  KEY `FK_Association_6` (`Admin`),
  CONSTRAINT `FK_Association_1` FOREIGN KEY (`Category`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_Association_6` FOREIGN KEY (`Admin`) REFERENCES `admin` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.course: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`id`, `Admin`, `Category`, `title`, `description`, `price`, `photo`, `video`, `createdAt`) VALUES
	(2, NULL, 2, 'Symfony 5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda cumque dolorem placeat sint sit. Asperiores, beatae consequuntur corporis delectus dolorem doloribus laudantium modi quod quos sunt. Ab deserunt ipsam tempora.', 200, 'd4b408382a9450d2ec18be5521278fa5.png', '1ee43ef56ef6a9221a90abc06708ee92.mp4', '2020-10-14 07:32:12'),
	(3, NULL, 2, 'Symfony 5.2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium architecto asperiores at aut consectetur, dolorem doloremque dolores enim fugiat inventore itaque laudantium maiores nostrum quia quidem repellat reprehenderit repudiandae saepe?', 200, 'cb84bc44536208c3487056740ee1dc4e.png', 'f9826a9e4917c4978b1c2830eb205cd3.mp4', '2021-01-05 15:01:45');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Exportiere Daten aus Tabelle mycourses.doctrine_migration_versions: ~6 rows (ungefähr)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20201006072547', '2020-10-06 08:27:53', 9278),
	('DoctrineMigrations\\Version20201015090727', '2020-10-15 10:08:28', 2682),
	('DoctrineMigrations\\Version20201017052923', '2020-10-17 06:30:47', 2080),
	('DoctrineMigrations\\Version20201017053028', '2020-10-17 06:30:49', 1336),
	('DoctrineMigrations\\Version20201108051450', '2020-11-08 06:20:42', 3466),
	('DoctrineMigrations\\Version20201108052212', '2020-11-08 06:23:03', 1171),
	('DoctrineMigrations\\Version20201108070519', '2020-11-08 08:06:05', 1523);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.lesson
CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `Module` int(11) DEFAULT NULL,
  `title` varchar(254) NOT NULL,
  `video` varchar(254) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_Association_3` (`Module`),
  CONSTRAINT `FK_Association_3` FOREIGN KEY (`Module`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.lesson: ~6 rows (ungefähr)
/*!40000 ALTER TABLE `lesson` DISABLE KEYS */;
INSERT INTO `lesson` (`id`, `Module`, `title`, `video`, `createdAt`) VALUES
	(1, 1, 'Creation de symfony 5', '085140e9c73fe515c8c140c326076314.mp4', '2020-10-15 09:40:34'),
	(2, 1, 'Généralités', '858462883bf6487f025c1630ef45977f.mp4', '2020-10-15 09:51:41'),
	(7, 1, 'Bonus', '67e52ab058ed671721adc026d2be0d07.mp4', '2020-10-15 10:08:41'),
	(8, 2, 'TURIO', 'db7a5a180f233e064bce9cd23f74a1c6.mp4', '2020-11-03 09:38:12'),
	(9, 5, 'Historique', NULL, '2021-01-05 15:02:45'),
	(10, 5, 'Généralité', NULL, '2021-01-05 15:08:05'),
	(11, 5, 'Ainsi de suite', NULL, '2021-01-05 15:08:26');
/*!40000 ALTER TABLE `lesson` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `Course` int(11) DEFAULT NULL,
  `title` varchar(254) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_Association_2` (`Course`),
  CONSTRAINT `FK_Association_2` FOREIGN KEY (`Course`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.module: ~3 rows (ungefähr)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `Course`, `title`, `duration`, `createdAt`) VALUES
	(1, 2, 'Historiques && Generalités', 100, '2020-10-15 07:51:20'),
	(2, 2, 'Installation et configuration', 30, '2020-10-15 08:09:29'),
	(4, 2, 'Routes et Controller', 70, '2020-10-15 09:01:19'),
	(5, 3, 'Historiques && Generalités', 30, '2021-01-05 15:02:15');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.section
CREATE TABLE IF NOT EXISTS `section` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `Lesson` int(11) DEFAULT NULL,
  `paragraph` longtext NOT NULL,
  `image` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_4` (`Lesson`),
  CONSTRAINT `FK_Association_4` FOREIGN KEY (`Lesson`) REFERENCES `lesson` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.section: ~6 rows (ungefähr)
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` (`id`, `Lesson`, `paragraph`, `image`) VALUES
	(2, 1, '<h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit.&nbsp;</h4><p>&nbsp;sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. <strong>Accusantium</strong> animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas!</p><ol><li>Bonjour</li><li>Salut</li><li>Aurevoir</li></ol><p>www.google.com</p><p>&nbsp;</p><figure class="table"><table><tbody><tr><td>Nourriture</td><td>Poids</td><td>Pirx</td></tr><tr><td>Porc braisé</td><td>1500 Gramm</td><td>2000 Fcfa</td></tr></tbody></table></figure><p>&nbsp;</p><p>&nbsp;</p>', NULL),
	(3, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium animi deleniti doloribus, esse iste officia placeat quisquam sed! Aut delectus et in laudantium perferendis rem reprehenderit repudiandae, sed ullam voluptas\r\n\r\n', 'b122738121c4f1ee4d1e8cfde3581c73.png'),
	(4, 1, '<p><strong>Abobination</strong></p><h2>La f*ck de ça per</h2><p>Dibaya dibaya</p>', NULL),
	(5, 1, '<h2><span style="color:hsl(0, 75%, 60%);"><u>Story Title</u></span></h2><p>Story Subtitle or summary</p><p>Most controls offer a <span style="color:hsl(0, 75%, 60%);"><i><strong>choice </strong></i></span>of using the look from the current theme or using a format that you specify directly.&nbsp;</p><p>On the Insert tab, the galleries include items that are designed to coordinate with the overall look of your document. You can use these galleries to insert tables, headers, footers, lists, cover pages, and other document building blocks. When you create pictures, charts, or diagrams, they also coordinate with your current document look.</p><p>You can easily change the formatting of selected text in the document text by choosing a look for the selected text from the Quick Styles gallery on the Home tab. You can also format text directly by using the other controls on the Home tab. Most controls offer a choice of using the look from the current theme or using a format that you specify directly.</p><p>To change the overall look of your document, choose new Theme elements on the Page Layout tab. To change the looks available in the Quick Style gallery, use the Change Current Quick Style Set command. Both the Themes gallery and the Quick Styles gallery provide reset commands so that you can always restore the look of your document to the original contained in your current template.</p><p>On the Insert tab, the galleries include items that are designed to coordinate with the overall look of your document. You can use these galleries to insert tables, headers, footers, lists, cover pages, and other document building blocks. When you create pictures, charts, or diagrams, they also coordinate with your current document look.</p><p>&nbsp;</p><h2><span style="color:hsl(0, 75%, 60%);"><u>Story Title</u></span></h2><p>Story Subtitle or summary&nbsp; &nbsp;</p><p>On the Insert tab, the galleries include items that are designed to coordinate with the overall look of your document. You can use these galleries to insert tables, headers, footers, lists, cover pages, and other document building blocks.</p><p>You can easily change the formatting of selected text in the document text by choosing a look for the selected text from the Quick Styles gallery on the Home tab. You can also format text directly by using the other controls on the Home tab. Most controls offer a choice of using the look from the current theme or using a format that you specify directly.</p><p>To change the overall look of your document, choose new Theme elements on the Page Layout tab. To change the looks available in the Quick Style gallery, use the Change Current Quick Style Set command. Both the Themes gallery and the Quick Styles gallery provide reset commands so that you can always restore the look of your document to the original contained in your current template.</p>', 'eda1995131b466594ce8a501a708de14.png'),
	(6, 9, '<p><span class="text-big" style="background-color:hsl(30, 75%, 60%);"><strong>Titre de ma section</strong></span></p><p>Une leçon est un ensemble de section, une section peut comprendre du texte et une images. Donc pour chaque section, une image.</p><p>&nbsp;</p><p>les liste:&nbsp;</p><ul><li>Liste 1</li><li>Liste 2</li><li>Liste 3</li></ul>', NULL);
/*!40000 ALTER TABLE `section` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.subcription
CREATE TABLE IF NOT EXISTS `subcription` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `Course` int(11) DEFAULT NULL,
  `User` int(11) DEFAULT NULL,
  `lesson` int(11) DEFAULT NULL,
  `nbLesson` int(11) DEFAULT NULL,
  `linkCurrentLesson` varchar(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_Association_7` (`User`),
  KEY `FK_Association_8` (`Course`),
  CONSTRAINT `FK_Association_7` FOREIGN KEY (`User`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_Association_8` FOREIGN KEY (`Course`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.subcription: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `subcription` DISABLE KEYS */;
INSERT INTO `subcription` (`id`, `Course`, `User`, `lesson`, `nbLesson`, `linkCurrentLesson`, `createdAt`) VALUES
	(1, 2, 5, 2, 4, '/courses/2/lessons/1', '2020-11-08 20:31:59');
/*!40000 ALTER TABLE `subcription` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.supportfiles
CREATE TABLE IF NOT EXISTS `supportfiles` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `Lesson` int(11) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Association_5` (`Lesson`),
  CONSTRAINT `FK_Association_5` FOREIGN KEY (`Lesson`) REFERENCES `lesson` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.supportfiles: ~5 rows (ungefähr)
/*!40000 ALTER TABLE `supportfiles` DISABLE KEYS */;
INSERT INTO `supportfiles` (`id`, `Lesson`, `path`) VALUES
	(5, 1, 'ea2a1afed42efa1496f202659790ad70.txt'),
	(6, 1, '7e67bcbc63682f85cb0d60088c2eb2cc.png'),
	(7, 1, 'ae71497d743611016eb27b3a80b0b903.png'),
	(8, 8, '060e3ddd030c2180b9896caf89f317aa.mkv'),
	(9, 8, 'c141b26e5e670b871af9a2d3952c97c9.mkv');
/*!40000 ALTER TABLE `supportfiles` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle mycourses.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` json NOT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle mycourses.user: ~1 rows (ungefähr)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `email`, `password`, `roles`, `createdAt`) VALUES
	(3, 'Fotso Rostand', 'ross@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$YzIzMDJIbTVoaGJpYVRWSA$2s8eRZlUHdgA5rCQh2qNJk183jpkINs3ZICdPPilgSI', '[]', '2020-11-08 08:06:17'),
	(5, 'Fotso Rostand', 'admin@admin.com', '$argon2i$v=19$m=65536,t=4,p=1$czV4T1NUbVBTbEVva0pybg$BF2dRCi1DF8XZtFAFuvawMbXZWhEQRk8uGnbXze64Z4', '[]', '2020-11-08 08:19:35');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
