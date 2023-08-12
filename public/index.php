<?php 

// Inclusion du fichier d'autoload pour charger automatiquement les classes nécessaires
require '../vendor/autoload.php';

// Création d'un gestionnaire d'erreurs Whoops pour un meilleur rapport d'erreurs
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Initialisation de AltoRouter pour gérer les routes
$router = new AltoRouter();

// Définition d'une constante pour le chemin du répertoire des vues
define('VIEW_PATH', dirname(__DIR__) . '/views');

// Association d'une route pour l'URL racine ("/") à une fonction de rappel
$router->map('GET', '/', function() {
    // Inclusion du fichier de vue 'show.php' pour la route 'category'
    require VIEW_PATH . '/category/show.php';
}, 'category');

// Association d'une route pour l'URL '/index' à une fonction de rappel
$router->map('GET', '/index', function() use ($router) {
    // Inclusion du fichier de vue 'index.php' pour la route 'Home'
    require VIEW_PATH . '/post/index.php';
}, 'Home');

$router->map('GET', '/[*:slug]-[i:id]', function() use ($router){
    // Inclusion du fichier de vue 'index.php' pour la route 'Home'
    require VIEW_PATH . '/public/show.php';
}, 'Article');

// Tentative de correspondance de l'URL actuelle à une route définie dans le routeur
$match = $router->match();

// Si une route correspondante est trouvée
if ($match) {
    // Appel de la fonction de rappel associée à la route correspondante
    call_user_func($match['target']);
} else {
    // Affichage d'un message d'erreur 404 si aucune route correspondante n'est trouvée
    echo "Page non trouvée (404)";
}
