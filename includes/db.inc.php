<?php 
date_default_timezone_set('America/Mexico_City');

$con = mysql_connect("db", "RemoteTweets", "password");
mysql_select_db("RemoteTweets", $con);
  
function insertTweet($tweet, $id) {
	$tweet = mysql_real_escape_string($tweet);
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!$id) {
		$id = 'NULL';
	} else {
		$id = "'$id'";
	}
	mysql_query("INSERT INTO `Tweets` (`tweet`,`ip`,`date`,`id`) VALUES('$tweet','$ip',CURRENT_TIMESTAMP,$id);")
		or die(mysql_error());
	return true;
}

function insertDirect($tweet, $date, $id, $direct) {
	$tweet = mysql_real_escape_string($tweet);
	$date = mysql_real_escape_string($date);
	$id = mysql_real_escape_string($id);
	$direct = mysql_real_escape_string($direct);
	$ip = $_SERVER['REMOTE_ADDR'];
	
	mysql_query("INSERT INTO `Tweets` (`tweet`, `ip`, `date`, `direct`, `id`) VALUES ('$tweet', '$ip', FROM_UNIXTIME($date), '$direct', '$id');")
		or die(mysql_error());
	return true;
}

function getTweets($num) {
	$num = mysql_real_escape_string($num);
	$res = mysql_query("SELECT `tweet`, `direct` FROM `Tweets` ORDER BY `date` DESC LIMIT 0 , $num")
		or die(mysql_error());
	$ret = array();
	
    require_once 'includes/cleantweet.php';      
    
	while($row = mysql_fetch_array($res)){
        if (isset($row['direct'])) {
            $ret[] = array(cleanTweet($row['tweet']), cleantweet($row['direct']));   
        } else {
		    $ret[] = cleanTweet($row['tweet']);
        }
	}
	return $ret;
}

function getLastDirectsID() {
	$res = mysql_query("SELECT `id` FROM `Tweets` WHERE `id`!='' AND `direct`!='' ORDER BY `date` DESC LIMIT 0, 1")
		or die(mysql_error());
	$ret = mysql_fetch_array($res);
	return $ret['id'];
}

function limitByIP($ip) {
	$ip = mysql_real_escape_string($ip);
	$then = time() - 60;
	$res = mysql_query("SELECT `date` FROM `Tweets` WHERE `ip`='$ip' AND `date` >= FROM_UNIXTIME('$then') ORDER BY `date` DESC LIMIT 0, 1")
		or die(mysql_error());
	return mysql_num_rows($res);
}

function limitByTweet($tweet) {
	$tweet = mysql_real_escape_string($tweet);
	$then = time() - 3600;
	$res = mysql_query("SELECT `date` FROM `Tweets` WHERE MATCH(`tweet`) AGAINST('$tweet') AND `date` >= FROM_UNIXTIME('$then') ORDER BY `date` DESC LIMIT 0, 1")
		or die(mysql_error());
	$ret = mysql_fetch_array($res);
	return mysql_num_rows($res) != 0;
}

function insertTimestamp($ts) {
	$ts = mysql_real_escape_string($ts);
	mysql_query("INSERT INTO `Timestamps` (`hash`, `date`) VALUES ('$ts', NOW())")
		or die(mysql_error());
	return true;
}

function clearOldTimestamps() {
	$then = time() - 600;
	mysql_query("DELETE FROM `Timestamps` WHERE `date` <= FROM_UNIXTIME('$then')");
}

function validTimestamp($ts) {
	$ts = mysql_real_escape_string($ts);
	clearOldTimestamps();
	$res = mysql_query("SELECT `hash` FROM `Timestamps` WHERE `hash`='$ts'")
		or die(mysql_error());
	if (!mysql_num_rows($res)) {
		return false;
	} else {
		mysql_query("DELETE FROM `Timestamps` WHERE `hash`='$ts'")
			or die(mysql_error());
		return true;
	}
}

function bannedIP($ip) {
	$ip = mysql_real_escape_string($ip);
	$res = mysql_query("SELECT `ip` FROM `Banned` WHERE `ip`='$ip' LIMIT 0, 1")
		or die(mysql_error());
	$ret = mysql_fetch_array($res);
	return mysql_num_rows($res) != 0;
}

function bannedTweet($tweet) {
    $tweet = mysql_real_escape_string($tweet);
    $res = mysql_query("SELECT `banned` FROM `Banned` WHERE MATCH(`tweet`) AGAINST('$tweet') AND `banned`='1' LIMIT 0, 1")
        or die(mysql_error());
    $ret = mysql_fetch_array($res);
    return mysql_num_rows($res) != 0;
}

?>