<?php
header('Content-Type: application/x-javascript');

require_once 'includes/db.inc.php';

if (bannedIP($_SERVER['REMOTE_ADDR'])) 
	die();

$basets = mt_rand();
$time = time();
$ts = time();
insertTimestamp($ts);

$dv = rand(1,30);
$rn = rand();
$ts = $ts / 2 . "+$rn-($rn/$dv*$dv)/$dv*$dv+" . $ts / 2;

$js = <<<JS
if (document.getElementById('say') != null)
	var prev = document.getElementById('say').value;
document.getElementById('form').innerHTML = '<form action="say.php" method="post" id="sayform" onsubmit="document.getElementById(\'submit\').value = $ts">
<div>
<input type="text" id="say" name="say" value="' + sayText + '" onclick="clickclear(this, \'' + sayText + '\')" onblur="clickrecall(this,\'' + sayText + '\')" size="30" maxlength="140" />
<input type="submit" id="submit" name="submit" value="Say" class="button" />
<input type="submit" name="refresh" onclick="refreshImage(); return false" class="button" value="Refresh" />
</div>
</form>';
if (prev != null)
	document.getElementById('say').value = prev;
document.getElementById('say').focus();
JS;
$js = str_replace("\r\n",'',$js);

include 'includes/javascriptpacker.inc.php';
$packer = new JavaScriptPacker($js, 'Normal', true, false);
$js = $packer->pack();

echo $js;

?>