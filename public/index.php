<?php 

// autoload

require '../vendor/autoload.php';

$url = '';

if(isset($_GET['url'])) {
   $url =explode('/', $_GET ['url']);
   var_dump($url);
}