<?php
if ($_SERVER['SERVER_NAME'] == 'test.ub3rk1tten.com') { 
    define('PRODUCTION', 0);
    define('IMAGE_LOCATION', 'image/?');
    define('INCLUDE_PATH', 'C:\Users\T3h Ub3r K1tten\Files\Random Junk\Ub3rK1ttencom\includes\\');
} else {
    define('PRODUCTION', 1);
    define('IMAGE_LOCATION', 'http://image.ub3rk1tten.com/image.jpeg?');
}
  
?>
