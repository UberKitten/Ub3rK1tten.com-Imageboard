<?php
chdir('../');

require_once 'includes/db.inc.php';

$imwidth = 1024;
$imheight = 768;
$font = 'includes/segoepr.ttf';
$spacing = 1.25;
$gaussian = array(array(1.0, 2.0, 1.0), array(2.0, 4.0, 2.0), array(1.0, 2.0, 1.0));

$image = imagecreatetruecolor($imwidth,$imheight);
$black = imagecolorallocate($image,0,0,0);
$white = imagecolorallocate($image,255,255,255);
$blackblur = imagecolorallocatealpha($image, 0,0,0,115);
$blackblurfg = imagecolorallocatealpha($image, 0,0,0,50);

imagefill($image,0,0,$black);

$statuses = array_reverse(getTweets(100));

$i = 0;
foreach($statuses as $status) {
	$i += 1;
	$size = 10 + (14 / count($statuses));
	if (count($statuses) == $i) {
		$size += 6;
	} elseif (count($statuses) - 1 == $i) {
		$size += 4;
	} elseif (count($statuses) - 2 == $i) {
		$size += 2;
	}
	$angle = 0;
	$x = 0;
	$y = 0;
    $direct = '';
    
    if (is_array($status)) {
        $direct = $status[1];
        $status = $status[0];    
    }
    
	$length = strlen($status);    
	$text = explode("\n", wordwrap($status, 40,"\n", true));
	$height = (count($text) * $size * $spacing) - $spacing;
	$width = 0;
	
	for($j=0; $j < count($text); $j++) {
		$bbox = @imagettfbbox($size, $angle, $font, $text[$j]);
		$width = max($width, abs($bbox[4] - $bbox[0]));
	}

	$x = mt_rand(0, $imwidth - $width);
	$y = mt_rand(0, $imheight - $height); 
	
	if (count($statuses) == $i)
        imageconvolution($image, $gaussian, 16, 0);
	if (count($statuses) - 10 == $i)
        imageconvolution($image, $gaussian, 16, 0);
	if (count($statuses) - 20 == $i)
        imageconvolution($image, $gaussian, 16, 0);
	
	for($j=0; $j < count($text); $j++) {
		$newY = $y + $size + ($j * $size * $spacing);
		@imagettftext($image, $size, $angle, $x, $newY, $white, $font, $text[$j]);
	}
	imagefilledrectangle($image, $x, $y, $imwidth, $imheight, $blackblur);
}

@header('Content-Type: image/png');
imageinterlace($image, 1);
imagejpeg($image);

include_once 'includes/cron.inc.php';

?>