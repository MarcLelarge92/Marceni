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

$query = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 12');

$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
?>

<?php require VIEW_PATH . '/layouts/header.php'; ?>


<h1>mon blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title"><?= $post->getName() !== null ? htmlentities($post->getName()) : '' ?></h5>
            <p class="text-muted"><?= $post->getCreatedAt()->format( 'd F Y H:i') ?></p>
            <p><?= $post->getExcerpt() !== null ? $post->getExcerpt() : '' ?></p>
            <p>
                <a href=<?= $router->generate('post', ['id' => $post->getID(),'slug' => $post->getSlug()])?> class="btn btn-primary">Voir plus</a>
            </p>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>

<?php require VIEW_PATH . '/layouts/footer.php'; ?>
