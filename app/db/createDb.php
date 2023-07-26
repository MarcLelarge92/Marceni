<?php 

// DB connection 

require 'connDb.php';

// create users tables

$pdo->exec("CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username VARCHAR(255) NOT NULL,
    password char(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    ft_image VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    role ENUM ('Author', 'Admin', 'Subscriber') NULL DEFAULT 'Subscriber',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'Tables :USERS,';

// create posts tables

$pdo->exec("CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id int DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    ft_image VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published TINYINT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'POSTS,';

// create comments  tables

$pdo->exec("CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    email VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published TINYINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'COMMENTS,';

// create categories tables

$pdo->exec("CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    ft_image VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'CATEGORIES,';


// create posts_comments tables

$pdo->exec("CREATE TABLE posts_comments (
    post_id INT UNSIGNED NOT NULL,
    comment_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, comment_id),
    CONSTRAINT fk_post
        FOREIGN KEY (post_id)
        REFERENCES posts (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_comment
        FOREIGN KEY (comment_id)
        REFERENCES comments (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
)DEFAULT CHARSET=utf8mb4");

echo 'POSTS_COMMENTS,';

// create users_posts tables

$pdo->exec("CREATE TABLE users_posts (
    user_id INT UNSIGNED NOT NULL,
    post_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, post_id),
    CONSTRAINT fk_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_post
        FOREIGN KEY (post_id)
        REFERENCES posts (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
)DEFAULT CHARSET=utf8mb4");

echo 'USERS_POSTS,';

// create posts_categories tables

$pdo->exec("CREATE TABLE posts_categories (
    post_id INT UNSIGNED NOT NULL,
    categorie_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, categorie_id),
    CONSTRAINT fk_post
        FOREIGN KEY (post_id)
        REFERENCES posts (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_categorie
        FOREIGN KEY (categorie_id)
        REFERENCES categories (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
)DEFAULT CHARSET=utf8mb4");

echo 'POSTS_CATEGORIES,';