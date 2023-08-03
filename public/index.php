<?php 

// autoload
require '../vendor/autoload.php';

// start altorouter 
$router = new AltoRouter();

define('VIEW_PATH',  dirname(__DIR__) . '/views');

$router->map('GET', '/', function(){
    require VIEW_PATH . '/post/index.php';
});

$router->map('GET', '/category', function(){
    require VIEW_PATH . '/category/show.php';
});
$match = $router->match();
var_dump($match); // Vérifier la valeur de $match pour voir s'il y a une correspondance de route.

if ($match && is_callable($match['target'])) {
    call_user_func($match['target']);
} else {
    // Gérer l'absence de correspondance de route ici (afficher une page 404, par exemple).
    // Par exemple : require VIEW_PATH . '/error404.php';
}


?>
