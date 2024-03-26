SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `issue`;
CREATE TABLE `issue`
(
    `id`       int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title`    tinytext DEFAULT NULL,
    `content`  text     DEFAULT NULL,
    `done`     tinyint(1) NOT NULL DEFAULT 0,
    `inserted` datetime DEFAULT NULL,
    `updated`  datetime DEFAULT NULL,
    `deleted`  datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag`
(
    `id`       int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`     tinytext DEFAULT NULL,
    `inserted` datetime DEFAULT NULL,
    `updated`  datetime DEFAULT NULL,
    `deleted`  datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `issue_tag`;
CREATE TABLE `issue_tag`
(
    `issue_id` int(10) unsigned NOT NULL,
    `tag_id`   int(10) unsigned NOT NULL,
    PRIMARY KEY (`issue_id`, `tag_id`),
    KEY        `tag_id` (`tag_id`),
    CONSTRAINT `issue_tag_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE,
    CONSTRAINT `issue_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
