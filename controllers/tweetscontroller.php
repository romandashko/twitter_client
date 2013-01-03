<?php

class TweetsController extends Controller
{

    function feed()
    {
        $this->set('title', 'Twitter client');
        $this->set('data', $this->TweetsModel->selectAll());
    }

    function add($FieldValuePairs)
    {
        $this->TweetsModel->insert($FieldValuePairs);
    }

    public function post()
    {
        if (array_key_exists('msg', $_POST) && isset($_POST['msg'])) {
            $msg = clearData($_POST['msg']);

            $connection = $this->TweetsModel->post_tweet($msg);
            $code = $connection->response['code'];
            $datetime = $connection->config['timestamp'];

            if ($code == 200) {
                $FieldValuePairs = array('msg' => $msg, 'datetime' => $datetime);
                $this->add($FieldValuePairs);
            }else{
                echo 'Failed to post tweet!';
            }
            $this->feed();
            $this->_template->_action = 'feed';
        }
    }
}
