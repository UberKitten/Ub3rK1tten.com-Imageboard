<?php

if (!isset($_POST['say']))
	die('Holy Jehosaphat!');

require_once 'includes/cleantweet.php';
require_once 'includes/db.inc.php';      

if (bannedIP($_SERVER['REMOTE_ADDR'])) 
	die();
	
$err = '';

$stat = cleantweet($_POST['say']);

$last = getTweets(1);

if (strlen($stat) > 140) {
	$err = 'That was longer than 140 characters!';
} elseif ($stat == 'Say something in 140 characters.' || $stat == '') {
	$err = 'Umm... You didn\'t exactly say anything...';                          
} elseif (!validTimestamp($_POST['submit'])) {
	$err = 'Whoa! Something weird just happened. Try again, I guess? (Debug ' . intval($_POST['submit']) . ')';	
} elseif (bannedTweet($stat)) {
    $err = 'Sorry, I just can\'t post that.';
}
    
if ($err == '') {
	require_once 'includes/twitter.inc.php';
	$tw = new Twitter('ub3rk1ttencom', 'oopsiesthisgotleaksied');
	$rets = false;
    $exc = false;
	try {
		$ret = $tw->updateStatus(stripslashes($stat));
		$rets = $ret['id'];
	} catch (TwitterException $ex) {
		$err = 'Uh oh! Twitter appears to be having problems right now. Anything you say won\'t go on Twitter, sadly.';
        $exc = true;
	}
    if ($exc) { // Fail safe if Twitter down
	    insertTweet($stat, $rets);
    } else {
        if ($rets != '') // If Twitter rejects, we reject
            insertTweet($stat, $rets);
    }
}

if ($err == '') {
	header('Location: index.php');
} else {
	header('Location: index.php?&err=' . urlencode(base64_encode($err)));
}

?>