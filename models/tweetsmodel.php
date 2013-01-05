<?php

class TweetsModel extends Model {

    function post_tweet($tweet_text) {

        require_once('tmhoauth/tmhOAuth.php');

        $connection = new tmhOAuth(array(
            'consumer_key' => 'qVzF4twxaGqFic9PhaZg',
            'consumer_secret' => '6XmmtoZWAUj1aZ0s3ZabEmYz6j17eLVBqiVS9NlsTB4',
            'user_token' => '801026443-WpiPr9v6HszcBuKWqw5XrHvGIiuudyzRTdPzwdb6',
            'user_secret' => '8SUwVZzkUHKN0bOLyuaqkD4uxsUSKGPIaJk0Bhr5Lg',
            'debug' =>true
        ));

        $connection->request('POST',
            $connection->url('1/statuses/update'),
            array('status' => $tweet_text));

        //return $connection->response['code'];
        return $connection;
    }


}
