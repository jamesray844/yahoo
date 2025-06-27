<?php
include 'shield.php';

$path = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

switch ($path) {
    case '':
    case 'index.php':
    case 'main.html':
        include 'main.html';
        break;

    case 'scripts.js':
        header('Content-Type: application/javascript');
        readfile('scripts.js');
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
}
?>
