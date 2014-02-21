SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_bin NOT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` int(11) NOT NULL DEFAULT '0',
  `author` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `status` enum('pending','queued','published') COLLATE utf8_bin NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `entry_vote` (
  `entry_id` int(11) NOT NULL,
  `ip` varchar(48) COLLATE utf8_bin NOT NULL,
  `positive` tinyint(1) NOT NULL,
  KEY `id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


ALTER TABLE `entry_vote`
ADD CONSTRAINT `entry_vote_ibfk_1` FOREIGN KEY (`entry_id`) REFERENCES `entry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
