<?php
require 'post\index.php';

$id = (int)$_GET['id']; // Assurez-vous de valider et de filtrer cette valeur pour des raisons de sécurité
$slug = $_GET['slug'];

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
    $pdo = new PDO($dsn, $user, $psw, $options);

    $query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
    $query->execute(['id' => $id]); // Exécute la requête
    $query->setFetchMode(PDO::FETCH_CLASS, 'Post'); // Assurez-vous de remplacer 'Post' par le nom de votre classe Post
    /** @var Post|false */
    $post = $query->fetch();

    if ($post === false) {
        throw new Exception('Aucun article correspondant');
    }

    if ($post->getSlug() !== $slug) {
        $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]); // Assurez-vous d'ajouter une virgule entre les éléments du tableau
        http_response_code(301);
        header('Location: ' . $url); // Il manquait un point-virgule à la fin de cette ligne
        exit; // Ajoutez ceci pour arrêter l'exécution du script après la redirection
    }
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
    exit; // Arrêtez l'exécution du script en cas d'erreur
}
?>

<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Blog</title>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="#" class="navbar-brand">Mon Site</a>
    </nav>

    <div class="container mt-4">
        <h5><?= htmlentities($post->getName()) ?></h5>
        <p class="text-muted"><?= $post->getCreatedAt() !== null ? $post->getCreatedAt()->format('d F Y H:i') : '' ?></p>
        <p><?= $post->getFormattedContent() !== null ? $post->getFormattedContent() : '' ?></p>

        <footer class="bg-light py-4 footer mt-auto">
            <div class="container">
            </div>
        </footer>
    </div>
</body>
</html>
