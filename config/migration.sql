CREATE TABLE IF NOT EXISTS `users` (  
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `name` varchar(30) NOT NULL,  
  `email` varchar(128) NOT NULL UNIQUE,  
  `password` varchar(128) NOT NULL,  
   PRIMARY KEY (`id`)  
);

CREATE TABLE IF NOT EXISTS 'todos' (
    `id` int(11) NOT NULL AUTO_INCREMENT,  
    `title` varchar(30) NOT NULL,
    `description` varchar(256),
    `is_done` BOOLEAN DEFAULT 0,
    `user_id` int(11),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE IF NOT EXISTS 'roles'(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS 'user_roles'(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` varchar(128) NOT NULL,
    `role_id` varchar(128) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
);