<?php 

// DB conn

require 'connDb.php';

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE users_posts");
$pdo->exec("TRUNCATE posts_comments");
$pdo->exec("TRUNCATE posts_categories");
$pdo->exec("TRUNCATE users");
$pdo->exec("TRUNCATE posts");
$pdo->exec("TRUNCATE comments");
$pdo->exec("TRUNCATE categories");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
echo 'Database Tables deleted succesfully!';

echo 'Database Tables were cleaned succesfully!';