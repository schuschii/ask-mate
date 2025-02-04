/*
 * AskMate, again
 *
 * Database schema
 * Version: 10.4.13-MariaDB
 */

CREATE DATABASE IF NOT EXISTS `ask_mate_again` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ask_mate_again`;

SET FOREIGN_KEY_CHECKS = FALSE;

DROP TABLE IF EXISTS `registered_user`;
CREATE TABLE `registered_user`
(
    `id`                INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `email`             TEXT NOT NULL,
    `password_hash`     TEXT NOT NULL,
    `registration_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image`
(
    `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `directory`   TEXT NOT NULL,
    `file_name`   TEXT NOT NULL,
    `upload_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question`
(
    `id`                 INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_image`           INT(11) UNSIGNED NULL,
    `id_registered_user` INT(11) UNSIGNED NOT NULL,
    `title`              VARCHAR(255) NOT NULL,
    `message`            TEXT NOT NULL,
    `vote_number`        INT(11) NOT NULL,
    `submission_time`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_image_on_question` FOREIGN KEY (`id_image`) REFERENCES `image`(`id`),
    CONSTRAINT `fk_registered_user_on_question` FOREIGN KEY (`id_registered_user`) REFERENCES `registered_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer`
(
    `id`                 INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_question`        INT(11) UNSIGNED NOT NULL,
    `id_registered_user` INT(11) UNSIGNED NOT NULL,
    `message`            TEXT NOT NULL,
    `vote_number`        INT(11) NOT NULL,
    `submission_time`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_question_on_answer` FOREIGN KEY (`id_question`) REFERENCES `question`(`id`),
    CONSTRAINT `fk_registered_user_on_answer` FOREIGN KEY (`id_registered_user`) REFERENCES `registered_user`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag`
(
    `id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `rel_question_tag`;
CREATE TABLE `rel_question_tag`
(
    `id_question` INT(11) UNSIGNED NOT NULL,
    `id_tag`      INT(11) UNSIGNED NOT NULL,
    CONSTRAINT `fk_question_on_rel_question_tag` FOREIGN KEY (`id_question`) REFERENCES `question`(`id`),
    CONSTRAINT `fk_tag_on_rel_question_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

SET FOREIGN_KEY_CHECKS = TRUE;
-- Insert dummy users
INSERT INTO `registered_user` (`email`, `password_hash`, `registration_time`) VALUES
                                                                                  ('user1@example.com', 'hashedpassword1', NOW()),
                                                                                  ('user2@example.com', 'hashedpassword2', NOW()),
                                                                                  ('user3@example.com', 'hashedpassword3', NOW());

-- Insert dummy images
INSERT INTO `image` (`directory`, `file_name`, `upload_time`) VALUES
                                                                  ('/uploads/', 'image1.png', NOW()),
                                                                  ('/uploads/', 'image2.jpg', NOW());

-- Insert dummy questions
INSERT INTO `question` (`id_image`, `id_registered_user`, `title`, `message`, `vote_number`, `submission_time`) VALUES
                                                                                                                    (1, 1, 'How to install MySQL?', 'I am having trouble installing MySQL. Can anyone help?', 5, NOW()),
                                                                                                                    (2, 2, 'Best programming languages in 2024?', 'What are the top programming languages to learn in 2024?', 3, NOW());

-- Insert dummy answers
INSERT INTO `answer` (`id_question`, `id_registered_user`, `message`, `vote_number`, `submission_time`) VALUES
                                                                                                            (1, 2, 'Try using XAMPP for an easy MySQL setup!', 2, NOW()),
                                                                                                            (2, 3, 'Python and JavaScript are great choices!', 4, NOW());

-- Insert dummy tags
INSERT INTO `tag` (`name`) VALUES
                               ('MySQL'),
                               ('Python'),
                               ('JavaScript'),
                               ('Web Development');

-- Insert dummy question-tag relationships
INSERT INTO `rel_question_tag` (`id_question`, `id_tag`) VALUES
                                                             (1, 1),  -- Link "How to install MySQL?" with "MySQL" tag
                                                             (2, 2),  -- Link "Best programming languages in 2024?" with "Python"
                                                             (2, 3);  -- Link "Best programming languages in 2024?" with "JavaScript"