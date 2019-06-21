<?php

require_once 'MainController.php';
require_once 'config.php';

// route the request internally


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$patternPoll = '/\/polls\/poll\/([a-zA-Z0-9_-]+)/';
$patternResult = '/\/polls\/get_result\/([a-zA-Z0-9_-]+)/';

$pdo = new PDO(
    $configuration['db_dsn'],
    $configuration['db_user'],
    $configuration['db_pass']
);

$mc = new MainController($pdo);

if ($uri === '/polls/create') {
    $mc->createAction();
} elseif (preg_match($patternPoll, $uri)) {
    $hash = substr($uri, strrpos($uri, '/') + 1);
    $mc->pollAction($hash);
} elseif (preg_match($patternResult, $uri)) {
    $hash = substr($uri, strrpos($uri, '/') + 1);
    $mc->getResult($hash);
} elseif ($uri === '/polls/send_result') {
    $mc->sendResult();
} elseif ($uri === '/polls/set_cookie') {
    $mc->setCookies();
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}