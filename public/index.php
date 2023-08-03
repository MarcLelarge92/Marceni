<?php 

// autoload

require '../vendor/autoload.php';


// start altorouter 
$router = new AltoRouter();

define('VIEW_PATH',  dirname(__DIR__) . '/views');

$router->map('GET', '/marceni.blog', function(){
    require VIEW_PATH . '/post/index.php';
});

$router->map('GET', '/marceni.blog/category', function(){
    require VIEW_PATH . '/category/show.php';
});

$match = $router->match();
$match['target']();

?>
