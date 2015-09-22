<?php
flush();
include_once 'includes/cleantweet.php';
include_once 'db.inc.php';                

$lastupdate = file_get_contents(getcwd() . '/lastupdate.txt');
if (time() - $lastupdate > 15) {
	fwrite(fopen('lastupdate.txt', 'w'), time());
	$xml = new SimpleXMLElement(file_get_contents('http://search.twitter.com/search.atom?q=%40Ub3rK1ttencom&since_id='.getLastDirectsID()));
	
	if (count($xml->entry)) {
		$entries = array();
		foreach($xml->entry as $entry) {
			$entries[] = $entry;
		}
		$entries = array_reverse($entries);
		
		if (count($entries) > 0) {
			foreach($entries as $entry) {
				$id = explode(':', $entry->id);
				$id = $id[count($id)-1];
				$date = strtotime($entry->updated);
				if (strtolower(substr($entry->title, 14)) == '@ub3rk1ttencom') {
					$title = substr($entry->title, 14);
				} else {
					$title = $entry->title;	
				}
				
				insertDirect($title, $date, $id, $entry->author->name);
			}
		}
	}
}

clearOldTimestamps();

?>