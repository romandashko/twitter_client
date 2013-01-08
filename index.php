<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

$url = $_GET['url'];

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'shared.php');

/*session_start();
require_once (ROOT . DS . 'models'. DS . 'twitteroauth' . DS . 'TwitterOAuth.php');
define("CONSUMER_KEY", "qVzF4twxaGqFic9PhaZg");
define("CONSUMER_SECRET", "6XmmtoZWAUj1aZ0s3ZabEmYz6j17eLVBqiVS9NlsTB4");

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
$request_token = $connection->getRequestToken();
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->getAuthorizeURL($request_token);
header('Location: ' . $url);*/




