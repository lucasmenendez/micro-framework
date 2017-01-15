SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
ALTER TABLE `users` ADD PRIMARY KEY (`id`);
