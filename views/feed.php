
<em><?php echo "You are logged in under the name: ".$account?></em>
<br/>
<form action="post" method="post">

    <br/>
    <textarea name="msg" cols="50" rows="5"></textarea><br/>

    <input type="submit" value="Tweet!"/>

</form>
<br/>
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
