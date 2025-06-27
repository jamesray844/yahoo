<?php


if (php_sapi_name() === 'cli-server' || isset($_SERVER['HTTP_X_SKIP_SHIELD'])) {
    return;
}


$uri = $_SERVER['REQUEST_URI'];
$extension = pathinfo(parse_url($uri, PHP_URL_PATH), PATHINFO_EXTENSION);
$static_exts = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'css', 'js'];
if (in_array(strtolower($extension), $static_exts)) {
    return;
}


$ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$blacklist = [
    'bot', 'crawl', 'slurp', 'spider', 'curl', 'wget',
    'python', 'php', 'go-http-client', 'axios', 'node', 'java',
    'headless', 'scrapy', 'phantomjs', 'powershell', 'winhttp'
];
foreach ($blacklist as $keyword) {
    if (strpos($ua, $keyword) !== false) {
        http_response_code(403);
        exit("Access denied.");
    }
}


$required_headers = ['HTTP_ACCEPT', 'HTTP_ACCEPT_LANGUAGE', 'HTTP_USER_AGENT'];
foreach ($required_headers as $header) {
    if (empty($_SERVER[$header])) {
        http_response_code(403);
        exit("Access denied.");
    }
}
?>
