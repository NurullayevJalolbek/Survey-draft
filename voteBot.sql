CREATE TABLE IF NOT EXISTS `users` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_id` int NOT NULL,
	`name` varchar(255) NOT NULL,
	`phone_number` int NOT NULL UNIQUE,
	`captcha_code` int,
	`data` varchar(255),
	`created_at` date NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `surveys` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` varchar(255) NOT NULL,
	`desc` text,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `survey_variants` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`survey_id` int NOT NULL,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `votes` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`user_id` int NOT NULL,
	`survey_id` int NOT NULL,
	`survey_variant_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `channels` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`channel_id` int NOT NULL,
	PRIMARY KEY (`id`)
);



ALTER TABLE `survey_variants` ADD CONSTRAINT `survey_variants_fk1` FOREIGN KEY (`survey_id`) REFERENCES `surveys`(`id`);
ALTER TABLE `votes` ADD CONSTRAINT `votes_fk1` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `votes` ADD CONSTRAINT `votes_fk2` FOREIGN KEY (`survey_id`) REFERENCES `surveys`(`id`);

ALTER TABLE `votes` ADD CONSTRAINT `votes_fk3` FOREIGN KEY (`survey_variant_id`) REFERENCES `survey_variants`(`id`);
