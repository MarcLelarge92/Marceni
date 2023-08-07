<?php 

// autoload

require '../vendor/autoload.php';

// start altorouter 
$router = new AltoRouter();

define('VIEW_PATH', dirname(__DIR__) . '/views');

$router->map('GET', '/', function() {
    require VIEW_PATH . '/post/index.php';
}, 'home');

$router->map('GET', '/category', function() {
    require VIEW_PATH . '/category/show.php';
}, 'category');

$match = $router->match();

if ($match) {
    call_user_func($match['target']);
} else {
    echo "Page non trouvée (404)";
}

