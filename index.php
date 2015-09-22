<?php
include 'includes/constants.inc.php';

$err = '';
if (isset($_GET['err'])) {
	$err = $_GET['err'];
	$err = urldecode($err);
	$err = base64_decode($err);
	$err = htmlentities($err); // Keep user data away with a 10-foot pole
	$err = '<strong>' . $err . '</strong><br />';
}                                            

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <title>Random Anonymous Chat Over Twitter!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.6.0/build/reset/reset-min.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="openid.server openid.delegate" href="http://www.google.com/profiles/superstuntguy" />
        <link rel="alternate" href="http://twitter.com/statuses/user_timeline/20517471.rss" title="Messages on Ub3rK1tten.com" type="application/rss+xml" /> 
        <script type="text/javascript">
			var sayText = 'Say something in 140 characters.';
			var imageLocation = '<?php echo IMAGE_LOCATION; ?>';
		</script>
    </head>
	
    <body onload="display()">
        <div id="main" class="center">
        	<?php echo $err ?>
            
            <script type="text/javascript"><!--
            google_ad_client = "pub-2743249987059957";
            /* 728x90 Ub3rK1tten.com homepage */
            google_ad_slot = "2335933641";
            google_ad_width = 728;
            google_ad_height = 90;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script><br />
            
			<div id="form"></div>
			<script type="application/javascript" src="timestamp.php?<?php echo time() ?>"></script>
            
            <div id="imgbackground">
            	<img src="<?php echo IMAGE_LOCATION . time(); ?>" id="feed" width="1024" height="768" alt="ub3rk1ttencom Twitter feed image" />
            </div><br />
            
            <script type="text/javascript"><!--
            google_ad_client = "pub-2743249987059957";
            /* 728x90 Ub3rK1tten.com homepage */
            google_ad_slot = "2335933641";
            google_ad_width = 728;
            google_ad_height = 90;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script><br />
            Twitter @ub3rk1ttencom and it will show up here!<br /><br />
            
            <!-- AddThis Button BEGIN -->
			<script type="text/javascript">var addthis_pub="t3hub3rk1tten";</script>
            <a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
            <!-- AddThis Button END -->

            <a href="http://twitter.com/"><img src="http://search.twitter.com/images/powered-by-twitter-badge.gif" alt="Powered by Twitter" /></a><br />
        </div>
        
   	 	<script type="text/javascript" src="scripts.js"></script>
	</body>
</html>
