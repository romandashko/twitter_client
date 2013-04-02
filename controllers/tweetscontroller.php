<?php

class TweetsController extends Controller
{

    function sign_in()
    {
        $this->set('title', 'Twitter client');
        $this->set('url', $this->TweetsModel->getRequestToken());
    }

    function getAccessToken()
    {
        $this->set('account', $this->TweetsModel->getAccessToken());
        //$this->TweetsModel->getAccessToken();
        $this->feed();
        $this->_template->_action = 'feed';
    }

    function feed()
    {
        $this->set('title', 'Twitter client');
        $this->set('data', $this->TweetsModel->select());
    }

    function add($FieldValuePairs)
    {
        $this->TweetsModel->insert($FieldValuePairs);
    }

    public function post()
    {
        if (array_key_exists('msg', $_POST) && isset($_POST['msg'])) {
            $this->set('account', $this->TweetsModel->postTweet($_POST['msg']));
            //$this->TweetsModel->postTweet($_POST['msg']);
            $this->feed();
            $this->_template->_action = 'feed';
        }
    }
}
