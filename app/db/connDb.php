<?php

$host = 'localhost';
$db = 'marceni';
$user = 'root';
$psw = '2904';
$port = '3306';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


try {
    $pdo = new \PDO($dsn, $user, $psw, $options);
    echo 'Database connexion established! - ';
}catch (\PDOEXception $e){
    throw new \PDOEXception ($e->getMessage(), $e->getCode());
}