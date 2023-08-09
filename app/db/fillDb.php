<?php

require dirname(__DIR__) . '../../vendor/autoload.php';


$faker = Faker\Factory::create('fr_FR');

require 'connDb.php';

$posts = [];
$categories = [];
$comments = [];
$users = [];


// clean db 

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE posts_categories");
$pdo->exec("TRUNCATE TABLE posts_comments");
$pdo->exec("TRUNCATE TABLE users_posts");
$pdo->exec("TRUNCATE TABLE users");
$pdo->exec("TRUNCATE TABLE posts");
$pdo->exec("TRUNCATE TABLE categories");
$pdo->exec("TRUNCATE TABLE comments");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

echo 'Database Tables cleaned succesfully!';

// create fake users

$hashPassword = null;
for ($i = 0; $i < 13; $i++) {
    $hashPassword = password_hash($faker->password, PASSWORD_BCRYPT);
    $pdo->exec("INSERT INTO users
                SET username= '{$faker->userName}',
                    password= '{$hashPassword}',
                    slug= '{$faker->slug}',
                    ft_image='images{$faker->numberBetween($min = 1, $max = 5)}',
                    content='{$faker->paragraphs(rand(3, 15), true)}',
                    email='{$faker->email}',
                    phone='{$faker->e164PhoneNumber}',
                    role='Subscriber',
                    created_at='{$faker->date} {$faker->time}'
                    ");
                    
    $users[] = $pdo->lastInsertId();
}


echo 'USER Done!';


// create admin


$hashPassword = password_hash('test', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO users
            SET username= 'MarcL',
                password= '{$hashPassword}',
                slug= 'Marceni',
                ft_image='images{$faker->numberBetween($min = 1, $max = 5)}.jpg',
                content='{$faker->paragraphs(rand(3, 15), true)}',
                email='{$faker->email}',
                phone='{$faker->e164PhoneNumber}',
                role='Admin',
                created_at='{$faker->date} {$faker->time}'
                ");

echo 'Admin!';

// create article


for ($i = 0; $i < 72; $i++) {
    $pdo->exec("INSERT INTO posts
                SET user_id= '14',
                    title=  '{$faker->sentence(2)}',
                    slug= '{$faker->slug}',
                    ft_image='images{$faker->numberBetween($min = 1, $max = 5)}.jpg',
                    content='{$faker->paragraphs(rand(3, 15), true)}',
                    created_at='{$faker->date} {$faker->time}',
                    published='1'
                    ");
                    
    $posts[] = $pdo->lastInsertId();
}

echo 'POSTS!';

// creation comments

for ($i = 0; $i < 144; $i++) {
    $pdo->exec("INSERT INTO comments
                SET pseudo= '{$faker->userName}',
                    email= '{$faker->email}',
                    title=  '{$faker->sentence(2)}',
                    content='{$faker->paragraphs(rand(3, 15), true)}',
                    created_at='{$faker->date} {$faker->time}',
                    published='1'
                    ");
                    
    $comments[] = $pdo->lastInsertId();
}

echo 'COMMENTS!';

// creation categories

for ($i = 0; $i < 15; $i++) {
    $pdo->exec("INSERT INTO categories
                SET title=  '{$faker->sentence(2)}',
                    slug= '{$faker->slug}',
                    content='{$faker->paragraphs(rand(3, 15), true)}',
                    ft_image='images{$faker->numberBetween($min = 1, $max = 5)}.jgp'
                    ");
                    
    $categories[] = $pdo->lastInsertId();
}

echo 'CATEGORIES!';


// link post with categories

foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(1, 1));
    foreach ($randomCategories as $categorie) {
        $pdo->exec("INSERT INTO posts_categories SET post_id=$post, categorie_id=$categorie");
    }
}

echo 'POSTS_CATEGORIES!';


// link post with admin comment

foreach ($posts as $post) {
    $randomComments = $faker->randomElements($comments, rand(2, 2));
    foreach ($randomComments as $comment) {
        $pdo->exec("INSERT INTO posts_comments (post_id, comment_id) VALUES ($post, $comment)");
    }
}

echo 'POSTS_COMMENTS!';




// link post with admin user

foreach ($posts as $post) {
        $pdo->exec("INSERT INTO users_posts SET user_id='14', post_id=$post");
    }

echo 'USERS_POSTS were created succesfuly!';