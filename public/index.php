<?php 

// autoload

require '../vendor/autoload.php';

// active debug 
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// start altorouter 
$router = new AltoRouter();

// map routes
$router->map('GET', '/','index','index');
$router->map('GET', '/Contact','contact','contact'); 
$router->map('GET', '/404','404','404'); 
$router->map('GET', '/show','show','show');

// match routes

$match = $router->match();

if (is_array($match)) {
    // Match found
    $params = $match['params'];

    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $params);
    } else {
        ob_start();
        include "../app/views/{$match['target']}.view.php";
        $pageContent = ob_get_clean();
    }
} else {
    // No match found, show 404 page
    include "../app/views/404.view.php";
    $pageContent = ob_get_clean();
}

// select layout

include '../app/views/layouts/default.view.php';
