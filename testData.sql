USE ask_mate_again;

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