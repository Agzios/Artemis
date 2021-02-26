DROP TABLE IF EXISTS `utilisateur`;
DROP TABLE IF EXISTS `post`;
DROP TABLE IF EXISTS `like`;
DROP TABLE IF EXISTS `comm`;

CREATE TABLE `utilisateur` (
	`id_users` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`prenom` varchar(50),
	`nom` varchar(50),
	`pseudo` varchar(50) NOT NULL,
	`email` varchar(100) NOT NULL,
    `mdp` varchar(200) NOT NULL,
	`date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`url_avatar` varchar(255),
	PRIMARY KEY (`id_users`),
    UNIQUE KEY `pseudo` (`pseudo`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `post` (
	`id_post` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_users` INT UNSIGNED NOT NULL,
	`url_post` varchar(255) NOT NULL,
	`title` varchar(100) NOT NULL,
	`type_post` varchar(255) NOT NULL,
	`date_post` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`description` varchar(255),
	`view_post` INT UNSIGNED NOT NULL,
	`status_post` varchar(255) NOT NULL DEFAULT 'private',
	PRIMARY KEY (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `like` (
	`id_post` INT UNSIGNED NOT NULL,
	`id_users_creator` INT UNSIGNED NOT NULL,
	`id_users` INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `comm` (
	`id_comm` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_users_creator` INT UNSIGNED NOT NULL,
	`id_users` INT UNSIGNED NOT NULL,
	`comm` varchar(255) NOT NULL,
	`date_comm` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id_comm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `post` ADD CONSTRAINT `Post_fk0` FOREIGN KEY (`id_users`) REFERENCES `utilisateur`(`id_users`);

ALTER TABLE `like` ADD CONSTRAINT `Like_fk0` FOREIGN KEY (`id_post`) REFERENCES `post`(`id_post`);

ALTER TABLE `like` ADD CONSTRAINT `Like_fk1` FOREIGN KEY (`id_users_creator`) REFERENCES `post`(`id_users`);

ALTER TABLE `like` ADD CONSTRAINT `Like_fk2` FOREIGN KEY (`id_users`) REFERENCES `utilisateur`(`id_users`);

ALTER TABLE `comm` ADD CONSTRAINT `Comm_fk0` FOREIGN KEY (`id_users_creator`) REFERENCES `post`(`id_users`);

ALTER TABLE `comm` ADD CONSTRAINT `Comm_fk1` FOREIGN KEY (`id_users`) REFERENCES `utilisateur`(`id_users`);