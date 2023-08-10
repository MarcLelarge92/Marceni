<?php
use App\Helpers\Text;
use App\Model\Post;

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
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$currentPage = (int)($_GET['page'] ?? 1) ?: 1;
if ($currentPage <= 0){
    throw new Exception('numero de page invalide');
}

// Exécution d'une requête pour obtenir le nombre total d'enregistrements dans la table 'posts'
$countQuery = $pdo->query('SELECT COUNT(id) FROM posts');
$countResult = $countQuery->fetch(PDO::FETCH_NUM);
$count = (int)$countResult[0]; // Conversion du résultat en nombre entier

// Calcul du nombre total de pages nécessaires pour la pagination (12 éléments par page)
$perPage = 12;
$pages = ceil($count / $perPage);

// Exécution d'une requête pour obtenir les premiers 12 enregistrements dans la table 'posts', triés par date de création
$query = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 12');

$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
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
        <!-- Le contenu de votre page -->
    </div>


    <div class="container mt-4 text-center">
        <h1>Mon blog</h1>
    </div>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title"><?= $post->getName() !== null ? htmlentities($post->getName()) : '' ?></h5>
            <p class="text-muted"><?= $post->getCreatedAt() !== null ? $post->getCreatedAt()->format('d F Y H:i') : '' ?></p>
            <p><?= $post->getExcerpt() !== null ? $post->getExcerpt() : '' ?></p>
            <p>
            <a href="article.php?id=<?= $post->getId() ?>&slug=<?= $post->getSlug() ?>" class="btn btn-primary">Voir plus</a>
            </p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>

<div class="div d-flex justify-content-between mt-4">
    <?php if ($currentPage > 1): ?>
        <a href="<?= $router->generate('Home') ?>?pages=<?= $currentPage - 1 ?>" class="btn btn-primary">&laquo; Pages précédentes</a>
    <?php endif ?>
    <?php if ($currentPage < $pages): ?>
        <a href="<?= $router->generate('Home') ?>?pages=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Pages suivantes &raquo;</a>
    <?php endif ?>
</div>
<footer class="bg-light py-4 footer mt-auto">
            <div class="container">
            </div>    
    </footer>
    </div>
</body>
</html>
