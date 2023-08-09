<?php 

// autoload

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// start altorouter 
$router = new AltoRouter();

define('VIEW_PATH', dirname(__DIR__) . '/views');

//var_dump(VIEW_PATH);

$router->map('GET', '/', function() {
    require VIEW_PATH . '/category/show.php';
}, 'category');

//var_dump(VIEW_PATH . '/category/show.php');
$router->map('GET', '/index', function() {
    require VIEW_PATH . '/post/index.php';
}, 'Home');


$match = $router->match();

if ($match) {
    call_user_func($match['target']);
} else {
    echo "Page non trouvée (404)";
}

