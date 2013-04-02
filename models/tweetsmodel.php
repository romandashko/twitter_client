<?php
class TweetsModel extends Model {

    public function getRequestToken() {

        $tmhOAuth = new tmhOAuth(array(
            'consumer_key'    => CONSUMER_KEY,
            'consumer_secret' => CONSUMER_SECRET,
        ));
        $tmhOAuth->request('POST', $tmhOAuth->url('oauth/request_token', ''), array(
            'oauth_callback' => 'oob',
        ));

        $code = $tmhOAuth->response['code'];

        if ($code == 200) {
            $oauth_creds = $tmhOAuth->extract_params($tmhOAuth->response['response']);

            $tmhOAuth->config['user_token']  = $oauth_creds['oauth_token'];
            $tmhOAuth->config['user_secret'] = $oauth_creds['oauth_token_secret'];

            session_start();
            $_SESSION["authtoken"] = $oauth_creds['oauth_token'];
            $_SESSION["authsecret"] = $oauth_creds['oauth_token_secret'];

            $request_link = $tmhOAuth->url('oauth/authorize', '') . "?oauth_token={$oauth_creds['oauth_token']}";
            return $request_link;

        } else {
            echo "There was an error communicating with Twitter. {$tmhOAuth->response['response']}" . PHP_EOL;
        }
    }

    public function getAccessToken() {

        $pin = $_GET['pin'];
        session_start();
        $request_token = $_SESSION["authtoken"];
        $request_token_secret = $_SESSION["authsecret"];

        $tmhOAuth = new tmhOAuth(array(
            'consumer_key'    => CONSUMER_KEY,
            'consumer_secret' => CONSUMER_SECRET,
        ));

        $tmhOAuth->config['user_token']  = $request_token;
        $tmhOAuth->config['user_secret'] = $request_token_secret;

        $code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/access_token', ''), array(
            'oauth_verifier' => trim($pin)
        ));

        if ($code == 200) {
            $oauth_creds = $tmhOAuth->extract_params($tmhOAuth->response['response']);

            $_SESSION['USER_TOKEN'] = $oauth_creds['oauth_token'];
            $_SESSION['USER_SECRET'] = $oauth_creds['oauth_token_secret'];
            define("USER_TOKEN", $_SESSION['USER_TOKEN']);
            define("USER_SECRET", $_SESSION['USER_SECRET']);
            $_SESSION["account"] = $oauth_creds['screen_name'];
            return $_SESSION["account"];
        } else {
            echo "There was an error communicating with Twitter. {$tmhOAuth->response['response']}" . PHP_EOL;
        }
    }

    public function postTweet($msg) {

        $msg = clearData($msg);
        $msg = substr($msg, 0, 140);

        session_start();

        define("USER_TOKEN", $_SESSION['USER_TOKEN']);
        define("USER_SECRET", $_SESSION['USER_SECRET']);

        $tmhOAuth = new tmhOAuth(array(
            'consumer_key' => CONSUMER_KEY,
            'consumer_secret' => CONSUMER_SECRET,
            'user_token' => USER_TOKEN,
            'user_secret' => USER_SECRET,
            'debug' =>true
        ));

        $tmhOAuth->request('POST',
            $tmhOAuth->url('1/statuses/update'),
            array('status' => $msg));
        $code = $tmhOAuth->response['code'];
        $datetime = $tmhOAuth->config['timestamp'];
        if ($code == 200) {
            $FieldValuePairs = array('msg' => $msg, 'datetime' => $datetime, 'user_token' => USER_TOKEN, 'user_secret' => USER_SECRET);
            $this->insert($FieldValuePairs);
            return $_SESSION["account"];
        }
        else {
            echo "There was an error communicating with Twitter. {$tmhOAuth->response['response']}" . PHP_EOL;
        }
    }
}