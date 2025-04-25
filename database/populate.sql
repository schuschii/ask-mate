/*
 * AskMate, again
 *
 * Database schema with dummy data for all tables.
 * Version: 10.4.13-MariaDB
 */

CREATE DATABASE IF NOT EXISTS `ask_mate_again` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ask_mate_again`;

SET FOREIGN_KEY_CHECKS = FALSE;

-- Clear data if tables have existing rows
TRUNCATE TABLE `rel_question_tag`;
TRUNCATE TABLE `answer`;
TRUNCATE TABLE `question`;
TRUNCATE TABLE `image`;
TRUNCATE TABLE `registered_user`;
TRUNCATE TABLE `tag`;

SET FOREIGN_KEY_CHECKS = TRUE;

-- Insert dummy data
-- Users
INSERT INTO `registered_user` (`email`, `password_hash`, `registration_time`) VALUES
    ('user1@example.com', '$2y$10$DR700JiJNsMRD9/ST9MkSuhAQSE3fJL5abKO3wi0PgNjuFCuoKHJmz', NOW()),
    ('user2@example.com', '$2y$10$/45kIMUmRmKoUjDjcleYOejHREJnX.XZBfDP14NBfno9J2pxjLoci', NOW()),
    ('user3@example.com', '$2y$10$uupesEaxDPAS8j1z81lJauN9ZXfWsEKr9FV2Aen5k8KgWoaU9OQpW', NOW());

-- Images
INSERT INTO `image` (`directory`, `file_name`, `upload_time`) VALUES
    ('/uploads/', 'image1.png', NOW()),
    ('/uploads/', 'image2.jpg', NOW());

-- Questions
INSERT INTO `question` (`id_image`, `id_registered_user`, `title`, `message`, `vote_number`, `submission_time`) VALUES
    (1, 1, 'Who is the creator of PHP?', 'Can someone tell me who created PHP?', 4, NOW()),
    (2, 2, 'What is new in the latest version of PHP?', 'What features were added in the latest PHP update?', 2, NOW()),
    (NULL, 1, 'What are PSRs? Choose 1 and briefly describe it.', 'Can someone explain PSR-4 in PHP?', 3, NOW()),
    (NULL, 2, 'What is "dollar-dollar"? Write some examples for how to use it.', 'How do you use the dollar-dollar ($$) operator in PHP?', 1, NOW()),
    (NULL, 3, 'What are the different types of arrays you can use in PHP?', 'What types of arrays are supported in PHP?', 2, NOW()),
    (NULL, 1, 'What is a Trait?', 'Can someone explain what traits are in PHP?', 3, NOW()),
    (NULL, 2, 'What\'s the difference between include() and require()? Tell 1-1 examples for both.', 'What are the key differences between include() and require()?', 4, NOW()),
    (NULL, 3, 'What is the difference between new self and new static?', 'Can you explain the difference between new self and new static in PHP?', 2, NOW()),
    (NULL, 1, 'Explain what superglobals are. Name at least 3 of them.', 'What are superglobals in PHP? Give examples.', 3, NOW()),
    (NULL, 2, 'What are magic methods?', 'What are magic methods in PHP and how do they work?', 2, NOW()),
    (NULL, 3, 'What are generator functions?', 'Can someone explain generator functions in PHP?', 1, NOW()),
    (NULL, 1, 'How do you pass an argument to a function by reference?', 'What is the syntax to pass arguments by reference in PHP?', 2, NOW()),
    (NULL, 2, 'What are the key differences between Errors and Exceptions?', 'Explain the difference between errors and exceptions in PHP.', 3, NOW()),
    (NULL, 3, 'What is the difference between .php and .phar files?', 'How do .php and .phar files differ in PHP?', 1, NOW()),
    (NULL, 1, 'What is the use of session_start() and session_destroy() functions?', 'When and how do you use session_start() and session_destroy() in PHP?', 3, NOW()),
    (NULL, 2, 'How to terminate the execution of a script in PHP?', 'What are the ways to terminate a script in PHP?', 4, NOW()),
    (NULL, 3, 'What is Composer used for? What should you do to make it work? Write some real-life examples.', 'Why is Composer important in PHP projects?', 2, NOW()),
    (NULL, 1, 'What does a composer.json file contain?', 'What are the typical contents of a composer.json file?', 3, NOW()),
    (NULL, 2, 'What is .htaccess?', 'How is .htaccess used in PHP applications?', 2, NOW()),
    (NULL, 1, 'What is Laravel? What are its main advantages?', 'Can you describe Laravel and its benefits?', 3, NOW()),
    (NULL, 2, 'What is Artisan?', 'What is the purpose of Artisan in Laravel?', 2, NOW()),
    (NULL, 3, 'How to put Laravel applications in maintenance mode?', 'How do you enable maintenance mode in Laravel?', 2, NOW()),
    (NULL, 1, 'What is the purpose of Middlewares in Laravel?', 'Why are middlewares used in Laravel?', 3, NOW()),
    (NULL, 2, 'What are service providers in Laravel?', 'What role do service providers play in Laravel?', 2, NOW()),
    (NULL, 3, 'What are factories in Laravel?', 'What is the purpose of factories in Laravel?', 1, NOW()),
    (NULL, 1, 'What are facades?', 'What are Laravel facades, and how do they work?', 2, NOW()),
    (NULL, 2, 'What is an ORM? What are the benefits, when to use?', 'Explain what an ORM is and its advantages.', 3, NOW()),
    (NULL, 3, 'What is Eloquent? What are the advantages, limitations?', 'Describe Eloquent and its pros and cons.', 2, NOW()),
    (NULL, 1, 'What is the difference between PDO and Eloquent? Which are the advantages and disadvantages of each?', 'How does PDO differ from Eloquent in Laravel?', 4, NOW()),
    (NULL, 2, 'What are migrations? Why are they important?', 'Why do we use migrations in Laravel?', 3, NOW()),
    (NULL, 3, 'What are seeders?', 'What are seeders used for in Laravel?', 2, NOW()),
    (NULL, 1, 'Name 3 aggregate methods provided by the query builder in Laravel. What can they do for you?', 'What are some aggregate methods in Laravel query builder?', 3, NOW()),
    (NULL, 2, 'What is a Model Observer?', 'What is the role of a Model Observer in Laravel?', 2, NOW()),
    (NULL, 3, 'How would you define Eloquent Collections?', 'What are Eloquent Collections in Laravel?', 3, NOW()),
    (NULL, 1, 'What are Polymorphic Relationships?', 'How do Polymorphic Relationships work in Laravel?', 2, NOW());

-- Questions with multiple answers
-- Answers
INSERT INTO `answer` (`id_question`, `id_registered_user`, `message`, `vote_number`, `submission_time`) VALUES
    (1, 2, 'PHP was created by Rasmus Lerdorf in 1994.', 5, NOW()),
    (1, 3, 'Rasmus Lerdorf is credited with creating PHP, initially for tracking his personal website.', 3, NOW()),
    (1, 1, 'PHP stands for "PHP: Hypertext Preprocessor" and was developed by Rasmus Lerdorf.', 2, NOW()),

    (2, 3, 'The latest PHP version introduced JIT (Just-In-Time) compilation.', 4, NOW()),
    (2, 1, 'Improvements in performance and stricter type declarations were added.', 2, NOW()),
    (2, 2, 'New attributes for metadata and improved error handling were introduced.', 3, NOW()),

    (3, 1, 'PSR-4 defines a standard for autoloading classes in PHP.', 3, NOW()),
    (3, 2, 'It helps organize project files based on namespaces.', 2, NOW()),
    (3, 3, 'PSR-4 is widely adopted in Composer-based projects for efficient class loading.', 4, NOW()),

    (4, 3, 'The dollar-dollar ($$) operator allows you to reference variable variables.', 5, NOW()),
    (4, 1, 'It dynamically assigns variable names.', 2, NOW()),
    (4, 2, 'Example: `$name = "variable"; $$name = "value"; echo $variable;` outputs "value".', 4, NOW()),

    (5, 1, 'PHP supports indexed, associative, and multidimensional arrays.', 3, NOW()),
    (5, 2, 'Indexed arrays use numeric keys.', 2, NOW()),
    (5, 3, 'Associative arrays use string keys.', 4, NOW()),

    (6, 2, 'Traits allow you to reuse methods across multiple classes.', 5, NOW()),
    (6, 1, 'They help avoid multiple inheritance in PHP.', 4, NOW()),
    (6, 3, 'Defined using the `trait` keyword.', 3, NOW()),

    (7, 3, 'The `include()` function includes a file and continues on failure.', 3, NOW()),
    (7, 1, 'The `require()` function includes a file but stops on failure.', 2, NOW()),
    (7, 2, 'Use `include()` for optional files, and `require()` for critical dependencies.', 4, NOW()),

    (8, 1, '`new self` always refers to the current class.', 3, NOW()),
    (8, 2, '`new static` respects late static binding and can refer to child classes.', 5, NOW()),
    (8, 3, 'Use `new self` for fixed class references and `new static` for flexibility.', 4, NOW()),

    (9, 2, 'Superglobals are built-in variables accessible globally in PHP.', 4, NOW()),
    (9, 1, '`$_POST`, `$_GET`, and `$_SESSION` are common examples.', 3, NOW()),
    (9, 3, 'They allow data transfer between client and server without manual declaration.', 2, NOW()),

    (10, 1, 'Magic methods are predefined methods in PHP starting with double underscores.', 3, NOW()),
    (10, 3, '`__construct()`, `__get()`, and `__set()` are examples.', 4, NOW()),
    (10, 2, 'They enable custom object behavior during execution.', 5, NOW());

-- Tags
INSERT INTO `tag` (`name`) VALUES
    ('MySQL'),
    ('Python'),
    ('JavaScript'),
    ('Web Development'),
    ('PHP');

-- Question-Tag Relationships
INSERT INTO `rel_question_tag` (`id_question`, `id_tag`) VALUES
    (1, 5),  -- Link "Who is the creator of PHP?" with "PHP" tag
    (2, 5),  -- Link "What is new in the latest version of PHP?" with "PHP" tag
    (3, 5),  -- Link "What are PSRs?" with "PHP" tag
    (4, 5);  -- Link "What is dollar-dollar?" with "PHP" tag
