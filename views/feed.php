<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title>Twitter client</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
</head>
<body>


<form action="post" method="post">

    Twit:<br/>
    <textarea name="msg" cols="50" rows="5"></textarea><br/>
    <br/>
    <input type="submit" value="Post twit!"/>

</form>
<?php foreach ($data as $record):
    $msg = nl2br($record['Tweet']['msg']);
    $time_info = time() - $record['Tweet']['datetime'];
    if ($time_info < 60) {
        $datetime = $time_info.'s';
    } elseif ($time_info < 60*60) {
        $datetime = round($time_info/60).'m';
    } elseif ($time_info < 60*60*24) {
        $datetime = round($time_info/(60*60)).'h';
    } else {
        $datetime = date('F j, Y',$record['Tweet']['datetime'] + date('Z'));
    }
    ?>
<hr>
<p>
    <?=$msg?><br>
    </a><i><?=$datetime?></i>
</p>
<hr>
    <?endforeach?>
