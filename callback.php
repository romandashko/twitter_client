<?php
session_start();
require_once 'twitteroauth/TwitterOAuth.php';
define("CONSUMER_KEY", "qVzF4twxaGqFic9PhaZg");
define("CONSUMER_SECRET", "6XmmtoZWAUj1aZ0s3ZabEmYz6j17eLVBqiVS9NlsTB4");
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
    echo 'Session expired';
} else {
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $token_credentials = $connection->getAccessToken();

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $token_credentials['oauth_token'], $token_credentials['oauth_token_secret']);
    $tweetmsg = 'Hello World, I am tweeting from my own twitter app!';
    $result = $connection->post('statuses/update', array('status' => $tweetmsg));
    $httpCode = $connection->http_code;
    if ($httpCode == 200) {
        $resultmsg = 'Tweet Posted: ' . $tweetmsg;
    } else {
        $resultmsg = 'Could not post Tweet.  Error: ' . $httpCode . '  Reason: ' . $result->error;
    }
}